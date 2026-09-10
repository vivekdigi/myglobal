<?php

namespace App\Http\Livewire\Admin\Platform;

use App\Models\Settings;
use Livewire\Component;

class ProductionSetup extends Component
{
    public $enviroment;
    public $appDebug;

    public function mount(): void
    {
        $settings = Settings::first();
        $this->enviroment = $settings->environment;
        $this->appDebug = $settings->debug_mode;
    }


    public function render()
    {
        return view('livewire.admin.platform.production-setup');
    }

    // save settings
    public function saveSettings(): void
    {
        $settings = Settings::first();
        $settings->environment = $this->enviroment;
        $settings->debug_mode = $this->appDebug;
        $settings->save();
        session()->flash('success-message', 'Settings saved successfully');
    }
}
