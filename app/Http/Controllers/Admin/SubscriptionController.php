<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Mt4Details;
use App\Models\Settings;
use App\Models\SymbolMap;
use App\Services\HelperService;
use App\Traits\PingServer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SubscriptionController extends Controller
{
    use PingServer;

    public function myTradingSettings(): View
    {
        return view('admin.subscription.trading-settings', [
            'title' => 'Trading Settings',
        ]);
    }

    public function symbolMapping(): View
    {
        return view('admin.subscription.map', [
            'title' => 'Symbol Mapping',
        ]);
    }

    public function createCopyMasterAccount(Request $request): RedirectResponse
    {
        $response = $this->fetctApi('/create-copytrade-account', [
            'login' => $request->login,
            'password' => $request->password,
            'serverName' => $request->serverName,
            'name' => $request->name,
            'leverage' => $request->leverage,
            'account_type' => $request->acntype,
            'baseCurrency' => $request->currency ? $request->currency : 'USD',
        ], 'POST');

        if ($response->failed()) {
            return redirect()->back()->with('message', $response['message']);
        }
        // remove the providers key from cache
        HelperService::cacheForget('providers');
        HelperService::cacheForget('copier-settings');
        return redirect()->back()->with('success', $response['message']);
    }


    public function updateStrategy(Request $request)
    {
        if ($request->has('fixedRisk')) {
            $modeCompliment = $request->fixedRisk;
        } elseif ($request->has('fixedVolume')) {
            $modeCompliment = $request->fixedVolume;
        } elseif ($request->has('expression')) {
            $modeCompliment = $request->expression;
        } else {
            $modeCompliment = '';
        }
        $settings = Settings::select(['commission_type', 'billing_period', 'percentage_fee', 'subscription_type'])->find(1);

        if ($settings->subscription_type == 'Percentage' && is_null($request->commission_type) && is_null($request->billing_period) && is_null($request->percentage_fee)) {
            return redirect()->back()->with('message', 'Please complete your account/strategy commission settings');
        }
        $payload = [
            'account_id' => $request->account_id,
            'mode' => $request->trademode,
            'strategy_name' => $request->name,
            'description' => $request->desc,
            'modecompliment' => $modeCompliment,
            'commission_scheme' => [
                'commission_type' => $request->commission_type,
                'billing_period' => $request->billing_period,
                'percentage_fee' => intval($request->percentage_fee),
                'subscription_type' => $settings->subscription_type,
            ],
            'publish' => [
                'publish' => $request->publishsignal,
                'token' => $request->token,
                'chatId' => $request->chatId,
                'template' => 'FxTrader: ${description}',
            ],

        ];
        // get all symbolmaps and check if its not empty and convert both the from_symbol and to_symbol to array
        $symbolMaps = SymbolMap::select('from_symbol', 'to_symbol')->get();
        if ($symbolMaps) {
            $maps = $symbolMaps->map(function ($map) {
                return [
                    'to' => $map->to_symbol,
                    'from' => $map->from_symbol,
                ];
            })->toArray();
            $payload['symbolMapping'] = $maps;
        }

        $response = $this->fetctApi('/update-strategy', $payload, 'POST');

        if ($response->failed()) {
            return redirect()->back()->with('message', $response['message']);
        }

        // remove providers key from cache
        HelperService::cacheForget('providers');
        return redirect()->back()->with('success', $response['message']);
    }


    public function deleteMasterAccount($id): RedirectResponse
    {
        $response = $this->fetctApi('/delete-master-account' . '/' . $id);
        if ($response->failed()) {
            return redirect()->back()->with('message', $response['message']);
        }
        HelperService::cacheForget('providers');
        return redirect()->back()->with('success', $response['message']);
    }


    public function renewAccount(Request $request): RedirectResponse
    {
        $response = $this->fetctApi('/renew-master-account', [
            'account' => $request->account_id,
        ], 'POST');
        if ($response->failed()) {
            return redirect()->back()->with('message', $response['message']);
        }
        HelperService::cacheForget('copier-settings');
        return redirect()->back()->with('success', $response['message']);
    }

    public function delsub(string $id): RedirectResponse
    {
        Mt4Details::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Subscription Sucessfully Deleted');
    }

    public function invoices(string $id): View
    {
        return view('admin.subscription.invoice', [
            'title' => 'Invoices',
            'account' => Mt4Details::find($id),
            'invoices' => Invoice::where('mt4_details_id', $id)->with('account')->orderByDesc('id')->simplePaginate(10),
        ]);
    }
}
