<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CryptoAccount;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Plans;
use App\Models\User_plans;
use App\Models\Mt4Details;
use App\Models\Deposit;
use App\Models\Invoice;
use App\Models\SettingsCont;
use App\Models\Wdmethod;
use App\Models\Withdrawal;
use App\Models\Tp_Transaction;
use App\Services\SignalService;
use App\Services\TradeCopier;
use App\Traits\PingServer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ViewsController extends Controller
{
    use PingServer;

    public function dashboard(Request $request)
    {
        $settings = Settings::where('id', '1')->first();
        $user = User::find(auth()->user()->id);

        //check if user does not have ref link then update his link
        if ($user->ref_link == '') {
            User::where('id', $user->id)
                ->update([
                    'ref_link' => $settings->site_address . '/ref/' . $user->username,
                ]);
        }

        //give reg bonus if new
        if ($user->signup_bonus != "received" && ($settings->signup_bonus != NULL && $settings->signup_bonus > 0)) {
            User::where('id', $user->id)
                ->update([
                    'bonus' => $user->bonus + $settings->signup_bonus,
                    'account_bal' => $user->account_bal + $settings->signup_bonus,
                    'signup_bonus' => "received",
                ]);
            //create history
            Tp_Transaction::create([
                'user' => Auth::user()->id,
                'plan' => "SignUp Bonus",
                'amount' => $settings->signup_bonus,
                'type' => "Bonus",
            ]);
        }

        if (DB::table('crypto_accounts')->where('user_id', Auth::user()->id)->doesntExist()) {
            $cryptoaccnt = new CryptoAccount();
            $cryptoaccnt->user_id = Auth::user()->id;
            $cryptoaccnt->save();
        }

        //sum total deposited
        $total_deposited = DB::table('deposits')->where('user', $user->id)->where('status', 'Processed')->sum('amount');

        $total_withdrawal = DB::table('withdrawals')->where('user', $user->id)->where('status', 'Processed')->sum('amount');

        //log user out if not blocked by admin
        if ($user->status != "active") {
            $request->session()->flush();
            return redirect()->route('dashboard');
        }

        return view("{$settings->theme}.user.dashboard", [
            'title' => 'Account Dashboard',
            'deposited' => $total_deposited,
            'total_withdrawal' => $total_withdrawal,
            'trading_accounts' => Mt4Details::where('client_id', Auth::user()->id)->where('status', '!=', 'Pending')->count(),
            'plans' => User_plans::where('user', Auth::user()->id)->where('active', 'yes')->orderByDesc('id')->skip(0)->take(2)->get(),
            't_history' => Tp_Transaction::where('user', Auth::user()->id)
                ->where('type', '<>', 'ROI')
                ->orderByDesc('id')->take(5)
                ->get(),
            'referrals' => User::where('ref_by', Auth::user()->id)->count(),
        ]);
    }

    //Profile route
    public function profile()
    {
        $settings = Settings::select('theme')->find(1);
        $userinfo = User::where('id', Auth::user()->id)->first();

        $methods = Wdmethod::select(['status', 'name', 'id'])
            ->where('type', '=', 'withdrawal')
            ->orWhere('type', '=', 'both')->get();

        return view("{$settings->theme}.user.profile")->with(array(
            'userinfo' => $userinfo,
            'bankTransfer' => $methods->where('name', 'Bank Transfer')->first(),
            'bitcoin' => $methods->where('name', 'Bitcoin')->first(),
            'ethereum' => $methods->where('name', 'Ethereum')->first(),
            'litecoin' => $methods->where('name', 'Litecoin')->first(),
            'usdt' => $methods->where('name', 'USDT')->first(),
            'title' => 'Profile',
        ));
    }

    //return add withdrawal account form view
    public function accountdetails()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.user.updateacct")->with(array(
            'title' => 'Update account details',
        ));
    }


    //support route
    public function support()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.user.support")
            ->with(array(
                'title' => 'Support',
            ));
    }

    //Trading history route
    public function tradinghistory()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.user.thistory")
            ->with(array(
                't_history' => Tp_Transaction::where('user', Auth::user()->id)
                    ->where('type', 'ROI')
                    ->orderByDesc('id')
                    ->paginate(15),
                'title' => 'Trading History',
            ));
    }

    //Account transactions history route
    public function accounthistory()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.user.transactions")
            ->with(array(
                't_history' => Tp_Transaction::where('user', Auth::user()->id)
                    ->where('type', '<>', 'ROI')
                    ->orderByDesc('id')
                    ->get(),

                'withdrawals' => Withdrawal::where('user', Auth::user()->id)->orderBy('id', 'desc')
                    ->get(),
                'deposits' => Deposit::where('user', Auth::user()->id)->where('payment_mode', '!=', 'Refund')->orderBy('id', 'desc')
                    ->get(),
                'title' => 'Account Transactions History',

            ));
    }
    public function withdrawHistory()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.user.history.withdraw-history", [
            'title' => "Withdrawal history"
        ]);
    }

    public function profitHistory()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.user.history.profit-history", [
            'title' => "Profit history"
        ]);
    }

    public function otherHistory()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.user.history.other-history", [
            'title' => "Others history"
        ]);
    }

    //Return deposit route
    public function deposits()
    {
        $settings = Settings::select('theme')->find(1);
        $paymethod = Wdmethod::where(function ($query) {
            $query->where('type', '=', 'deposit')
                ->orWhere('type', '=', 'both');
        })->where('status', 'enabled')->orderByDesc('id')->get();

        //sum total deposited
        $total_deposited = DB::table('deposits')->where('user', auth()->user()->id)->where('status', 'Processed')->sum('amount');

        return view("{$settings->theme}.user.deposits")
            ->with(array(
                'title' => 'Fund your account',
                'dmethods' => $paymethod,
                'deposits' => Deposit::where(['user' => Auth::user()->id])
                    ->orderBy('id', 'desc')
                    ->get(),
                'deposited' => $total_deposited,
            ));
    }

    //Return withdrawals route
    public function withdrawals()
    {
        $settings = Settings::select('theme')->find(1);
        $withdrawals =  Wdmethod::where(function ($query) {
            $query->where('type', '=', 'withdrawal')
                ->orWhere('type', '=', 'both');
        })->where('status', 'enabled')->orderByDesc('id')->get();

        return view("{$settings->theme}.user.withdrawals")
            ->with(array(
                'title' => 'Withdraw Your funds',
                'wmethods' => $withdrawals,
            ));
    }

    public function transferview()
    {
        $settings = SettingsCont::find(1);
        $set = Settings::select('theme')->find(1);
        if (!$settings->use_transfer) {
            abort(404);
        }
        return view("{$set->theme}.user.transfer", [
            'title' => 'Send funds to a friend',
        ]);
    }

    //Subscription Trading 
    public function subtrade()
    {
        $settings = Settings::where('id', 1)->first();
        $mod = $settings->modules;
        if (!$mod['subscription']) {
            abort(404);
        }
        return view("{$settings->theme}.user.subtrade")
            ->with(array(
                'title' => 'Subscription Trade',
                'subscriptions' => Mt4Details::where('client_id', auth()->user()->id)->orderBy('id', 'desc')->get(),
            ));
    }

    public function invoice(): View
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.user.mam.invoice", [
            'invoices' => Invoice::where('user_id', Auth::user()->id)->with(['user', 'account'])->orderByDesc('id')->simplePaginate(),
        ]);
    }

    public function providers(TradeCopier $copier): View
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.user.mam.providers", [
            'providers' => $copier->providers(),
        ]);
    }

    public function providerAccountMetrics(TradeCopier $copier, string $account, string $name): View | RedirectResponse
    {
        $settings = Settings::select('theme')->find(1);
        try {
            return view("{$settings->theme}.user.mam.metrics", [
                'metrics' => $copier->accountMetrics($account, 'Provider'),
                'accountName' => $name,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    //Main Plans route
    public function mplans()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.user.mplans")
            ->with(array(
                'title' => 'Main Plans',
                'plans' => Plans::where('type', 'main')->get(),
                'settings' => Settings::where('id', '1')->first(),
            ));
    }

    //My Plans route
    public function myplans($sort)
    {
        $settings = Settings::select('theme')->find(1);
        if ($sort == 'All') {
            return view("{$settings->theme}.user.myplans")
                ->with(array(
                    'numOfPlan' => User_plans::where('user', Auth::user()->id)->count(),
                    'title' => 'Your packages',
                    'plans' => User_plans::where('user', Auth::user()->id)->orderByDesc('id')->paginate(10),
                    'settings' => Settings::where('id', '1')->first(),
                ));
        } else {
            return view("{$settings->theme}.user.myplans")
                ->with(array(
                    'numOfPlan' => User_plans::where('user', Auth::user()->id)->count(),
                    'title' => 'Your packages',
                    'plans' => User_plans::where('user', Auth::user()->id)->where('active', $sort)->orderByDesc('id')->paginate(10),
                    'settings' => Settings::where('id', '1')->first(),
                ));
        }
    }


    public function sortPlans($sort)
    {
        return redirect()->route('myplans', ['sort' => $sort]);
    }

    public function planDetails($id)
    {
        $settings = Settings::select('theme')->find(1);
        $plan = User_plans::find($id);
        return view("{$settings->theme}.user.plandetails", [
            'title' => $plan->dplan->name,
            'plan' => $plan,
            'transactions' => Tp_Transaction::where('type', 'ROI')->where('user_plan_id', $plan->id)->orderByDesc('id')->paginate(10),
        ]);
    }


    function twofa()
    {
        $settings = Settings::select('theme')->find(1);
         return redirect('/dashboard/account-settings');
    }

    // Referral Page
    public function referuser()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.user.referuser", [
            'title' => 'Refer user',
        ]);
    }

    public function verifyaccount()
    {
        $settings = Settings::select('theme')->find(1);
        if (Auth::user()->account_verify == 'Verified') {
            abort(404, 'You do not have permission to access this page');
        }
        return view("{$settings->theme}.user.verify", [
            'title' => 'Verify your Account',
        ]);
    }

    public function verificationForm()
    {
        $settings = Settings::select('theme')->find(1);
        if (Auth::user()->account_verify == 'Verified') {
            abort(404, 'You do not have permission to access this page');
        }
        return view("{$settings->theme}.user.verification", [
            'title' => 'KYC Application'
        ]);
    }



    public function tradeSignals(SignalService $signal)
    {
        $settings = Settings::where('id', 1)->first();
        $mod = $settings->modules;
        if (!$mod['signal']) {
            abort(404);
        }

        $subscription = $signal->subscription(auth()->user()->id);
        $subSettings = $signal->setup();

        return view("{$settings->theme}.user.signals.subscribe", [
            'title' => 'Trade signals',
            'subscription' => $subscription,
            'set' => $subSettings,
        ]);
    }


    public function binanceSuccess()
    {
        return redirect()->route('deposits')->with('success', 'Your Deposit was successful, please wait while it is confirmed. You will receive a notification regarding the status of your deposit.');
    }

    public function binanceError()
    {
        return redirect()->route('deposits')->with('message', 'Something went wrong please try again. Contact our support center if problem persist');
    }
}
