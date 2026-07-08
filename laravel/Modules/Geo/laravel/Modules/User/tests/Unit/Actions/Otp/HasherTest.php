<?php

declare(strict_types=1);

use Modules\User\Actions\Otp\Hasher;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

it('makes hashed value', function (): void {
    $hasher = app(Hasher::class);
    $hash = $hasher->make('test-otp-code');

    Assert::assertIsString($hash);
    Assert::assertNotSame('test-otp-code', $hash);
});

it('verifies correct value', function (): void {
    $hasher = app(Hasher::class);
    $value = 'test-otp-code';
    $hash = $hasher->make($value);

    Assert::assertTrue($hasher->check($value, $hash));
});

it('rejects incorrect value', function (): void {
    $hasher = app(Hasher::class);
    $hash = $hasher->make('correct-code');

    Assert::assertFalse($hasher->check('wrong-code', $hash));
});

it('checks if rehash is needed', function (): void {
    $hasher = app(Hasher::class);
    $hash = $hasher->make('test-code');

    Assert::assertIsBool($hasher->needsRehash($hash));
});
