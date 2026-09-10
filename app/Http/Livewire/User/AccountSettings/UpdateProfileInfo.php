<?php

namespace App\Http\Livewire\User\AccountSettings;

use App\Models\Settings;
use App\Models\User;
use Livewire\Component;

class UpdateProfileInfo extends Component
{
    public $name;
    public $email;
    public $phone;
    public $country;
    public $username;

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
        $this->phone = auth()->user()->phone;
        $this->country = auth()->user()->country;
        $this->username = auth()->user()->username;
    }

    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.livewire.user.account-settings.update-profile-info", []);
    }

    public function updateProfileInfo()
    {
        $this->validate([
            'name' => ['required'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:9'],
        ]);

        User::find(auth()->user()->id)->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'country' => $this->country,
        ]);

        $this->dispatchBrowserEvent('profile-updated', ['message' => 'Your account is updated successfully.', 'type' => 'success']);
    }
}
