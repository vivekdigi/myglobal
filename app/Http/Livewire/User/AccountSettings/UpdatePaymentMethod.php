<?php

namespace App\Http\Livewire\User\AccountSettings;

use App\Models\Settings;
use App\Models\User;
use Livewire\Component;

class UpdatePaymentMethod extends Component
{
    public $bankName;
    public $accountNumber;
    public $accountName;
    public $swiftCode;
    public $btcAddress;
    public $ethAddress;
    public $ltcAddress;
    public $usdtAddress;


    public function mount(): void
    {
        $this->bankName = auth()->user()->bank_name;
        $this->accountNumber = auth()->user()->account_number;
        $this->accountName = auth()->user()->account_name;
        $this->swiftCode = auth()->user()->swift_code;
        $this->btcAddress = auth()->user()->btc_address;
        $this->ethAddress = auth()->user()->eth_address;
        $this->ltcAddress = auth()->user()->ltc_address;
        $this->usdtAddress = auth()->user()->usdt_address;
    }

    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.livewire.user.account-settings.update-payment-method");
    }

    public function save(): void
    {
        $this->validate([
            'bankName' => ['required', 'string', 'max:255'],
            'accountNumber' => ['required', 'string', 'max:255'],
            'accountName' => ['required', 'string', 'max:255'],
            'swiftCode' => ['required', 'string', 'max:255'],
            'btcAddress' => ['required', 'string', 'max:255'],
            'ethAddress' => ['required', 'string', 'max:255'],
            'ltcAddress' => ['required', 'string', 'max:255'],
            'usdtAddress' => ['required', 'string', 'max:255'],
        ]);

        $user = User::find(auth()->user()->id);
        $user->bank_name = $this->bankName;
        $user->account_number = $this->accountNumber;
        $user->account_name = $this->accountName;
        $user->swift_code = $this->swiftCode;
        $user->btc_address = $this->btcAddress;
        $user->eth_address = $this->ethAddress;
        $user->ltc_address = $this->ltcAddress;
        $user->usdt_address = $this->usdtAddress;
        $user->save();

        $this->dispatchBrowserEvent('profile-updated', ['message' => 'Your payment method is updated successfully.', 'type' => 'success']);
    }
}
