<?php

namespace App\Http\Livewire\Admin;

use App\Models\Settings;
use Livewire\Component;

class ChooseTheme extends Component
{
    public $theme;
    public $sucMsg;

    public function mount()
    {
        $set = Settings::select('id', 'theme')->find(1);
        $this->theme = $set->theme;
    }
    public function render()
    {
        $set = Settings::select('id', 'themes')->find(1);
        return view('livewire.admin.choose-theme', [
            'themes' => $set->themes,
        ]);
    }

    // save the theme back to the json column of settings table
    public function saveTheme(): void
    {
        $set = Settings::select('id', 'theme')->find(1);
        $set->theme = $this->theme;
        $set->save();
        $this->sucMsg = 'Theme changed successfully';
    }

    public function addNewTheme()
    {
        $settings = Settings::select('id', 'themes')->find(1);
        $themes = $settings->themes;
        $themes = array_merge($themes, ['millage', 'purpose']);
        $settings->themes = $themes;
        $settings->save();
    }
}
