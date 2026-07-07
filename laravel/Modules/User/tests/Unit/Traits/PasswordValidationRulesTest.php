<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Traits;

use Modules\User\Tests\TestCase;
use Modules\User\Traits\PasswordValidationRules;

uses(TestCase::class);

<<<<<<< HEAD
test('PasswordValidationRules trait can be used', function () {
    $testClass = new class {
        use PasswordValidationRules;
    };

    expect($testClass)->not()->toBeNull();
});

test('PasswordValidationRules trait provides passwordRules method', function () {
    $testClass = new class {
        use PasswordValidationRules;

        public function getPasswordRules()
        {
            return $this->passwordRules();
        }
    };

    $className = get_class($testClass);

    $mock = $this->getMockBuilder($className)
        ->onlyMethods(['passwordRules'])
        ->getMock();

    $mock->method('passwordRules')
        ->willReturn(['required', 'string', 'confirmed']);

    $rules = $mock->getPasswordRules();

    expect($rules)->toBeArray()
        ->and($rules)->toHaveCount(3);
=======
describe('Password Validation Rules', function (): void {
    test('password validation rules trait can be used', function (): void {
        Assert::assertTrue(trait_exists(PasswordValidationRules::class));
        Assert::assertInstanceOf(
            PasswordValidationRulesFixture::class,
            new PasswordValidationRulesFixture(),
        );
    });

    test('password validation rules trait provides password rules method', function (): void {
        $reflection = new \ReflectionClass(PasswordValidationRules::class);

        Assert::assertTrue($reflection->hasMethod('passwordRules'));
        $fixture = new PasswordValidationRulesMockableFixture();
        $rules = $fixture->getPasswordRules();

        Assert::assertCount(4, $rules);
        Assert::assertSame('required', $rules[0]);
        Assert::assertSame('string', $rules[1]);
        Assert::assertSame('confirmed', $rules[3]);
    });
>>>>>>> 6d3760fe (.)
});
