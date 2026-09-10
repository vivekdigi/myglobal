<?php

namespace App\Http\Livewire\User;

use App\Models\Settings;
use App\Models\User;
use App\Services\SignalService;
use App\Traits\PingServer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SubscribeToSignal extends Component
{
    use PingServer;

    public $duration;
    public $amount;
    public $expire;
    public $hasSubscribe;
    public $inviteLink;
    public $monthly, $yearly, $quarterly;

    public function mount(SignalService $signal)
    {
        $this->duration = 'Choose';
        $this->hasSubscribe = false;
        $settings = $signal->setup();

        if (Arr::exists($settings, 'error') && $settings['error'] == true) {
            session()->flash('message', $settings['errorMessage']);
            return redirect()->route('tsignals');
        }

        $this->monthly = $settings['signal_monthly_fee'] ?? '';
        $this->yearly = $settings['signal_yearly_fee'] ?? '';
        $this->quarterly = $settings['signal_quartly_fee'] ?? '';
    }

    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.livewire.user.subscribe-to-signal");
    }

    public function calculate()
    {
        if ($this->duration == 'Monthly') {
            $this->amount = $this->monthly;
            $this->expire = now()->addMonth();
        } elseif ($this->duration == 'Quarterly') {
            $this->amount = $this->quarterly;
            $this->expire = now()->addMonths(4);
        } elseif ($this->duration == 'Yearly') {
            $this->amount = $this->yearly;
            $this->expire = now()->addYear();
        } else {
            $this->amount = '';
            unset($this->expire);
        }
    }

    public function subscribe()
    {
        $user = User::find(Auth::user()->id);

        if ($user->account_bal < floatval($this->amount)) {
            session()->flash('message', 'You have insufficient funds in your account balance to perform this action');
            return redirect()->route('tsignals');
        } else {

            $response = $this->fetctApi('/subscribe', [
                'id' => $user->id,
                'duration' => $this->duration,
                'amount' => $this->amount,
                'expire' => $this->expire,
            ], 'POST');

            if ($response->failed()) {
                session()->flash('message', 'Something went wrong, please try again or contact support');
                return redirect()->route('tsignals');
            } else {
                $res = json_decode($response);

                //debit user
                $user->account_bal = $user->account_bal - floatval($this->amount);
                $user->save();

                $this->inviteLink = $res->data->inviteLink;
                $this->hasSubscribe = $res->data->hasSubscribe;
                session()->flash('success', 'You have succesfully subscribed to trading signal');
            }
        }
    }
}
