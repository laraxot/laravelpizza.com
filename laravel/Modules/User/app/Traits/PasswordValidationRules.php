<?php

declare(strict_types=1);

namespace Modules\User\Traits;

use Illuminate\Contracts\Validation\Rule;
use Modules\User\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * <<<<<<< HEAD
     *
     * @return array<int, (Rule|array|string)>
     *                                         =======
     * @return array<int, Password|string>
     *                                         >>>>>>> 9fa499be (.)
     */
    protected function passwordRules(): array
    {
        return ['required', 'string', new Password(), 'confirmed'];
    }
}
