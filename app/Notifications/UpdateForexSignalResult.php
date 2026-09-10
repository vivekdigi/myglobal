<?php

namespace App\Notifications;

use App\Models\SettingsCont;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class UpdateForexSignalResult extends Notification
{
    use Queueable;

    public $signal, $screenshot;
    public $chatID;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($signal, $chatID, $screenshot = null)
    {
        $this->signal = $signal;
        $this->screenshot = $screenshot;
        $this->chatID = $chatID;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ["telegram"];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            // Optional recipient user id.
            ->to($this->chatID)
            // Markdown supported.
            ->content($this->signal);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}