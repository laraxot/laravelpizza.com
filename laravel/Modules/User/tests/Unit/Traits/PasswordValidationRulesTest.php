<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Traits;

uses(\Modules\User\Tests\TestCase::class);

use Modules\User\Traits\PasswordValidationRules;

test('PasswordValidationRules trait can be used', function () {
    $testClass = new class {
        use PasswordValidationRules;

        /**
         * @return array<int, string>
         */
        public function getPasswordRules(): array
        {
            return $this->passwordRules();
        }
    };

    expect($testClass)->toBeObject();
});

test('PasswordValidationRules trait provides passwordRules method', function () {
    $testClass = new class {
        use PasswordValidationRules;

        /**
         * @return array<int, string>
         */
        public function passwordRules(): array
        {
            return ['required', 'string', 'confirmed'];
        }

        /**
         * @return array<int, string>
         */
        public function getPasswordRules(): array
        {
            return $this->passwordRules();
        }
    };

    $rules = $testClass->getPasswordRules();

    expect($rules)->toBeArray()
        ->and($rules)->toHaveCount(3);
});
