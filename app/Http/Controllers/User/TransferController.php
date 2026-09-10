<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\NewNotification;
use App\Models\Settings;
use App\Models\SettingsCont;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tp_Transaction;
use App\Notifications\AccountNotification;
use App\Traits\PingServer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TransferController extends Controller
{
    use PingServer;

    public function transfertouser(Request $request)
    {
        $receiver = User::where('email', $request->email)->orWhere('username', $request->email)->orWhere('accountid', $request->email)->first();
        $sender = Auth::user();
        $settings = Settings::find(1);

        $settingss = SettingsCont::find(1);
        $charges = $request->amount * $settingss->transfer_charges / 100;
        $todeduct = $request->amount + $charges;

        if (!Hash::check($request->password, $sender->password)) {
        return response()->json([
        'status' => 419,
        'message' => 'Incorrect Password',
        ]);
        }

        if (!$receiver) {
        return response()->json([
        'status' => 419,
        'message' => 'No user with this email address or username exist',
        ]);
        }

        if ($sender->email == $receiver->email or $sender->username == $receiver->username or $sender->accountid == $receiver->accountid) {
        return response()->json([
        'status' => 419,
        'message' => 'You cannot send funds to yourself',
        ]);
        }


        if ($sender->account_bal < $todeduct) {
        return response()->json([
        'status' => 419,
        'message' => 'Insufficient Funds',
        ]);
        }

        $user = User::find(Auth::user()->id);
        $user->account_bal = $sender->account_bal - $todeduct;
        $user->save();

        User::where('email', $request->email)->orWhere('username', $request->email)->orWhere('accountid', $request->email)->update([
        'account_bal' => $receiver->account_bal + $request->amount,
        ]);

        //create history
        Tp_Transaction::create([
        'user' => $sender->id,
        'plan' => "Transfered to $receiver->name",
        'amount' => $request->amount,
        'type' => "Fund Transfer",
        'remark' => $request->remark,
        'from' => $request->transfer_from,
        'to' => $request->transfer_to,
        ]);

        //create history for receiver
        Tp_Transaction::create([
        'user' => $receiver->id,
        'plan' => "Received from $sender->name",
        'amount' => $request->amount,
        'type' => "Fund Transfer",
        'remark' => $request->remark,
        'from' => $request->transfer_from,
        'to' => $request->transfer_to,
        ]);


        $message = "You just received $settings->currency$request->amount from $sender->name <strong>Remark is :</strong> $request->remark";
        $message2 = "You just send fund $settings->currency$request->amount to  $receiver->name <strong>Remark is :</strong> $request->remark";
        $user->notify(new AccountNotification($message, 'Transfer is successful'));

        Mail::to($receiver->email)->send(new NewNotification($message, 'Credit Alert', $receiver->name .' '.$receiver->accountid));

        Mail::to($sender->email)->send(new NewNotification($message2, 'Debit Alert', $sender->name.' '.$sender->accountid));


        Mail::to($settings->contact_email)->send(new NewNotification($message, 'Credit Alert', $receiver->name));
        Mail::to($settings->contact_email)->send(new NewNotification($message2, 'Debit Alert', $sender->name));

        return response()->json([
        'status' => 200,
        'message' => 'Transfer Completed, Refreshing page',
        ]);
    }


    public function renewSignalSub()
    {
        $user = User::find(Auth::user()->id);
        $response = $this->fetctApi('/subscription', [
            'id' => auth()->user()->id
        ]);
        $res = json_decode($response);
        $sub = $res->data;

        $responseSt = $this->fetctApi('/signal-settings');
        $info = json_decode($responseSt);
        $settings = $info->data->settings;

        if ($sub->subscription == 'Monthly') {
            $amount = $settings->signal_monthly_fee;
        } elseif ($sub->subscription == 'Quarterly') {
            $amount = $settings->signal_quartly_fee;
        } else {
            $amount = $settings->signal_yearly_fee;
        }

        if ($user->account_bal <  floatval($amount)) {
            return redirect()->back()->with('message', 'Your have insufficient funds in your account balance to perform this operation');
        }

        $renew =  $this->fetctApi('/renew-subscription', [
            'id' => $user->id,
        ], 'POST');

        if ($renew->successful()) {
            $user->account_bal = $user->account_bal - floatval($amount);
            $user->save();
            $user->notify(new AccountNotification("Your subscription have been renewed successfully. {$settings->currency}{$amount}", 'Signal renewal'));

            return redirect()->back()->with('success', 'Your subscription have been renewed successfully.');
        }
        return redirect()->back()->with('Something went wrong');
    }
}
