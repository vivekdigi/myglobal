<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewNotification;
use App\Models\Mt4Details;
use App\Models\Settings;
use App\Models\User;
use App\Notifications\AccountNotification;
use App\Services\TradeCopier;
use App\Traits\PingServer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class TradingAccountController extends Controller
{
    use PingServer;

    public function tradingAccounts(TradeCopier $copier): View| RedirectResponse
    {
        try {
            $subscribers = $copier->subscribers();
            $apisettings = $copier->settings();
            $accounts = $copier->providers();

            return view('admin.subscription.tradingAccounts', [
                'title' => 'Provisioned Trading accounts',
                'subscribers' => $subscribers,
                'amountPerSlot' => $apisettings['amount_per_slot'],
                'masters' => $accounts,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function payment()
    {
        return view('admin.subscription.payment', [
            'title' => 'Payment Settings',
        ]);
    }


    public function renewAccount(Request $request)
    {
        $response = $this->fetctApi('/renew-account', [
            'account' => $request->account_id,
        ], 'POST');

        if ($response->failed()) {
            return redirect()->back()->with('message', $response['message']);
        }

        return redirect()->back()->with('success', $response['message']);
    }

    public function createSubscriberAccount(Request $request)
    {
        $settings = Settings::select('id', 'use_copytrade')->find(1);

        $payload =  [
            'login' => $request->login,
            'password' => $request->password,
            'serverName' => $request->serverName,
            'name' => $request->name,
            'leverage' => $request->leverage,
            'account_type' => $request->acntype,
            'baseCurrency' => $request->currency ? $request->currency : 'USD',
        ];

        if ($request->has('mt4id')) {
            $account = Mt4Details::select('provider')->find($request->mt4id);
            $payload['proivder'] = $account->provider;
        }

        if ($settings->use_copytrade) {
            $response = $this->fetctApi('/create-sub-account', $payload, 'POST');

            if ($response->failed()) {
                return redirect()->back()->with('message', $response['message']);
            }
        }

        if ($request->has('mt4id')) {
            $this->confirmsub($request->mt4id);
        }

        // remove the subscribers key from cache
        Cache::forget('subscribers');
        Cache::forget('copier-settings');
        return redirect()->back()->with('success', 'Action successful.');
    }


    public function deleteSubAccount($id)
    {
        $response = $this->fetctApi('/delete-sub-account' . '/' . $id);
        if ($response->failed()) {
            return redirect()->back()->with('message', $response['message']);
        }
        Cache::forget('subscribers');
        Cache::forget('copier-settings');
        return redirect()->back()->with('success', $response['message']);
    }

    public function copyTrade(Request $request)
    {
        $data = [
            'account' => $request->subscriberid,
            'master_account_id' => $request->master,
        ];

        if ($request->has('fixed_provider')) {
            $provider = explode('-', $request->master);

            $data['fixedProvider'] = 'Yes';
            $data['master_account_id'] = $provider[1];
        }

        $response = $this->fetctApi('/copytrade', $data, 'POST');

        if ($response->failed()) {
            return redirect()->back()->with('message', $response['message']);
        }

        Mt4Details::where('mt4_id', $request->login)->update([
            'copying_trade' => true,
        ]);

        return redirect()->back()->with('success', $response['message']);
    }


    public function deployment($id, $deployment)
    {
        $response = $this->fetctApi('/deployment', [
            'account' => $id,
            'deploy_type' => $deployment,
        ], 'POST');
        if ($response->failed()) {
            return redirect()->back()->with('message', $response['message']);
        }
        Cache::forget('subscribers');
        return redirect()->back()->with('success', $response['message']);
    }


    public function confirmsub($id): void
    {
        $settings = Settings::find(1);

        //get the sub details
        $sub = Mt4Details::find($id);
        //get user
        $user = User::where('id', $sub->client_id)->first();

        $end_at = now()->addYear();
        $remindAt = $end_at->subMonth();

        $sub->start_date = now();
        if ($settings->subscription_type == 'Fixed') {
            $sub->end_date =  $end_at;
            $sub->reminded_at = $remindAt;
        }
        $sub->status = 'Active';
        $sub->save();

        $settings = Settings::where('id', '=', '1')->first();
        $message = "$user->name, This is to inform you that your trading account management request has been reviewed and processed. Thank you for trusting $settings->site_name";

        // Send notification to user
        $user->notify(new AccountNotification($message, 'Subscription Account Started!'));

        Mail::to($user->email)->send(new NewNotification($message, 'Subscription Account Started!', $user->name));
    }

    public function deploymentAll(string $type, string $deployType): RedirectResponse
    {
        $response = $this->fetctApi('/deployment-all/' . $type . '/' . $deployType);

        if ($response->failed()) {
            return redirect()->back()->with('message', $response['message']);
        }
        if ($type == 'providers') {
            Cache::forget('providers');
        } else {
            Cache::forget('subscribers');
        }
        return redirect()->back()->with('success', $response['message']);
    }
}
