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
    public $accountType;

    public function __construct(User $user, $account = null, $accountType = null)
    {
        $this->user = $user;
        $this->accountType = $accountType;

        if (!$this->accountType) {
            if ($user->is_secondary == 1) {
                $this->accountType = '2nd Account';
            } elseif ($user->is_secondary == 2) {
                $this->accountType = '3rd Account';
            } elseif ($user->is_secondary == 3) {
                $this->accountType = '4th Account';
            }
        }

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
        $siteName = $settings->site_name ?? config('app.name');

        $subject = "Welcome to {$siteName}";
        if ($this->accountType) {
            $subject .= " - {$this->accountType}";
        }

        return $this->markdown('emails.welcome')
                    ->subject($subject)
                    ->with([
                        'user' => $this->user,
                        'account' => $this->account,
                        'settings' => $settings,
                        'accountType' => $this->accountType,
                    ]);
    }
}
