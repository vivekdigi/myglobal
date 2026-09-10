<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password as RulesPassword;
use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {
        return ['required', 'string', new Password, 'confirmed', RulesPassword::min(8)->mixedCase()->numbers()->symbols()->uncompromised()];
    }
}
