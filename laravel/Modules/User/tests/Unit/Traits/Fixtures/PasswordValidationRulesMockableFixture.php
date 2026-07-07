<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Traits\Fixtures;

use Modules\User\Traits\PasswordValidationRules;

/**
 * Mockable stand-in for password rule consumers in unit tests.
 */
final class PasswordValidationRulesMockableFixture
{
    use PasswordValidationRules;

    /**
     * @return array<int, \Illuminate\Validation\Rules\Password|array<int, string>|string>
     */
    public function getPasswordRules(): array
    {
        return $this->passwordRules();
    }
}
