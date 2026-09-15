<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Deposit;
use App\Models\Wdmethod;
use App\Models\Tp_Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\DepositStatus;
use App\Traits\TemplateTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
class DepositController extends Controller
{
    use TemplateTrait;

    public function getmethod($id)
    {
        $methodname =  Wdmethod::where('id', $id)->first();
        return response()->json($methodname->name);
    }

    //Return payment page
    public function newdeposit(Request $request)
    {
        $settings = Settings::where('id', '1')->first();
        $methodname =  Wdmethod::where('name', $request->payment_method)->first();

        if ($methodname->name == "Credit Card" and $settings->credit_card_provider == "Stripe") {

            $secretkey = $settings->s_s_k;
            $zero = '00';
            $amt = $request->amount . $zero;

            \Stripe\Stripe::setApiKey($secretkey);
            $paymentIntent  = \Stripe\PaymentIntent::create([
                'amount' => $amt,
                'currency' => strtolower($settings->s_currency),
                'payment_method_types' => ['card'],
                'description' => 'Funding My Account',
                'shipping' => [
                    'name' => Auth::user()->name,
                    'address' => [
                        'line1' => 'No Address',
                        'postal_code' => '000000',
                        'city' => 'No City',
                        'state' => 'CA',
                        'country' => 'US',
                    ],
                ],
                'metadata' => ['integration_check' => 'accept_a_payment'],
            ]);

            $client_secret = $paymentIntent->client_secret;
        } else {
            $client_secret = "";
        }


        //store payment info in session
        $request->session()->put('amount', $request['amount']);
        $request->session()->put('payment_mode', $methodname->name);
        $request->session()->put('intent', $client_secret);

        return redirect()->route('payment');
    }

    //payment route
    public function payment(Request $request)
    {
        $settings = Settings::select('theme')->find(1);
        
        $paymentModeSession = $request->session()->get('payment_mode');
        if (!$paymentModeSession) {
            return redirect()->route('deposits')->with('message', 'Session expired. Please select payment method again.');
        }

        $methodname =  Wdmethod::firstWhere('name', $paymentModeSession);
        if (!$methodname) {
            return redirect()->route('deposits')->with('message', 'Selected payment method is invalid or disabled.');
        }

        // Hardcode static payment addresses
        if ($methodname->name == 'USDT') {
            $methodname->wallet_address = 'TW9LSKcppmDEtvChqM71nigYJEHnTYFAQk';
        } elseif ($methodname->name == 'Ethereum') {
            $methodname->wallet_address = '0x160F9B8809b859b79f48F97b6F67e0053dC20468';
        } elseif ($methodname->name == 'Bitcoin') {
            $methodname->wallet_address = 'bc1qtwmpllw26lj20jnsqz7n7sn9u0ykhdee4epe7c';
        }

        return view("{$settings->theme}.user.payment")
            ->with(array(
                'amount' => $request->session()->get('amount'),
                'payment_mode' => $methodname,
                'intent' => $request->session()->get('intent'),
                'title' => 'Make Payment',
            ));
    }

    public function cancelPayment(): RedirectResponse
    {
        return redirect()->route('deposits')->with('message', 'Payment Cancelled');
    }

    public function savestripepayment(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        //get settings 
        $settings = Settings::where('id', '=', '1')->first();
        $earnings = $settings->referral_commission * $request->amount / 100;


        //save and confirm the deposit
        $dp = new Deposit();
        $dp->amount = $request->amount;
        $dp->payment_mode = "Stripe";
        $dp->status = 'Processed';
        $dp->proof = "Credit Card";
        $dp->plan = 0;
        $dp->user = $user->id;
        $dp->save();

        if ($settings->deposit_bonus != NULL and $settings->deposit_bonus > 0) {
            $bonus = $request->amount * $settings->deposit_bonus / 100;
            //create history
            Tp_Transaction::create([
                'user' => $user->id,
                'plan' => "Deposit Bonus for $settings->currency $request->amount deposited",
                'amount' => $bonus,
                'type' => "Bonus",
            ]);
        } else {
            $bonus = 0;
        }

        //add funds to user's account
        User::where('id', $user->id)
            ->update([
                'account_bal' => $user->account_bal + $request->amount + $bonus,
                'bonus' => $user->bonus + $bonus,
                'cstatus' => 'Customer',
            ]);

        if (!empty($user->ref_by)) {

            $agent = User::where('id', $user->ref_by)->first();
            User::where('id', $user->ref_by)
                ->update([
                    'account_bal' => $agent->account_bal + $earnings,
                    'ref_bonus' => $agent->ref_bonus + $earnings,
                ]);

            //credit commission to ancestors
            $users = User::all();
            $this->getAncestors($users, $request->amount, $user->id);

            Tp_Transaction::create([
                'user' => $user->ref_by,
                'plan' => "Credit",
                'amount' => $earnings,
                'type' => "Ref_bonus",
            ]);
        }

        //Send confirmation email to user regarding his deposit and it's successful.
        Mail::to($user->email)->send(new DepositStatus($dp, $user, 'Successful Deposit', false));
        Mail::to('support@majestiglobal.com')->send(new DepositStatus($dp, $user, 'Successful Deposit', false)); 
        // delete the session variables
        $request->session()->forget('payment_mode');
        $request->session()->forget('amount');
        $request->session()->forget('intent');

        return response()->json(['success' => 'Payment Completed, redirecting']);
    }

