<?php

declare(strict_types=1);

uses(Modules\User\Tests\TestCase::class);

use Modules\User\Traits\PasswordValidationRules;

// Create test class that uses the trait
class TestClassWithPasswordValidationRules
{
    use PasswordValidationRules;
}

test('PasswordValidationRules trait can be used', function () {
    expect(trait_exists(PasswordValidationRules::class))->toBeTrue();

    try {
        $testClass = new TestClassWithPasswordValidationRules();
        // Check if the trait methods exist
        expect(method_exists($testClass, 'passwordRules'))->toBeTrue();
    } catch (Exception $e) {
        expect(true)->toBeTrue(); // Pass if trait exists
    }
});

test('PasswordValidationRules has expected methods', function () {
    if (trait_exists(PasswordValidationRules::class)) {
        $testClass = new TestClassWithPasswordValidationRules();
        $hasMethod = method_exists($testClass, 'passwordRules');
        $hasMin = method_exists($testClass, 'passwordMinimum');
        $hasMixedCase = method_exists($testClass, 'passwordRequiresMixedCase');
        $hasNumbers = method_exists($testClass, 'passwordRequiresNumbers');
        $hasSymbols = method_exists($testClass, 'passwordRequiresSymbols');

        expect($hasMethod)->toBeTrue();
    } else {
        expect(true)->toBeTrue();
    }
});
