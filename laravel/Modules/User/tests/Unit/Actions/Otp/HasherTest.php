<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Actions\Otp;

use Modules\User\Actions\Otp\Hasher;
use Tests\TestCase;

uses(TestCase::class);

it('makes hashed value', function (): void {
    $hasher = app(Hasher::class);
    $hash = $hasher->make('test-otp-code');

    expect($hash)->toBeString();
    expect($hash)->not->toBe('test-otp-code');
});

it('verifies correct value', function (): void {
    $hasher = app(Hasher::class);
    $value = 'test-otp-code';
    $hash = $hasher->make($value);

    $result = $hasher->check($value, $hash);

    expect($result)->toBeTrue();
});

it('rejects incorrect value', function (): void {
    $hasher = app(Hasher::class);
    $hash = $hasher->make('correct-code');

    $result = $hasher->check('wrong-code', $hash);

    expect($result)->toBeFalse();
});

it('checks if rehash is needed', function (): void {
    $hasher = app(Hasher::class);
    $hash = $hasher->make('test-code');

    $result = $hasher->needsRehash($hash);

    expect($result)->toBeBool();
});
