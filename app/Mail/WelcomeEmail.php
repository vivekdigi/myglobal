<?php

namespace App\Mail;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $account;

    public function __construct(User $user)
    {
        $this->user = $user;

        // ✅ Fetch account using SQL here
        $this->account = DB::table('accounts')
                            ->where('account_id', $user->accountid)
                            ->first();
    }

    public function build()
    {
        $settings = Settings::first();

        return $this->markdown('emails.welcome')
                    ->subject("Welcome to {$settings->site_name}")
                    ->with([
                        'user' => $this->user,
                        'account' => $this->account,
                        'settings' => $settings,
                    ]);
    }
}