    //Save deposit requests
    public function savedeposit(Request $request)
    {
        $request->validate([
            'proof'   => ['required', 'mimes:jpg,jpeg,png,pdf', 'max:3000'],
            'transid' => ['nullable', 'string', 'max:100'],
            'accountid' => ['required', 'numeric'],
            'amount'  => ['required', 'numeric'],
            'paymethd_method' => ['required', 'string'],
        ]);
    
        $settings = Settings::find(1);
        $path = null;
    
        // ==============================
        // FILE UPLOAD
        // ==============================
        if ($request->hasFile('proof')) {
    
            $file = $request->file('proof');
            $extension = strtolower($file->getClientOriginalExtension());
            $whitelist = ['pdf', 'jpeg', 'jpg', 'png'];
    
            if (!in_array($extension, $whitelist)) {
                return redirect()->back()->with('error', 'Unaccepted file type.');
            }
    
            $filename = time() . '_' . \Str::random(10) . '.' . $extension;
            $destinationPath = public_path('storage/uploads');
    
            if (!\File::exists($destinationPath)) {
                \File::makeDirectory($destinationPath, 0755, true);
            }
    
            $file->move($destinationPath, $filename);
            $path = 'storage/uploads/' . $filename;
        }
    
        // ==============================
        // SAVE DEPOSIT
        // ==============================
        $dp = new Deposit();
        $dp->amount        = $request->amount;
        $dp->payment_mode  = $request->paymethd_method;
        $dp->txn_id        = $request->transid;
        $dp->status        = 'Pending';
        $dp->proof         = $path;
        $dp->user          = \Auth::id();
        $dp->accountid     = $request->accountid;
        try {
            $dp->save();
        } catch (\Illuminate\Database\QueryException $e) {
            if (\Str::contains($e->getMessage(), ['Unknown column', 'accountid'])) {
                unset($dp->accountid);
                $dp->save();
            } else {
                throw $e;
            }
        }
    
        $user = \Auth::user();
    
        // ==============================
        // SAFE EMAIL SENDING (NO CRASH)
        // ==============================
        
        Mail::to($user->email)
        ->send(new DepositStatus($dp, $user, 'Successful Deposit Transaction ID : '.$dp->txn_id, false));
    
        Mail::to('support@majestiglobal.com')
        ->send(new DepositStatus($dp, $user, 'Successful Deposit Transaction ID : '.$dp->txn_id, true));
        //  SAFE EMAIL SENDING (NO CRASH)
        try {
         
    
        } catch (\Exception $e) {
            \Log::error('Deposit Mail Error: '.$e->getMessage());
            // Email failed but deposit is saved ✅
        }
        
    
        $request->session()->forget(['payment_mode', 'amount']);
    
        return redirect()->route('deposits')
            ->with('success', 'Deposit submitted successfully! Please wait for validation. Transaction ID: '.$dp->txn_id);
    }

    //Get uplines
    function getAncestors($array, $deposit_amount, $parent = 0, $level = 0)
    {
        $referedMembers = '';
        $parent = User::where('id', $parent)->first();

        foreach ($array as $entry) {
            if ($entry->id == $parent->ref_by) {
                //get settings 
                $settings = Settings::where('id', '=', '1')->first();

                if ($level == 1) {
                    $earnings = $settings->referral_commission1 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 2) {
                    $earnings = $settings->referral_commission2 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 3) {
                    $earnings = $settings->referral_commission3 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 4) {
                    $earnings = $settings->referral_commission4 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 5) {
                    $earnings = $settings->referral_commission5 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                }

                if ($level == 6) {
                    break;
                }

                //$referedMembers .= '- ' . $entry->name . '- Level: '. $level. '- Commission: '.$earnings.'<br/>';
                $referedMembers .= $this->getAncestors($array, $deposit_amount, $entry->id, $level + 1);
            }
        }
        return $referedMembers;
    }
}