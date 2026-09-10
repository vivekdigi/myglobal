<?php

namespace App\Http\Livewire\Admin\Mam;

use App\Services\TradeCopier;
use Dotenv\Util\Str;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class MasterAccountSetup extends Component
{
    public $publish;
    public $chatId;
    public $botToken;
    public $account;
    public $providers;
    public $subscribers;
    public $mysettings;
    public $amountPerSlot;
    public $acountId = 0;
    public $strategyName;
    public $strategyDesc;
    public $tradeMode;
    public $tradeDesc;
    public $modeInfo;
    public $compliment;
    public $commissionType;
    public $period;
    public $rate;


    public function mount(TradeCopier $copier)
    {
        try {
            $this->account = $copier->membershipProfile();
            $this->providers = $copier->providers();
            $this->subscribers = $copier->subscribers();
            $this->mysettings = $copier->settings();
            $this->amountPerSlot = $this->mysettings['amount_per_slot'];
        } catch (\Exception $e) {
            abort(403, $e->getMessage());
            session()->flash('error', $e->getMessage());
            return redirect('admin/dashboard/settings/app-settings');
        }
    }

    public function render()
    {
        return view('livewire.admin.mam.master-account-setup');
    }

    public function fetchStrategy(string $id, string $name, string $desc, string $mode, string $compliment, string $comType, string $rate, string $period, string $token, string $chatId, string $publish): void
    {

        $this->acountId = $id;
        $this->strategyName = $name;
        $this->strategyDesc = $desc;
        $this->tradeMode = $mode;
        $this->compliment = $compliment;
        $this->commissionType = $comType;
        $this->period = $period;
        $this->rate = $rate;
        $this->publish = boolval($publish);
        $this->botToken = $token;
        $this->chatId = $chatId;
        //dd($this->acountId);
    }
}
