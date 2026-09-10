<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Settings;
use App\Models\Deposit;
use App\Models\Tp_Transaction;
use App\Mail\DepositStatus;
use App\Notifications\AccountNotification;
use App\Services\ReferralCommisionService;
use App\Traits\PingServer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ManageDepositController extends Controller
{
    use PingServer;
    public function list() {
     return 'test'; 
    }
    //Delete deposit
    public function adddeposit_old(Request $request)
    {
        // 1. Validate request
        $request->validate([
            'user_id'         => 'required|exists:users,id',
            'deposit_amount' => 'required|numeric|min:1',
        ]);
        
        $userid = $request->user_id;
        $amount = $request->deposit_amount;

        // 2. Get User
        $user = User::findOrFail($userid);
        //return response()->json($user);
        // 3. Create New Deposit Entry
        //return response()->json($userid);
        $deposit = Deposit::create([
            'user'          => $userid,
            'amount'        => $amount,
            'payment_mode'  => $request->payment_mode ?? 'USDT',
            'status'        => 'Processed',
        ]);

        return redirect()->back()->with('success', 'Deposit added successfully!');
        
    }
    public function adddeposit(Request $request) {
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'deposit_amount' => 'required|numeric|min:1',
        ]);
        
        $userid = $request->user_id;
        $amount = $request->deposit_amount;
        
        $user = User::findOrFail($userid);
        
        $deposit = Deposit::create([
            'user'         => $userid,
            'amount'       => $amount,
            'payment_mode' => $request->payment_mode ?? 'USDT',
            'status'       => 'Processed',
        ]);
        
        // ===============================
        // Send Notification (optional)
        // ===============================
        $message = "Deposit of {$amount} has been created successfully.";
        $user->notify(new AccountNotification($message, 'Deposit Successful'));
        
        // ===============================
        // Send Mail to User + Admin
        // ===============================
        $messageBody  = "Deposit Created Successfully\n\n";
        $messageBody .= "User Name    : {$user->name}\n";
        $messageBody .= "User Email   : {$user->email}\n";
        $messageBody .= "Amount       : {$amount}\n";
        $messageBody .= "Payment Mode : " . ($request->payment_mode ?? 'USDT') . "\n\n";
        $messageBody .= "Regards,\nMajesti Trade";
        
        return redirect()->back()->with('success', 'Deposit added successfully! test ');
    }
    public function updateDeposit(Request $request, $id)
    {
    
    $request->validate([
        'amount'        => 'required|numeric|min:0.01',
        'payment_mode'  => 'required|string|max:100',
        'status'        => 'required|in:Pending,Processed,Rejected',
    ]);

    $deposit = Deposit::findOrFail($id);
    $user    = User::findOrFail($deposit->user);

    $oldStatus = $deposit->status; // ✅ Track previous status

    // ✅ Update Deposit
    $deposit->update([
        'amount'       => $request->amount,
        'payment_mode' => $request->payment_mode,
        'status'       => $request->status,
    ]);

    // ✅ CREDIT USER ONLY IF:
    // Old was NOT Processed AND New is Processed
    if ($oldStatus !== 'Processed' && $request->status === 'Processed') {

        // ✅ Add balance
        $user->account_bal += $request->amount;
        $user->save();

        // ✅ Create transaction history
        Tp_Transaction::create([
            'user'   => $user->id,
            'plan'   => 'Deposit via ' . $request->payment_mode,
            'amount' => $request->amount,
            'type'   => 'Deposit',
            'remark' => 'Deposit Approved',
            'from'   => 'System',
            'to'     => $user->name,
        ]);

        // Send notification
        $message = "Your deposit of {$request->amount} has been successfully credited.";
        $user->notify(new AccountNotification($message, 'Deposit Successful'));
    }
    

    // Send Email
    if (!empty($request->email) && $request->status === 'Processed') {

        $messageBody = "Deposit Updated\n\n";
        $messageBody .= "Status       : {$request->status}\n";
        $messageBody .= "Amount       : {$request->amount}\n";
        $messageBody .= "Payment Mode : {$request->payment_mode}\n";
        $messageBody .= "Email        : {$request->email}\n\n";
        $messageBody .= "Regards,\nMajesti Trade";

        Mail::raw($messageBody, function ($msg) use ($request) {
            $msg->to($request->email)
                ->subject('Deposit ' . $request->status);
            $msg->to('support@majestiglobal.com')
            ->subject('Deposit '.$request->status.' for '.$request->email);
        });
        
    }
     
    if (!empty($request->email) && $request->status === 'Rejected') {

        $messageBody = "Rejected Updated\n\n";
        $messageBody .= "Status       : {$request->status}\n";
        $messageBody .= "Amount       : {$request->amount}\n";
        $messageBody .= "Payment Mode : {$request->payment_mode}\n";
        $messageBody .= "Remark : {$request->reamrk}\n";
        $messageBody .= "Email        : {$request->email}\n\n";
        $messageBody .= "Regards,\nMajesti Trade";

        Mail::raw($messageBody, function ($msg) use ($request) {
            $msg->to($request->email)
                ->subject('Deposit ' . $request->status);
            $msg->to('support@majestiglobal.com')
            ->subject('Deposit Rejected '.$request->status.' for '.$request->email);
        });
        
    }
    // ✅ AJAX Response
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Deposit ' .$request->status,
            'deposit' => $deposit
        ]);
    }

    // ✅ Normal Redirect
    return redirect()->back()->with('success', 'Deposit updated and balance credited successfully!');
    }
    public function updateDeposit1(Request $request, $id)
    {
        $request->validate([
            'amount'        => 'required|numeric|min:0.01',
            'payment_mode'  => 'required|string|max:100',
            'status'        => 'required|in:Pending,Processed,Rejected',
        ]);
        //return $id;
        $deposit = Deposit::findOrFail($id);
        
        $deposit->update([
            'amount'       => $request->amount,
            'payment_mode' => $request->payment_mode,
            'status'       => $request->status,
        ]);
        
        
        if (!empty($request->email)) {

            $messageBody = "Deposit Updated test ....";
            $messageBody .= "Hello,\n\n";
            $messageBody .= "Your deposit details have been updated as follows:\n\n";
            $messageBody .= "Status       : {$request->status}\n";
            $messageBody .= "Amount       : {$request->amount}\n";
            $messageBody .= "Payment Mode : {$request->payment_mode}\n";
            $messageBody .= "Email        : {$request->email}\n\n";
            $messageBody .= "Regards,\nMajesti Trade";

            Mail::raw($messageBody, function ($msg) use ($request) {
                $msg->to('support@majestiglobal.com')
                    ->subject('Deposit '.$request->status.' for '.$request->email);
                 $msg->to($request->email)
                    ->subject('Deposit '.$request->status.' for '.$request->email);    
            });
        }
        // If request is AJAX → return JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Deposit updated successfully!',
                'deposit' => $deposit
            ]);
        }

        // If normal form submit → redirect back
        return redirect()->back()->with([
            'success' => 'Deposit updated successfully!',
        ]);
    }

    //process deposits
    public function pdeposit($id)
    {
        //confirm the users plan
        $deposit = Deposit::where('id', $id)->first();
        $user = User::where('id', $deposit->user)->first();
        //get settings 
        $settings = Settings::where('id', '=', '1')->first();

        $response = $this->callServer('earnings', '/process-deposit', [
            'referral_commission' => $settings->referral_commission,
            'amount' => $deposit->amount,
            'account_bal' => $user->account_bal,
            'depositBonus' => $settings->deposit_bonus,
        ]);

        if ($response->failed()) {
            return redirect()->back()->with('message', $response['message']);
        }

        $data = json_decode($response);
        $earnings = floatval($data->data->earnings);
        $bonus = intval($data->data->bonusToAdd);
        $funds = intval($data->data->funding);

        if ($deposit->user == $user->id) {
            //add funds to user's account
            $user->account_bal = $funds;
            $user->cstatus = 'Customer';
            $user->bonus = $user->bonus + $bonus;
            $user->save();

            if ($bonus != NULL and $bonus > 0) {
                Tp_Transaction::create([
                    'user' => $user->id,
                    'plan' => "Deposit Bonus for $settings->currency $deposit->amount deposited",
                    'amount' => $bonus,
                    'type' => "Bonus",
                ]);
            }

            //update deposit status
            $deposit->status = 'Processed';
            $deposit->save();

            if ($settings->referral_proffit_from == 'Deposit') {
                // credit referral commission
                $ref = new ReferralCommisionService($user, $funds);
                $ref->run();
            }

            //Send notification to user regarding his deposit and it's successful.
            $user->notify(new AccountNotification("Your Deposit have been Confirmed and the amount is added to your account balance. Amount: {$settings->currency}{$funds}", 'Deposit is Confirmed'));
            //Send confirmation email to user regarding his deposit and it's successful.
            Mail::to($user->email)->send(new DepositStatus($deposit, $user, 'Your Deposit have been Confirmed', false));
        }

        return redirect()->back()->with('success', 'Action Sucessful!');
    }
}
