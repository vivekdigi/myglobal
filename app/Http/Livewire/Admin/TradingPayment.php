<?php

namespace App\Http\Livewire\Admin;

use App\Services\TradeCopier;
use App\Traits\PingServer;
use Livewire\Component;
use Livewire\WithFileUploads;

class TradingPayment extends Component
{
    public $amount;
    public $toPay;
    public $wallet;
    public $walletAddress;
    public $method;
    public $screenshot;
    use WithFileUploads;
    use PingServer;

    public function mount(TradeCopier $copier)
    {
        $this->toPay = false;
        try {
            $response = $copier->settings();
            $this->method = $response['currency_name'];
            $this->walletAddress =  $response['wallet_address'];
            $this->wallet = $response;
        } catch (\Throwable $th) {
            $this->wallet = null;
            $this->walletAddress = null;
            $this->method = null;
        }
    }

    public function render()
    {
        return view('livewire.admin.trading-payment');
    }

    public function setToPay()
    {
        $this->toPay = true;
    }

    public function unSetToPay()
    {
        $this->toPay = false;
    }

    public function completePayment()
    {
        $response = $this->fetctApi('/save-payment', [
            'amount' => $this->amount,
        ], 'POST');

        if ($response->failed()) {
            session()->flash('message', $response['message']);
        } else {
            session()->flash('success', $response['message']);
        }
        return redirect()->route('tra.pay');
    }
}
