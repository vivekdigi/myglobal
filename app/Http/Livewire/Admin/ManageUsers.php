<?php

namespace App\Http\Livewire\Admin;

use App\Models\Deposit;
use App\Models\Kyc;
use App\Models\Mt4Details;
use App\Models\Plans;
use App\Models\Settings;
use App\Models\Tp_Transaction;
use App\Models\User;
use App\Models\User_plans;
use App\Models\Withdrawal;
use App\Notifications\AccountNotification;
use App\Traits\PingServer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use Livewire\Component;

class ManageUsers extends Component
{
    use WithPagination, PingServer;

    protected $paginationTheme = 'bootstrap';
    public $pagenum = 10;
    public $searchvalue = '';
    public $orderby = 'id';
    public $orderdirection = 'desc';
    public $selectPage = false;
    public $selectAll = false;
    public $checkrecord = [];
    public $selected = '';
    public $action = 'Delete';
    public $username;
    public $fullname;
    public $email;
    public $accountid;
    public $password;
    public $message;
    public $subject;
    public $plan;
    public $datecreated;
    public $topamount;
    public $toptype;
    public $topcolumn = "Bonus";
    public $userTypes = "All";

    /* public function getUsersProperty()
    {

        return User::search($this->searchvalue)
            ->select('id', 'name', 'username', 'email', 'phone', 'account_bal', 'status', 'created_at', 'country', 'accountid')
            ->orderBy($this->orderby, $this->orderdirection)
            ->paginate($this->pagenum);
    } */
    public function getUsersProperty_old()
    {
    return User::search($this->searchvalue)
        ->leftJoin('accounts', 'users.accountid', '=', 'accounts.account_id')
        ->select(
            'users.id',
            'users.name',
            'users.username',
            'users.email',
            'users.phone',
            'users.account_bal',
            'users.status',
            'users.created_at',
            'users.country',
            'users.accountid',
            'accounts.investor_password',
            'accounts.master_password'
        )
        ->orderBy($this->orderby, $this->orderdirection)
        ->paginate($this->pagenum);
    }
    public function updatingSearchvalue()
    {
        $this->resetPage();
    }

    public function updatingOrderby()
    {
        $this->resetPage();
    }

    public function updatingOrderdirection()
    {
        $this->resetPage();
    }

    public function updatingPagenum()
    {
        $this->resetPage();
    }

    public function getUsersProperty()
    {
    $query = User::query();
    
    // Left join accounts table
    $query->leftJoin('accounts', 'users.accountid', '=', 'accounts.account_id');
    
    // Search filter
    if (!empty($this->searchvalue)) {
        $search = $this->searchvalue;
        $query->where(function($q) use ($search) {
            $q->where('users.id', 'like', "%{$search}%")
              ->orWhere('users.name', 'like', "%{$search}%")
              ->orWhere('users.username', 'like', "%{$search}%")
              ->orWhere('users.email', 'like', "%{$search}%")
              ->orWhere('users.accountid', 'like', "%{$search}%");
        });
    }
    
    // Select all columns + processed deposit count
    $query->select(
        'users.id',
        'users.name',
        'users.username',
        'users.email',
        'users.phone',
        'users.account_bal',
        'users.status',
        'users.created_at',
        'users.country',
        'users.accountid',
        'accounts.investor_password',
        'accounts.master_password',
        DB::raw("(SELECT COUNT(*) FROM deposits 
                  WHERE deposits.user = users.id 
                  AND deposits.status = 'Processed') AS paid_count")
    );
    
    if ($this->orderby === 'account_bal') {
        $query->orderBy(DB::raw('CAST(users.account_bal AS DECIMAL(15, 2))'), $this->orderdirection);
    } else {
        $orderColumn = in_array($this->orderby, ['id', 'name', 'username', 'email', 'phone', 'status', 'created_at', 'country', 'accountid'])
            ? 'users.' . $this->orderby
            : $this->orderby;
        $query->orderBy($orderColumn, $this->orderdirection);
    }

    return $query->paginate($this->pagenum);
    }
    public function getUsersProperty_old1()
{
    // Assuming 'search' is a scope or macro that you can adjust,
    // if not, you may need to replace it with explicit where clauses.

    // Start with User model query builder
    $query = User::query();

    // Left join accounts table
    $query->leftJoin('accounts', 'users.accountid', '=', 'accounts.account_id');

    // Apply search filter explicitly on qualified columns to avoid ambiguity
    if (!empty($this->searchvalue)) {
        $search = $this->searchvalue;
        $query->where(function($q) use ($search) {
            $q->where('users.id', 'like', "%{$search}%")
              ->orWhere('users.name', 'like', "%{$search}%")
              ->orWhere('users.username', 'like', "%{$search}%")
              ->orWhere('users.email', 'like', "%{$search}%")
              ->orWhere('users.accountid', 'like', "%{$search}%");
        });
    }

    // Select columns from both tables, fully qualified
    $query->select(
        'users.id',
        'users.name',
        'users.username',
        'users.email',
        'users.phone',
        'users.account_bal',
        'users.status',
        'users.created_at',
        'users.country',
        'users.accountid',
        'accounts.investor_password',
        'accounts.master_password'
    );

    // Order and paginate
    return $query
        ->orderBy($this->orderby, $this->orderdirection)
        ->paginate($this->pagenum);
}

