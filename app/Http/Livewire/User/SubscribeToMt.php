<?php

namespace App\Http\Livewire\User;

use App\Models\Settings;
use App\Services\TradeCopier;
use Livewire\Component;

class SubscribeToMt extends Component
{
    public $providers;
    public $provider;

    public function mount(TradeCopier $copier)
    {
        $this->providers = $copier->providers();
    }

    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.livewire.user.subscribe-to-mt", []);
    }
}
