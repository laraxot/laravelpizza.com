<?php

declare(strict_types=1);
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Rules\CheckOtpExpiredRule;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('CheckOtpExpiredRule can be instantiated', function () {
    $user = UserFactory::new()->makeOne();
    $rule = new CheckOtpExpiredRule($user);

    Assert::assertSame(CheckOtpExpiredRule::class, $rule::class);
});

test('CheckOtpExpiredRule has validate and message methods', function () {
    $user = UserFactory::new()->makeOne();
    $rule = new CheckOtpExpiredRule($user);

    $reflection = new ReflectionClass($rule);

    Assert::assertTrue($reflection->hasMethod('validate'));
    Assert::assertTrue($reflection->hasMethod('message'));
});
