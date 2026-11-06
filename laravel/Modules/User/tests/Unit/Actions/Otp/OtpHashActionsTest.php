<?php

declare(strict_types=1);
use Modules\User\Actions\Otp\HashOtpValueAction;
use Modules\User\Actions\Otp\OtpHashNeedsRehashAction;
use Modules\User\Actions\Otp\VerifyOtpHashAction;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('makes hashed value', function (): void {
    $hash = app(HashOtpValueAction::class)->execute('test-otp-code');

    Assert::assertIsString($hash);
    Assert::assertNotSame('test-otp-code', $hash);
});

it('verifies correct value', function (): void {
    $value = 'test-otp-code';
    $hash = app(HashOtpValueAction::class)->execute($value);

    Assert::assertTrue(app(VerifyOtpHashAction::class)->execute($value, $hash));
});

it('rejects incorrect value', function (): void {
    $hash = app(HashOtpValueAction::class)->execute('correct-code');

    Assert::assertFalse(app(VerifyOtpHashAction::class)->execute('wrong-code', $hash));
});

it('checks if rehash is needed', function (): void {
    $hash = app(HashOtpValueAction::class)->execute('test-code');

    Assert::assertIsBool(app(OtpHashNeedsRehashAction::class)->execute($hash));
});
