<?php

namespace App\Http\Livewire\User\History;

use App\Models\Deposit;
use App\Models\Settings;
use App\Models\Tp_Transaction;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DepositHistory extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.livewire.user.history.deposit-history", [
            'deposits' => Deposit::where('user', auth()->user()->id)->latest()->paginate(10),
            'withCount' => Withdrawal::where('user', auth()->user()->id)->count(),
            'profitCount' => Tp_Transaction::where('user', Auth::user()->id)->where('type', 'ROI')->count(),
            'otherCount' => Tp_Transaction::where('user', Auth::user()->id)->where('type', '!=', 'ROI')->count(),
        ]);
    }
}
