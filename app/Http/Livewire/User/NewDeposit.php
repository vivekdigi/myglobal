<?php

namespace App\Http\Livewire\User;

use App\Models\Settings;
use Livewire\Component;

class NewDeposit extends Component
{
    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.livewire.user.new-deposit");
    }
}
