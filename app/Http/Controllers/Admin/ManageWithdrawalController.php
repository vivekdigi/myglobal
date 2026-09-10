<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Wdmethod;
use App\Models\Withdrawal;
use App\Mail\NewNotification;
use App\Notifications\AccountNotification;
use App\Traits\PingServer;
use App\Models\Deposit;
use Illuminate\Support\Facades\Mail;

class ManageWithdrawalController extends Controller
{
    use PingServer;

    //process withdrawals
    public function pwithdrawal(Request $request)
{
    $withdrawal = Withdrawal::find($request->id);

    if (!$withdrawal) {
        return redirect()->back()->with('error', 'Withdrawal not found.');
    }

    $user = User::find($withdrawal->user);
    $settings = Settings::find(1);

    // ======================================
    // HANDLE PAID (APPROVED)
    // ======================================
    if ($request->action == 'Paid') {

        // Deduct balance if needed
        if ($settings->deduction_option == "AdminApprove") {
            $new_balance = $user->account_bal - $withdrawal->to_deduct;
            if ($new_balance < 0) $new_balance = 0;

            $user->update(['account_bal' => $new_balance]);
        }

        // Update withdrawal status
        $withdrawal->update([
            'status' => 'Processed',
        ]);

        // --------------------------------------
        // ADD TO DEPOSITS TABLE (ADD AMOUNT)
        // --------------------------------------
        /* $latestDeposit = Deposit::where('user', $user->id)
                                ->orderBy('id', 'desc')
                                ->first();

        if ($latestDeposit) {
            // Add to existing deposit amount
            $latestDeposit->update([
                'amount' => $latestDeposit->amount + $withdrawal->amount
            ]);
        } else {
            // Create new deposit if none exists
            Deposit::create([
                'user' => $user->id,
                'amount' => $withdrawal->amount,
                'payment_mode' => $withdrawal->payment_mode ?? 'Withdrawal',
                'plan' => null,
                'status' => 'Processed',
                'proof' => null,
            ]);
        } */

        // Send notification
        $message = "Your withdrawal request of {$settings->currency}{$withdrawal->amount} has been approved and funds have been sent to your account.";
        $user->notify(new AccountNotification($message, 'Withdrawal Successful'));

        // Optional email
        Mail::to($user->email)->send(new NewNotification($message, 'Successful Withdrawal', $user->name));
        Mail::to($settings->contact_email)->send(new NewNotification($message, 'Successful Withdrawal', $user->name));
        return redirect()->route('mwithdrawals')->with('success', 'Withdrawal approved successfully.');
    }

    // ======================================
    // HANDLE REJECTED
    // ======================================
    elseif ($request->action == 'Reject') {

        // Refund balance to user if deduction_option is userRequest
        if ($settings->deduction_option == "userRequest") {
            $user->update([
                'account_bal' => $user->account_bal + $withdrawal->to_deduct,
            ]);
        }

        // Mark withdrawal as rejected
        $withdrawal->update([
            'status' => 'Rejected',
        ]);

        // --------------------------------------
        // ADD REFUND TO DEPOSITS TABLE
        // --------------------------------------
        $refundAmount = $withdrawal->to_deduct ?? $withdrawal->amount;

        $latestDeposit = Deposit::where('user', $user->id)
                                ->orderBy('id', 'desc')
                                ->first();

        if ($latestDeposit) {
            // Add refund to existing deposit
            $latestDeposit->update([
                'amount' => $latestDeposit->amount + $refundAmount
            ]);
        } else {
            // Create new deposit entry for refund
            Deposit::create([
                'user' => $user->id,
                'amount' => $refundAmount,
                'payment_mode' => 'Refund',
                'plan' => null,
                'status' => 'Rejected',
                'proof' => null,
            ]);
        }

        // Send rejection email if selected
        if ($request->emailsend == "true") {
            $reason = $request->reason ?: 'Your withdrawal request has been rejected.';
            $subject = $request->subject ?: 'Withdrawal Rejected';
            Mail::to($user->email)->send(new NewNotification($reason, $subject, $user->name));
            Mail::to($settings->contact_email)->send(new NewNotification($reason, $subject, $user->name));
        }

        return redirect()->route('mwithdrawals')->with('success', 'Withdrawal rejected successfully.');
    }
}
    public function pwithdrawal1111111(Request $request)
    {
    $withdrawal = Withdrawal::find($request->id);

    if (!$withdrawal) {
        return redirect()->back()->with('error', 'Withdrawal not found.');
    }

    $user = User::find($withdrawal->user);
    $settings = Settings::find(1);

    // Handle Paid (Approved)
    if ($request->action == 'Paid') {
        // Deduct balance if needed
        if ($settings->deduction_option == "AdminApprove") {
            $new_balance = $user->account_bal - $withdrawal->to_deduct;
            if ($new_balance < 0) $new_balance = 0;

            $user->update(['account_bal' => $new_balance]);
        }

        // Update withdrawal status
        $withdrawal->update([
            'status' => 'Processed',
        ]);

        // Send notification
        $message = "Your withdrawal request of {$settings->currency}{$withdrawal->amount} has been approved and funds have been sent to your account.";
        $user->notify(new AccountNotification($message, 'Withdrawal Successful'));

        // Optional email
        Mail::to($user->email)->send(new NewNotification($message, 'Successful Withdrawal', $user->name));
        Mail::to($settings->contact_email)->send(new NewNotification($message, 'Successful Withdrawal', $user->name));
        return redirect()->route('mwithdrawals')->with('success', 'Withdrawal approved successfully.');
    }

    // Handle Rejection
    elseif ($request->action == 'Reject') {
        if ($settings->deduction_option == "userRequest") {
            // Return deducted amount to user balance
            $user->update([
                'account_bal' => $user->account_bal + $withdrawal->to_deduct,
            ]);
        }

        // Delete or mark as rejected
        $withdrawal->update([
            'status' => 'Rejected',
        ]);

        // Send rejection email if selected
        if ($request->emailsend == "true") {
            $reason = $request->reason ?: 'Your withdrawal request has been rejected.';
            $subject = $request->subject ?: 'Withdrawal Rejected';
            Mail::to($user->email)->send(new NewNotification($reason, $subject, $user->name));
            Mail::to($settings->contact_email)->send(new NewNotification($reason, $subject, $user->name));
        }

        return redirect()->route('mwithdrawals')->with('success', 'Withdrawal rejected successfully.');
    }

    return redirect()->back()->with('error', 'Invalid action.');
    }
    public function pwithdrawal_old(Request $request)
    {
        $withdrawal = Withdrawal::where('id', $request->id)->first();
        $user = User::where('id', $withdrawal->user)->first();
        $settings  = Settings::find(1);

        $response = $this->callServer('processwithdrawal', '/process-withdrawal', [
            'proaction' => $request->action,
            'account_bal' => $user->account_bal,
            'deduction' => $withdrawal->to_deduct,
        ]);

        if ($response->failed()) {
            return redirect()->back()->with('message', $response['message']);
        }

        $data = json_decode($response);

        if ($data->data->action) {
            if ($settings->deduction_option == "AdminApprove") {
                User::where('id', $user->id)
                    ->update([
                        'account_bal' => $data->data->balance
                    ]);
            }
            Withdrawal::where('id', $request->id)
                ->update([
                    'status' => 'Processed',
                ]);

            $settings = Settings::where('id', '=', '1')->first();
            $message = "This is to inform you that your withdrawal request of $settings->currency$withdrawal->amount have approved and funds have been sent to your selected account";

            // Send notification to user
            $user->notify(new AccountNotification($message, 'Withdrawal Successful'));

            Mail::to($user->email)->send(new NewNotification($message, 'Successful Withdrawal', $user->name));
        } else {
            if ($withdrawal->user == $user->id) {
                if ($settings->deduction_option == "userRequest") {
                    User::where('id', $user->id)
                        ->update([
                            'account_bal' =>  $data->data->reverse,
                        ]);
                }
                Withdrawal::where('id', $request->id)->delete();
                if ($request->emailsend == "true") {
                    Mail::to($user->email)->send(new NewNotification($request->reason, $request->subject, $user->name));
                }
            }
        }

        return redirect()->route('mwithdrawals')->with('success', 'Action Sucessful!');
    }

    public function processwithdraw($id)
    {
        $with = Withdrawal::where('id', $id)->first();
        $method = Wdmethod::where('name', $with->payment_mode)->first();
        $user = User::where('id', $with->user)->first();
        return view('admin.withdrawals.pwithrdawal', [
            'withdrawal' => $with,
            'method' => $method,
            'user' => $user,
            'title' => 'Process withdrawal Request',
        ]);
    }
}
