<?php

namespace App\Http\Livewire\User;

use App\Models\Settings;
use Livewire\Component;

class NotificationsCount extends Component
{
    // create listener for notification count
    protected $listeners = ['updateNotification' => '$refresh'];

    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.livewire.user.notifications-count", [
            'notificationsCount' => auth()->user()->unreadNotifications->count()
        ]);
    }
}
