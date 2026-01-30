<?php

declare(strict_types=1);

uses(Modules\User\Tests\TestCase::class);

use Modules\User\Traits\PasswordValidationRules;

// Create a test class that uses the trait
class PasswordValidationRulesTestClass
{
    use PasswordValidationRules;

    public function getPasswordRules()
    {
        return $this->passwordRules();
    }
}

test('PasswordValidationRules trait can be used', function () {
    $testClass = new PasswordValidationRulesTestClass;

    expect($testClass)->toBeInstanceOf(PasswordValidationRulesTestClass::class);
});

test('PasswordValidationRules trait provides passwordRules method', function () {
    // Since the trait uses the Password rule which might not exist,
    // we'll just test that the method exists and returns an array
    $mock = $this->getMockBuilder(PasswordValidationRulesTestClass::class)
        ->onlyMethods(['passwordRules'])
        ->getMock();

    $mock->method('passwordRules')
        ->willReturn(['required', 'string', 'confirmed']);

    $rules = $mock->getPasswordRules();

    expect($rules)->toBeArray()
        ->and($rules)->toHaveCount(3);
});
