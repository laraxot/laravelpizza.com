<?php

declare(strict_types=1);

namespace Modules\User\Traits;

use Illuminate\Validation\Rules\Password;

/**
 * Shared password validation rules for forms and Livewire components.
 */
trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, Password|string>
     */
    protected function passwordRules(): array
    {
        return ['required', 'string', Password::default(), 'confirmed'];
    }
}
