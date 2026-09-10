<?php

namespace App\Http\Livewire\User;

use App\Models\Deposit;
use App\Models\Settings;
use App\Models\Tp_Transaction;
use App\Models\User;
use App\Models\User_plans;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class ReferralSystem extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public bool $viewRef;
    public string $refLevel;
    public $children;
    public $referrals;
    public $totalDeposit;
    public $totalAmountInPlans;
    public $totalProfit;
    public User $user;
    public float $commision;
    public string $level;
    public array $downlinesIds;
    public array $directIDs;
    public array $level1IDs;
    public array $level2IDs;
    public array $level3IDs;
    public array $level4IDs;
    public array $level5IDs;

    public function mount()
    {
        $this->viewRef = false;
        $this->level = 'Direct level';
        $this->directIDs = User::where('ref_by', auth()->user()->id)->pluck('id')->toArray();
        $this->level1IDs = User::whereIn('ref_by', $this->directIDs)->pluck('id')->toArray();
        $this->level2IDs = User::whereIn('ref_by', $this->level1IDs)->pluck('id')->toArray();
        $this->level3IDs = User::whereIn('ref_by', $this->level2IDs)->pluck('id')->toArray();
        $this->level4IDs = User::whereIn('ref_by', $this->level3IDs)->pluck('id')->toArray();
        $this->level5IDs = User::whereIn('ref_by', $this->level4IDs)->pluck('id')->toArray();

        $this->totalDeposit = $this->calculateDeposit($this->directIDs);
        $this->totalAmountInPlans = $this->totalAmountInPlans($this->directIDs);
        $this->totalProfit = $this->calculateProfit($this->directIDs);

        $settings = Settings::find(1);
        $this->commision = $settings->referral_commission;
    }

    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        $parent = User::where('id', auth()->user()->ref_by)->select(['id', 'name'])->first();
        return view("{$settings->theme}.livewire.user.referral-system", [
            'parent' => $parent,
            'downlines' => $this->getDownlines(auth()->user()->id),
        ]);
    }


    public function calculateDeposit(array $ids): float
    {
        if ($this->level == 'Direct level') {
            $children = User::where('ref_by', auth()->user()->id)->select(['id'])->get();
        } else {
            $children = User::whereIn('ref_by', $ids)->select(['id'])->get();
        }

        $total = 0;
        foreach ($children as $child) {
            $total += Deposit::where('user', $child->id)->where('status', 'Processed')->sum('amount');
        }
        return $total;
    }

    public function totalAmountInPlans(array $ids): float
    {
        if ($this->level == 'Direct level') {
            $children = User::where('ref_by', auth()->user()->id)->select(['id'])->get();
        } else {
            $children = User::whereIn('ref_by', $ids)->select(['id'])->get();
        }
        $total = 0;
        foreach ($children as $child) {
            $total += User_plans::where('user', $child->id)->sum('amount');
        }
        return $total;
    }

    public function calculateProfit(array $ids): float
    {
        if ($this->level == 'Direct level') {
            $children = User::where('ref_by', auth()->user()->id)->select(['id'])->get();
        } else {
            $children = User::whereIn('ref_by', $ids)->select(['id'])->get();
        }
        $total = 0;
        foreach ($children as $child) {
            $total += Tp_Transaction::where('user', $child->id)->where('type', 'ROI')->sum('amount');
        }
        return $total;
    }

    public function changeLevel(string $level): void
    {
        $this->level = $level;
        $settings = Settings::find(1);
        if ($level == 'Direct level') {
            $this->totalDeposit = $this->calculateDeposit($this->directIDs);
            $this->totalAmountInPlans = $this->totalAmountInPlans($this->directIDs);
            $this->totalProfit = $this->calculateProfit($this->directIDs);
        } elseif ($level == 'Level 1') {
            $downlines =  $this->getReferralsUnderLevel($this->directIDs);
            $this->children = $downlines->items();
            $this->totalDeposit = $this->calculateDeposit($this->directIDs);
            $this->totalAmountInPlans = $this->totalAmountInPlans($this->directIDs);
            $this->totalProfit = $this->calculateProfit($this->directIDs);
            $this->commision = floatval($settings->referral_commission1);
        } elseif ($level == 'Level 2') {
            $downlines =  $this->getReferralsUnderLevel($this->level1IDs);
            $this->children = $downlines->items();
            $this->totalDeposit = $this->calculateDeposit($this->level1IDs);
            $this->totalAmountInPlans = $this->totalAmountInPlans($this->level1IDs);
            $this->totalProfit = $this->calculateProfit($this->level1IDs);
            $this->commision = floatval($settings->referral_commission2);
        } elseif ($level == 'Level 3') {
            $downlines =  $this->getReferralsUnderLevel($this->level2IDs);
            $this->children = $downlines->items();
            $this->totalDeposit = $this->calculateDeposit($this->level2IDs);
            $this->totalAmountInPlans = $this->totalAmountInPlans($this->level2IDs);
            $this->totalProfit = $this->calculateProfit($this->level2IDs);
            $this->commision = floatval($settings->referral_commission3);
        } elseif ($level == 'Level 4') {
            $downlines =  $this->getReferralsUnderLevel($this->level3IDs);
            $this->children = $downlines->items();
            $this->totalDeposit = $this->calculateDeposit($this->level3IDs);
            $this->totalAmountInPlans = $this->totalAmountInPlans($this->level3IDs);
            $this->totalProfit = $this->calculateProfit($this->level3IDs);
            $this->commision = floatval($settings->referral_commission4);
        } elseif ($level == 'Level 5') {
            $downlines =  $this->getReferralsUnderLevel($this->level4IDs);
            $this->children = $downlines->items();
            $this->totalDeposit = $this->calculateDeposit($this->level4IDs);
            $this->totalAmountInPlans = $this->totalAmountInPlans($this->level4IDs);
            $this->totalProfit = $this->calculateProfit($this->level4IDs);
            $this->commision = floatval($settings->referral_commission5);
        }
    }


    public function getOtherColumns(string $id, string $type)
    {
        if ($type == 'deposit') {
            return Deposit::where('user', $id)->where('status', 'Processed')->sum('amount');
        }

        if ($type == 'invested') {
            return  User_plans::where('user', $id)->sum('amount');
        }

        if ($type == 'profit') {
            return Tp_Transaction::where('user', $id)->where('type', 'ROI')->sum('amount');
        }

        if ($type == 'recent') {
            return Tp_Transaction::where('user', $id)->where('type', 'ROI')->orderBy('id', 'desc')->first();
        }
    }

    public function getReferralsUnderLevel(array $ids)
    {
        $refs = User::whereIn('ref_by', $ids)->paginate(15);
        $refs->transform(function ($downline) {
            return [
                'id' => $downline->id,
                'name' => $downline->name,
                'email' => $downline->email,
                'totalDeposit' => $this->getOtherColumns($downline->id, 'deposit'),
                'totalInvestment' => $this->getOtherColumns($downline->id, 'invested'),
                'totalProfit' => $this->getOtherColumns($downline->id, 'profit'),
                'recent' => $this->getOtherColumns($downline->id, 'recent'),
                'parent' =>  User::where('id', $downline->ref_by)->select(['name'])->first(),
                'status' => $downline->status,
                'created_at' => $downline->created_at->format('d M, Y'),
            ];
        });
        return $refs;
    }

    public function showDetails(int $id): void
    {
        $settings = Settings::find(1);
        $this->user = User::where('id', $id)->select(['name', 'id'])->first();
        $downlines = $this->getDownlines($id);
        $this->referrals = $downlines->items();

        if ($this->level == 'Direct level') {
            $commission = $settings->referral_commission;
        } else {
            $num = Str::of($this->level)->after('Level ');
            $commission = $settings->referral_commission . $num;
        }
        $this->level = 'Level 1';

        $this->totalDeposit = $this->calculateDeposit([$id]);
        $this->totalAmountInPlans = $this->totalAmountInPlans([$id]);
        $this->totalProfit = $this->calculateProfit([$id]);
        $this->commision = floatval($commission);

        $this->viewRef = true;
    }

    public function cancelShowDeatials()
    {
        $settings = Settings::find(1);
        $this->level = 'Direct level';
        $commission = $settings->referral_commission;
        $this->totalDeposit = $this->calculateDeposit([$this->user->id]);
        $this->totalAmountInPlans = $this->totalAmountInPlans([$this->user->id]);
        $this->totalProfit = $this->calculateProfit([$this->user->id]);
        $this->commision = floatval($commission);

        $this->user = new User();
        $this->viewRef = false;
    }

    public function getDownlines($parent = 0)
    {
        //get downline using map function
        $downlines = User::where('ref_by', $parent)->select(['id', 'name', 'email', 'ref_by', 'status', 'created_at'])->orderByDesc('id')->paginate(10);

        $downlines->transform(function ($downline) {
            return [
                'id' => $downline->id,
                'name' => $downline->name,
                'email' => $downline->email,
                'totalDeposit' => $this->getOtherColumns($downline->id, 'deposit'),
                'totalInvestment' => $this->getOtherColumns($downline->id, 'invested'),
                'totalProfit' => $this->getOtherColumns($downline->id, 'profit'),
                'recent' => $this->getOtherColumns($downline->id, 'recent'),
                'parent' => User::where('id', $downline->ref_by)->select(['name'])->first(),
                'status' => $downline->status,
                'created_at' => $downline->created_at->format('d M, Y')
            ];
        });
        return $downlines;
    }
}
