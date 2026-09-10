<?php

namespace App\Http\Livewire\Admin;

use App\Services\HelperService;
use App\Services\TradeCopier;
use App\Traits\PingServer;
use Livewire\Component;

class BuySlot extends Component
{
    use PingServer;
    public $amount;
    public $amountPerSlot;
    public $slot;
    public $message;

    public function mount(TradeCopier $copier)
    {
        $response = $copier->settings();
        $this->amountPerSlot = $response['amount_per_slot'];
    }

    public function render()
    {
        return view('livewire.admin.buy-slot');
    }

    public function calculateSlot()
    {
        $slot = $this->slot ? $this->slot : 0;
        $this->amount = $slot * floatval($this->amountPerSlot);
        $this->message = '';
    }


    public function purchaseSlot()
    {
        if ($this->slot > 0) {
            $response = $this->fetctApi('/purchase-slot', [
                'slot' => $this->slot,
                'amount' => $this->amount
            ], 'POST');
            if ($response->failed()) {
                session()->flash('message', $response['message']);
            } else {
                session()->flash('success', $response['message']);
            }
            HelperService::cacheForget('copier-settings');
            HelperService::cacheForget('account-profile');
            return redirect()->route('tsettings');
        } else {
            $this->message = 'Invalid Number of slot';
        }
    }
}
