<?php

namespace App\Http\Livewire\User\Mam;

use App\Models\Mt4Details;
use App\Models\Settings;
use App\Services\TradeCopier;
use App\Traits\PingServer;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CopyTrade extends Component
{
    use PingServer;

    public $providers = [];
    public $provider;
    public $scalingMode = 'none';
    public $strategyDescription = '';
    public $tradeAccount;

    public function mount(TradeCopier $copier, Mt4Details $sub): void
    {
        $this->tradeAccount = $sub;
        $this->providers = $copier->providers();
        $this->strategyDescription = "If value is none, then trade size will be preserved irregardless of the subscriber balance.";
    }

    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.livewire.user.mam.copy-trade");
    }

    public function showDescription(): void
    {
        if ($this->scalingMode == 'none') {
            $this->strategyDescription = "If value is none, then trade size will be preserved irregardless of the subscriber balance.";
        } elseif ($this->scalingMode == 'balance') {
            $this->strategyDescription = "If set to balance, the trade size on strategy subscriber will be scaled according to balance to preserve risk";
        } elseif ($this->scalingMode == 'equity') {
            $this->strategyDescription = "If set to equity, the trade size on strategy subscriber will be scaled according to subscriber equity.";
        } elseif ($this->scalingMode == 'contractSize') {
            $this->strategyDescription = "If value is contractSize, then trade size will be scaled according to contract size.";
        }
    }

    public function startCopying()
    {
        $tradingAccount = Mt4Details::find($this->tradeAccount->id);

        if (!Gate::allows('update-account', $tradingAccount)) {
            abort(403);
        }

        if ($this->provider == 'Choose') {
            session()->flash('message', 'Please select a provider');
            return redirect('dashboard/subtrade');
        }

        $response = $this->fetctApi('/copytrade-client', [
            'subscriber_login' => $this->tradeAccount->mt4_id,
            'master_account_id' => $this->provider,
            'scaling_mode' => $this->scalingMode,
        ], 'POST');

        if ($response->failed()) {
            session()->flash('message', $response['message']);
            return redirect('dashboard/subtrade');
        }

        $this->tradeAccount->update([
            'copying_trade' => true,
            'strategy' => $this->scalingMode,
        ]);

        session()->flash('success', $response['message']);
        return redirect('dashboard/subtrade');
    }
}
