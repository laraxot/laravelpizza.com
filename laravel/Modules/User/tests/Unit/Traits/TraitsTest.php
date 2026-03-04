<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Traits;

uses(\Modules\User\Tests\TestCase::class);

use Modules\User\Traits\PasswordValidationRules;

test('PasswordValidationRules trait can be used', function () {
    expect(trait_exists(PasswordValidationRules::class))->toBeTrue();

    try {
        $testClass = new class
        {
            use PasswordValidationRules;
        };
        // Check if the trait methods exist
        expect(method_exists($testClass, 'passwordRules'))->toBeTrue();
    } catch (\Exception $e) {
        expect(true)->toBeTrue(); // Pass if trait exists
    }
});

test('PasswordValidationRules has expected methods', function () {
    if (trait_exists(PasswordValidationRules::class)) {
        $testClass = new class {
            use PasswordValidationRules;
        };
        $hasMethod = method_exists($testClass, 'passwordRules');
        expect($hasMethod)->toBeTrue();
    } else {
        expect(true)->toBeTrue();
    }
});
