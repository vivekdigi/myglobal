<?php

namespace App\Actions\Fortify;

use App\Mail\WelcomeEmail;
use App\Models\User;
use App\Models\Settings;
use App\Models\Agent;
use App\Models\CryptoAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Notifications\AccountNotification;
class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $settings = Settings::where('id', '1')->first();
        $request = request();

        if ($settings->captcha == "true") {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'unique:users,username', 'regex:/^\S*$/u'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
                'g-recaptcha-response' => 'required|captcha',
                'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:9'],
                'country' => ['required'],
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
            ])->validate();
        } else {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'unique:users,username', 'regex:/^\S*$/u'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:9'],
                'password' => $this->passwordRules(),
                'country' => ['required'],
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
            ])->validate();
        }

        // Referral System
        if (session('ref_by')) {
            $ref_by = session('ref_by');
            $userRef = User::where('username', $ref_by)->first();
            $ref_by_id = $userRef ? $userRef->id : null;
        } else {
            if (!empty($input['ref_by'])) {
                $sponsor = User::where('username', $input['ref_by'])->first();
                $ref_by_id = $sponsor ? $sponsor->id : null;
            } else {
                $ref_by_id = null;
            }
        }

        // Generate next account ID
        $lastAccountId = User::orderByDesc('id')->value('accountid');
        $nextAccountId = $lastAccountId ? (int)$lastAccountId + 1 : 10200;

        // Create User
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'username' => $input['username'],
            'country' => $input['country'],
            'ref_by' => $ref_by_id,
            'status' => 'active',
            'password' => Hash::make($input['password']),
            'accountid' => $nextAccountId,
        ]);

        // Create crypto account
        CryptoAccount::create([
            'user_id' => $user->id
        ]);

        $request->session()->forget('ref_by');
        $user->notify(new AccountNotification(
        "Welcome {$user->name}! Your account has been successfully created.",
        "New Account Created"
        )); 
        // Send welcome emails
        try {
            Mail::to($user->email)->send(new WelcomeEmail($user,$nextAccountId));  // only 1 argument
            Mail::to('support@majestiglobal.com')->send(new WelcomeEmail($user,$nextAccountId));
        } catch (\Exception $e) {
            \Log::error("Welcome email failed: " . $e->getMessage());
        }

        return $user;
    }
}
