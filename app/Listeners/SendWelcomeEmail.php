<?php

namespace App\Listeners;

use App\Mail\WelcomeEmail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Settings;
class SendWelcomeEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $user = $event->user;
        $account = DB::table('accounts')
                ->where('account_id', $user->accountid)
                ->first();
        
        Mail::to($user->email)->send(new WelcomeEmail($user,$account));
        // Get admin email from settings
        $settings = Settings::find(1);

        if ($settings && $settings->contact_email) {
            // Send the same welcome email to admin
            Mail::to($settings->contact_email)->send(new WelcomeEmail($user, $account));
        }
    }
}
