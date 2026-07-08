<?php

declare(strict_types=1);

use Modules\User\Traits\PasswordValidationRules;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

test('PasswordValidationRules trait can be used', function (): void {
    Assert::assertTrue(trait_exists(PasswordValidationRules::class));
    $reflection = new ReflectionClass(PasswordValidationRules::class);

    Assert::assertTrue($reflection->hasMethod('passwordRules'));
});

test('PasswordValidationRules has expected methods', function (): void {
    $reflection = new ReflectionClass(PasswordValidationRules::class);

    Assert::assertTrue($reflection->getMethod('passwordRules')->isProtected());
});
