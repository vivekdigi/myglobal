<?php

namespace App\Http\Livewire\User\AccountSettings;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UpdatePassword extends Component
{
    public $password;
    public $current_password;
    public $password_confirmation;
    use PasswordValidationRules;
    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.livewire.user.account-settings.update-password");
    }

    public function update()
    {
        $input = [
            'current_password' => $this->current_password,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ];
        $user = User::find(auth()->user()->id);

        Validator::make($input, [
            'current_password' => ['required', 'string'],
            'password' => $this->passwordRules(),
        ])->after(function ($validator) use ($user, $input) {
            if (!isset($input['current_password']) || !Hash::check($input['current_password'], $user->password)) {
                $this->dispatchBrowserEvent('profile-updated', ['message' => 'The provided password does not match your current password.', 'type' => 'error']);
            }
        })->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();

        $this->reset([
            'password',
            'current_password',
            'password_confirmation',
        ]);

        $this->dispatchBrowserEvent('profile-updated', ['message' => 'Your password is updated successfully.', 'type' => 'success']);
        return redirect()->route('profile');
    }
}
