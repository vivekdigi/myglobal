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

    public function __construct(User $user, $account = null)
    {
        $this->user = $user;

        if ($account && (is_object($account) || is_array($account))) {
            $this->account = is_array($account) ? (object) $account : $account;
        } else {
            // Fetch account using SQL
            $this->account = DB::table('accounts')
                                ->where('account_id', $user->accountid)
                                ->first();

            // If not found and user is a secondary/sub account, fallback to parent's account
            if (!$this->account && !empty($user->parent_user_id)) {
                $parent = User::find($user->parent_user_id);
                if ($parent) {
                    $this->account = DB::table('accounts')
                                        ->where('account_id', $parent->accountid)
                                        ->first();
                }
            }
        }
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
