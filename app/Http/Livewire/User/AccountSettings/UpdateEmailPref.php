<?php

namespace App\Http\Livewire\User\AccountSettings;

use App\Models\Settings;
use App\Models\User;
use Livewire\Component;

class UpdateEmailPref extends Component
{
    public $emailOnWithdrawal;
    public $emailOnRoi;
    public $emailOnExpiration;

    public function mount()
    {
        $this->emailOnWithdrawal = auth()->user()->sendotpemail;
        $this->emailOnRoi = auth()->user()->sendroiemail;
        $this->emailOnExpiration = auth()->user()->sendinvplanemail;
    }

    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.livewire.user.account-settings.update-email-pref");
    }

    public function saveEmails(): void
    {
        $user = User::find(auth()->user()->id);
        $user->sendotpemail = $this->emailOnWithdrawal;
        $user->sendroiemail = $this->emailOnRoi;
        $user->sendinvplanemail = $this->emailOnExpiration;
        $user->save();

        $this->dispatchBrowserEvent('profile-updated', ['message' => 'Your email preferences is updated successfully.', 'type' => 'success']);
    }
}
