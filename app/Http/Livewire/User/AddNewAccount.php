<?php

namespace App\Http\Livewire\User;

use App\Mail\NewNotification;
use App\Models\Mt4Details;
use App\Models\Settings;
use App\Models\Tp_Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class AddNewAccount extends Component
{
    public $duration = 'Select duration';
    public $amount;
    public $metatrader = 'MT4';
    public $login;
    public $password;
    public $name;
    public $acnType;
    public $server;
    public $leverage;
    public $currency;
    public $errorMessage;

    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.livewire.user.add-new-account");
    }

    public function setAmount(): void
    {
        $settings = Settings::select('monthlyfee', 'quarterlyfee', 'yearlyfee')->find(1);

        if ($this->duration == 'Monthly') {
            $this->amount = floatval($settings->monthlyfee);
        } elseif ($this->duration == 'Quarterly') {
            $this->amount = floatval($settings->quarterlyfee);
        } elseif ($this->duration == 'Yearly') {
            $this->amount = floatval($settings->yearlyfee);
        } else {
            $this->amount = null;
        }
        $this->errorMessage = null;
    }

    public function addAccount()
    {
        if ($this->amount == null) {
            $this->errorMessage = 'Please select a duration';
            return;
        }

        if ($this->amount > 0 && (floatval(Auth::user()->account_bal)  < $this->amount)) {
            session()->flash('message', 'Sorry, your account balance is insufficient for this request.');
            return redirect('dashboard/subtrade');
        }

        if ($this->amount > 0) {
            User::where('id', Auth::user()->id)->update([
                'account_bal' => Auth::user()->account_bal - $this->amount,
            ]);
        }

        $mt4 = new Mt4Details();
        $mt4->client_id = Auth::user()->id;
        $mt4->mt4_id = $this->login;
        $mt4->mt4_password =  $this->password;
        $mt4->account_type = $this->acnType;
        $mt4->account_name = $this->name;
        $mt4->currency = $this->currency;
        $mt4->leverage = $this->leverage;
        $mt4->server = $this->server;
        $mt4->duration = $this->duration;
        $mt4->status = 'Pending';
        $mt4->mt_type = $this->metatrader;
        $mt4->save();

        //create history
        Tp_Transaction::create([
            'user' => Auth::user()->id,
            'plan' => "Subscribed MT4 Trading",
            'amount' => $this->amount,
            'type' => "MT4 Trading",
        ]);

        $settings = Settings::select('contact_email')->find(1);
        $user = Auth::user();

        $messaege = "This to notify you that $user->name submited MT4 details for trading, please login to take neccessary action";

        Mail::to($settings->contact_email)->send(new NewNotification($messaege, 'MT4 Details submitted', 'Admin'));

        session()->flash('success', 'Successfully subscribed to MT4 Trading, Please wait for the system to validate your credentials');
        return redirect('dashboard/subtrade');
    }
}
