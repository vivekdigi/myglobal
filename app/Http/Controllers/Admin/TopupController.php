<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Settings;
use App\Models\Tp_Transaction;
use App\Models\User;
use App\Notifications\AccountNotification;
use App\Traits\PingServer;
use Illuminate\Http\Request;

class TopupController extends Controller
{
    use PingServer;

    //top up route
    public function topup(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'amount' => 'required|numeric|min:0.01',
        'type' => 'required|string',
        't_type' => 'required|string|in:Credit,Debit',
    ]);

    $user = User::findOrFail($request->user_id);
    $amount = $request->amount;
    $type = $request->type;
    $tType = $request->t_type;

    // Get current values
    $account_bal = $user->account_bal;
    $bonus = $user->bonus;
    $roi = $user->roi;
    $ref_bonus = $user->ref_bonus;

    // Determine which field to update
    switch ($type) {
        case 'Bonus':
            $newVal = ($tType === 'Credit') ? $bonus + $amount : $bonus - $amount;
            $user->bonus = max(0, $newVal);
            break;

        case 'Profit':
            $newVal = ($tType === 'Credit') ? $roi + $amount : $roi - $amount;
            $user->roi = max(0, $newVal);
            break;

        case 'Ref_Bonus':
            $newVal = ($tType === 'Credit') ? $ref_bonus + $amount : $ref_bonus - $amount;
            $user->ref_bonus = max(0, $newVal);
            break;

        case 'balance':
        case 'Account Balance':
            $newVal = ($tType === 'Credit') ? $account_bal + $amount : $account_bal - $amount;
            $user->account_bal = max(0, $newVal);
            break;

        case 'Deposit':
            if ($tType === 'Debit') {
                return back()->with('error', 'You cannot debit the Deposit column.');
            }

            $deposit = new Deposit();
            $deposit->amount = $amount;
            $deposit->payment_mode = 'Admin Deposit';
            $deposit->status = 'Processed';
            $deposit->plan = $request->user_pln ?? 'N/A';
            $deposit->user = $user->id;
            $deposit->save();

            $user->account_bal += $amount;
            break;

        default:
            return back()->with('error', 'Invalid type selected.');
    }

    // Save updated user balance
    $user->save();

    // Record transaction history
    Tp_Transaction::create([
        'user' => $user->id,
        'plan' => $type,
        'amount' => $amount,
        'type' => $tType,
    ]);

    // Send notification
    $currency = Settings::value('currency');
    $message = "Your account has been {$tType}ed with {$currency}{$amount} to {$type}.";
    // $user->notify(new AccountNotification($message, 'System Topup'));

    return redirect()->back()->with('success', 'Balance updated successfully!');
}
    public function topup_old(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $user_bal = $user->account_bal;
        $user_bonus = $user->bonus;
        $user_roi = $user->roi;
        $user_Ref = $user->ref_bonus;

        $response = $this->callServer('typesystem', '/top-up', [
            'topUpType' => $request->t_type,
            'userBalance' => $user_bal,
            'userRoi' => $user_roi,
            'userRef' => $user_Ref,
            'userBonus' => $user_bonus,
            'type' => $request->type,
            'amount' => $request->amount,
        ]);

        if ($response->failed()) {
            return redirect()->back()->with('message', $response['message']);
        }

        $formatResponse = json_decode($response);

        if ($formatResponse->data->whatType == "Bn2r5u8x/A?D(G+KbPeShVkYp3s6v9yonus") {
            User::where('id', $request['user_id'])
                ->update([
                    'bonus' => $formatResponse->data->bonus,
                    'account_bal' => $formatResponse->data->accountBalance,
                ]);
        } elseif ($formatResponse->data->whatType == "8y/A?D(G+KbPeSmYq3t6w9zC&E)H@Mc") {
            User::where('id', $request->user_id)
                ->update([
                    'roi' => $formatResponse->data->profit,
                    'account_bal' =>  $formatResponse->data->accountBalance,
                ]);
        } elseif ($formatResponse->data->whatType == "H+MbQeThWmZq3t6w9zC&F)J@NcRfUjX") {
            User::where('id', $request->user_id)
                ->update([
                    'ref_bonus' => $formatResponse->data->refBonus,
                    'account_bal' =>  $formatResponse->data->accountBalance,
                ]);
        } elseif ($formatResponse->data->whatType == "A?D(G+KbPeShVkYp3s6v9yB&E)H@Mc") {
            User::where('id', $request->user_id)
                ->update([
                    'account_bal' =>  $formatResponse->data->accountBalance,
                ]);
        } elseif ($formatResponse->data->whatType == "4u7x!A%C*F-JaNdRgUkXp2s5v8y/B?E(" and $formatResponse->data->truth) {

            $dp = new Deposit();
            $dp->amount = $request['amount'];
            $dp->payment_mode = 'Express Deposit';
            $dp->status = 'Processed';
            $dp->plan = $request['user_pln'];
            $dp->user = $request['user_id'];
            $dp->save();

            User::where('id', $request['user_id'])
                ->update([
                    'account_bal' =>  $formatResponse->data->accountBalance,
                ]);
        }

        $currency = Settings::select('currency')->find(1);

        // Send notification to user
        // $user->notify(new AccountNotification("You have a new {$request->type} transaction. Amount: {$currency}{$request->amount}.", 'System Topup'));

        //add history
        Tp_Transaction::create([
            'user' => $request->user_id,
            'plan' => $formatResponse->data->type,
            'amount' => $request->amount,
            'type' => $request->type,
        ]);


        return redirect()->back()->with('success', 'Action Successful!');
    }
}
