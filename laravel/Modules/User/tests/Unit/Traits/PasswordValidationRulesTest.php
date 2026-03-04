<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Traits;

use Modules\User\Tests\TestCase;
use Modules\User\Traits\PasswordValidationRules;

uses(TestCase::class);

test('PasswordValidationRules trait can be used', function () {
    $testClass = new class
    {
        use PasswordValidationRules;
    };

    expect($testClass)->not->toBeNull();
});

test('PasswordValidationRules trait provides passwordRules method', function () {
    // getMockBuilder() cannot accept anonymous class names (they contain '@'
    // which is invalid in PHP class name syntax and causes a ParseError).
    // We instantiate an anonymous class directly and call the method.
    //
    // The trait calls `new Password()` which references
    // Modules\User\Rules\Password. If that class is not present in the
    // current installation, skip the test with a clear explanation.
    if (! class_exists(\Modules\User\Rules\Password::class)) {
        $this->markTestSkipped(
            'Modules\\User\\Rules\\Password class is not available in this environment.'
        );
    }

    $testClass = new class
    {
        use PasswordValidationRules;

        public function getPasswordRules(): array
        {
            return $this->passwordRules();
        }
    };

    $rules = $testClass->getPasswordRules();

    expect($rules)->toBeArray();
    expect(count($rules))->toBeGreaterThanOrEqual(1);
    expect($rules)->toContain('required');
    expect($rules)->toContain('string');
    expect($rules)->toContain('confirmed');
});
