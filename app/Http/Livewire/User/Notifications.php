<?php

namespace App\Http\Livewire\User;

use App\Models\Settings;
use App\Models\User;
use Livewire\Component;

class Notifications extends Component
{
    // create listener for notification count
    protected $listeners = ['addNotification' => '$refresh'];

    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.livewire.user.notifications", [
            'notifications' => auth()->user()->notifications
        ]);
    }

    // mark notification as read
    public function markAsRead(string $notificationId): void
    {
        auth()->user()->notifications->where('id', $notificationId)->markAsRead();
        $this->emit('updateNotification');
        $this->emit('addNotification');
    }

    // delete notification
    public function deleteNotification(string $notificationId): void
    {
        //$user = User::with('notifications')->find(auth()->user()->id);
        auth()->user()->notifications->where('id', $notificationId)->first()->delete();
        $this->emit('updateNotification');
        $this->emit('addNotification');
    }

    // markAllAsRead
    public function markAllAsRead(): void
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->emit('updateNotification');
        $this->emit('addNotification');
    }
}
