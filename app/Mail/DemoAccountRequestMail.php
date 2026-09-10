<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemoAccountRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $userEmail;
    public $userId;
    public $accountId;

    public function __construct($userName, $userEmail, $userId, $accountId)
    {
        $this->userName  = $userName;
        $this->userEmail = $userEmail;
        $this->userId    = $userId;
        $this->accountId = $accountId;
    }

    public function build()
    {
        return $this->markdown('emails.demo-account-request')
            ->subject('New Demo Account Request from ' . $this->userName);
    }
}
