<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Settings;
use App\Models\Plans;
use App\Models\User_plans;
use App\Models\Tp_Transaction;
use App\Mail\NewRoi;
use App\Mail\endplan;
use App\Mail\NewNotification;
use App\Models\Mt4Details;
use App\Notifications\AccountNotification;
use App\Services\ReferralCommisionService;
use App\Traits\BinanceApi;
use App\Traits\Coinpayment;
use App\Traits\PingServer;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AutoTaskController extends Controller
{
    use Coinpayment, BinanceApi, PingServer;
    /*
        Automatic toup
        calculate top up earnings and
        auto increment earnings after the increment time
    */

    public function autotopup()
    {
        // automatic roi
        $this->automaticRoi();

        // check for subscription expiration
        $this->checkSubscription();

        //do auto confirm payments
        $this->queryOrder();
        echo "Automatic ROI is working properly \n CoinPayment:";
        return $this->cpaywithcp();
    }

    public function checkSubscription()
    {
        $subscriptions = Mt4Details::where('status', 'active')->get();
        $today = now();
        $settings = Settings::find(1);

        foreach ($subscriptions as $sub) {
            $endAt = Carbon::parse($sub->end_date);
            $remindAt = Carbon::parse($sub->reminded_at);
            $singleSub = Mt4Details::find($sub->id);
            $user = User::find($singleSub->client_id);

            if ($today->isSameDay($endAt) && $singleSub->status != 'Expired') {
                //mark sub as expired
                $singleSub->status = 'Expired';
                $singleSub->save();

                //send email to user
                $messageUser = "Your subscription with MT4-ID: $sub->mt4_id have expired. To enable us continue trading on this account, please renew your subcription. \r\n To renew your subcription, login to your $settings->site_name account, go to managed accounts page and click on the renew button on the affected account.";
                Mail::to($user->email)->send(new NewNotification($messageUser, 'Your subscription have expired', $user->firstname));

                // Send email to admin
                $messageAdmin = "Subscription with MT4-ID: $sub->mt4_id have expired and the user have been notified.";
                Mail::to($settings->contact_email)->send(new NewNotification($messageAdmin, 'Your subscription have expired', 'Admin'));
            }

            if ($today->isSameDay($remindAt)) {
                // number of days for subscription to expire
                $daysLeft = $endAt->diffInDays($remindAt);

                //send email to user
                $message = "Your subscription with MT4-ID: $sub->mt4_id will expire in $daysLeft days. To avoid disconnection of your trading account, please renew your subcription before $endAt. \r\n To renew your subcription, login to your $settings->site_name account, go to managed accounts page and click on the renew button on the affected account.";
                Mail::to($singleSub->tuser->email)->send(new NewNotification($message, 'Your subscription will expire soon', $singleSub->tuser->firstname));

                $singleSub->reminded_at = $remindAt->addDay();   //2022-12-21 19:50:58
                $singleSub->save();
            }
        }
    }



    public function automaticRoi()
    {
        User_plans::where('active', 'yes')
            ->chunkById(200, function ($usersPlans) {

                $now = now();
                $settings = Settings::find(1);

                foreach ($usersPlans as $plan) {
                    //get plan
                    $dplan = Plans::where('id', $plan->plan)->first();

                    //get user
                    $user = User::where('id', $plan->user)->first();

                    //know the plan increment interval
                    if ($dplan->increment_interval == "Monthly") {
                        $nextDrop = $plan->last_growth->addDays(27);
                    } elseif ($dplan->increment_interval == "Weekly") {
                        $nextDrop = $plan->last_growth->addDays(6);
                    } elseif ($dplan->increment_interval == "Daily") {
                        $nextDrop = $plan->last_growth->addHours(23);
                    } elseif ($dplan->increment_interval == "Hourly") {
                        $nextDrop = $plan->last_growth->addMinutes(54);
                    } elseif ($dplan->increment_interval == "Every 30 Minutes") {
                        $nextDrop = $plan->last_growth->addMinutes(24);
                    } else {
                        $nextDrop = $plan->last_growth->addMinutes(7);
                    }

                    //conditions
                    $haveNotExpired = $now->lessThanOrEqualTo($plan->expire_date);

                    $hasExpired = $now->greaterThan($plan->expire_date);

                    if ($haveNotExpired) {
                        //calculate roi/profit
                        if ($dplan->increment_type == "Percentage") {
                            $increment = (intval($plan->amount)  * $dplan->increment_amount) / 100;
                        } else {
                            $increment = $plan->increment_amount;
                        }

                        if ($settings->trade_mode == 'on' && $user->trade_mode == 'on' && ($now->isWeekday() || $settings->weekend_trade == 'on')) {

                            if ($now->greaterThanOrEqualTo($plan->last_growth)) {
                                //increment user account balance
                                $user->account_bal = $user->account_bal + $increment;
                                $user->roi = $user->roi + $increment;
                                $user->save();

                                //save to transactions history
                                $th = new Tp_Transaction();
                                $th->plan = $dplan->name;
                                $th->user = $user->id;
                                $th->amount = $increment;
                                $th->user_plan_id = $plan->id;
                                $th->type = "ROI";
                                $th->save();

                                $plan->update([
                                    'last_growth' => $nextDrop,
                                    'profit_earned' => $plan->profit_earned + $increment,
                                ]);

                                if ($settings->referral_proffit_from != 'Deposit') {
                                    // credit referral commission
                                    $ref = new ReferralCommisionService($user, $increment);
                                    $ref->run();
                                }

                                $user->notify(new AccountNotification("You have a new profit. Plan: {$dplan->name}, Amount: {$settings->currency}{$increment}", 'New Profit record'));

                                //send email notification
                                if ($user->sendroiemail == 'Yes') {
                                    Mail::to($user->email)->send(new NewRoi($user, $dplan->name, $increment, now(), 'New Return on Investment(ROI)'));
                                }
                            }
                        }
                        if ($settings->trade_mode != 'on' || $user->trade_mode != 'on' || ($now->isWeekend() && $settings->weekend_trade != 'on')) {
                            if ($now->greaterThanOrEqualTo($plan->last_growth)) {
                                User_plans::where('id', $plan->id)
                                    ->update([
                                        'last_growth' => $nextDrop,
                                    ]);
                            }
                        }
                    }

                    if ($hasExpired) {
                        //release capital
                        if ($settings->return_capital) {

                            User::where('id', $plan->user)
                                ->update([
                                    'account_bal' => $user->account_bal + $plan->amount,
                                ]);

                            //save to transactions history
                            $th = new Tp_transaction();
                            $th->plan = $dplan->name;
                            $th->user = $plan->user;
                            $th->amount = $plan->amount;
                            $th->type = "Investment capital";
                            $th->save();
                        }

                        //plan expiredP
                        $plan->update([
                            'active' => "expired",
                        ]);

                        if ($user->sendinvplanemail == "Yes") {
                            //send email notification
                            $objDemo = new \stdClass();
                            $objDemo->receiver_email = $user->email;
                            $objDemo->receiver_plan = $dplan->name;
                            $objDemo->received_amount = "$settings->currency$plan->amount";
                            $objDemo->sender = $settings->site_name;
                            $objDemo->receiver_name = $user->name;
                            $objDemo->date = \Carbon\Carbon::Now();
                            $objDemo->subject = "Investment plan closed";
                            Mail::to($user->email)->send(new endplan($objDemo));
                        }
                    }
                }
            }, $column = 'id');
    }
}