    public function render()
    {
        if ($this->selectAll) {
            $this->checkrecord = $this->users->pluck('id')->map(fn ($id) => (string) $id);
        }
        return view('livewire.admin.manage-users', [
            'users' => $this->users,
            'plans' => Plans::all(),
        ]);
    }

    public function updatedCheckrecord()
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checkrecord = $this->users->pluck('id')->map(fn ($id) => (string) $id);
        } else {
            $this->checkrecord = [];
        }
    }

    public function selectAll()
    {
        $this->selectAll = true;
    }


    public function saveUser()
    {
        if (DB::table('users')->where('username', $this->username)->exists() || DB::table('users')->where('email', $this->email)->exists()) {
            session()->flash('message', 'Username or Email already exists!');
            return redirect()->route('manageusers');
        }

        $thisid = DB::table('users')->insertGetId([
            'name' => $this->fullname,
            'email' => $this->email,
            'ref_by' => NULL,
            'username' => $this->username,
            'password' => Hash::make($this->password),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        //assign referal link to user
        $settings = Settings::where('id', '=', '1')->first();
        $user = User::where('id', $thisid)->first();

        User::where('id', $thisid)
            ->update([
                'ref_link' => $settings->site_address . '/ref/' . $user->username,
            ]);

        session()->flash('success', 'User created Sucessfully!');
        return redirect()->route('manageusers');
    }

    public function addRoi()
    {
        $plan = Plans::where('id', $this->plan)->first();
        DB::table('users')
            ->whereIn('id', $this->checkrecord)
            ->chunkById(100, function ($users) use ($plan) {
                foreach ($users as $user) {
                    $userplans = User_plans::where('user', $user->id)->where('plan', $plan->id)->where('active', 'yes')->get();
                    if (count($userplans) > 0) {

                        foreach ($userplans as $uplan) {

                            $amount = $uplan->amount * $plan->increment_amount / 100;

                            $newt = new Tp_Transaction();
                            $newt->user = $user->id;
                            $newt->plan = $plan->name;
                            $newt->amount = $amount;
                            $newt->type = 'ROI';
                            $newt->user_plan_id = $uplan->id;
                            $newt->created_at = Carbon::parse($this->datecreated);
                            $newt->updated_at = Carbon::parse($this->datecreated);
                            $newt->save();

                            User::where('id', $user->id)
                                ->update([
                                    'roi' => $user->roi + $amount,
                                    'account_bal' => $user->account_bal + $amount,
                                ]);

                            $dplan = User_plans::where('id', $uplan->id)->first();
                            $dplan->profit_earned = $uplan->profit_earned + $amount;
                            $dplan->save();
                        }
                    }
                }
            });
        session()->flash('success', 'Action Successful');
        return redirect()->route('manageusers');
    }


    public function topup()
    {
        $users = User::whereIn('id', $this->checkrecord)
            ->get();

        foreach ($users as $user) {

            $response = $this->callServer('typesystem', '/top-up', [
                'topUpType' => $this->toptype,
                'userBalance' => $user->account_bal,
                'userRoi' => $user->roi,
                'userRef' => $user->ref_bonus,
                'userBonus' => $user->bonus,
                'type' => $this->topcolumn,
                'amount' => $this->topamount,
            ]);

            if ($response->failed()) {
                return redirect()->route('manageusers')->with('message', $response['message']);
            }

            $formatResponse = json_decode($response);

            if ($formatResponse->data->whatType == "Bn2r5u8x/A?D(G+KbPeShVkYp3s6v9yonus") {
                User::where('id', $user->id)
                    ->update([
                        'bonus' => $formatResponse->data->bonus,
                        'account_bal' => $formatResponse->data->accountBalance,
                    ]);
            } elseif ($formatResponse->data->whatType == "A?D(G+KbPeShVkYp3s6v9yB&E)H@Mc") {
                User::where('id', $user->id)
                    ->update([
                        'account_bal' =>  $formatResponse->data->accountBalance,
                    ]);
            }

            //add history
            Tp_Transaction::create([
                'user' => $user->id,
                'plan' =>  $formatResponse->data->type,
                'amount' => $this->topamount,
                'type' => $this->topcolumn,
            ]);

            //$currency = Settings::select('currency')->find(1);
            //$user->notify(new AccountNotification("You have a new {$this->topcolumn} transaction. Amount: {$currency}{$this->topamount}.", 'System Topup'));
        }

        session()->flash('success', 'Action Successful');
        return redirect()->route('manageusers');
    }

    //Delete user
    public function delsystemuser()
    {
        $users = DB::table('users')
            ->whereIn('id', $this->checkrecord)
            ->get();

        foreach ($users as $user) {

            if ($this->action == 'Delete') {
                //delete the user's withdrawals and deposits
                $deposits = Deposit::where('user', $user->id)->get();
                if (!empty($deposits)) {
                    foreach ($deposits as $deposit) {
                        Deposit::where('id', $deposit->id)->delete();
                    }
                }
                $withdrawals = Withdrawal::where('user', $user->id)->get();
                if (!empty($withdrawals)) {
                    foreach ($withdrawals as $withdrawals) {
                        Withdrawal::where('id', $withdrawals->id)->delete();
                    }
                }
                //delete the user plans
                $userp = User_plans::where('user', $user->id)->get();
                if (!empty($userp)) {
                    foreach ($userp as $p) {
                        //delete plans that their owner does not exist 
                        User_plans::where('id', $p->id)->delete();
                    }
                }

                if (DB::table('mt4_details')->where('client_id', $user->id)->exists()) {
                    Mt4Details::where('client_id', $user->id)->delete();
                }

                // delete user from verification list
                if (DB::table('kycs')->where('user_id', $user->id)->exists()) {
                    Kyc::where('user_id', $user->id)->delete();
                }


                User::where('id', $user->id)->delete();
            }

            if ($this->action == 'Clear') {

                $deposits = Deposit::where('user', $user->id)->get();
                if (!empty($deposits)) {
                    foreach ($deposits as $deposit) {
                        Deposit::where('id', $deposit->id)->delete();
                    }
                }

                $withdrawals = Withdrawal::where('user', $user->id)->get();
                if (!empty($withdrawals)) {
                    foreach ($withdrawals as $withdrawals) {
                        Withdrawal::where('id', $withdrawals->id)->delete();
                    }
                }

                User::where('id', $user->id)->update([
                    'account_bal' => '0',
                    'roi' => '0',
                    'bonus' => '0',
                    'ref_bonus' => '0',
                ]);
            }
        }

        session()->flash('success', 'Action successful!');
        return redirect()->route('manageusers');
    }
}
