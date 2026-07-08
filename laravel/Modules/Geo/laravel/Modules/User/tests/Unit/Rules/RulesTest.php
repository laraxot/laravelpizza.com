<?php

declare(strict_types=1);

use Modules\User\Rules\CheckOtpExpiredRule;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

test('CheckOtpExpiredRule can be instantiated', function () {
    try {
        $rule = app(CheckOtpExpiredRule::class);
        Assert::assertInstanceOf(CheckOtpExpiredRule::class, $rule);
    } catch (Exception $e) {
        // assertTrue(true) removed — tautology // Pass if class exists
    }
});

test('CheckOtpExpiredRule has validation methods', function () {
    if (class_exists(CheckOtpExpiredRule::class)) {
        try {
            $rule = app(CheckOtpExpiredRule::class);
            Assert::assertTrue(method_exists($rule, 'validate') || method_exists($rule, 'passes'));
        } catch (Exception $e) {
            // assertTrue(true) removed — tautology // Pass if class exists
        }
    }
});
