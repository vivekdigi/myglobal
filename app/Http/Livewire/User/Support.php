<?php

namespace App\Http\Livewire\User;

use App\Models\Faq;
use App\Models\Settings;
use Livewire\Component;

class Support extends Component
{
    public $search = '';

    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.livewire.user.support", [
            'faqs' => Faq::latest()->search($this->search)->get(),
        ]);
    }
}
