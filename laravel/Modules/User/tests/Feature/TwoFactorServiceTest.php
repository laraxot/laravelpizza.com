<?php

declare(strict_types=1);

use Illuminate\Support\Carbon;
use Modules\User\Models\User;
use Modules\User\Services\TwoFactorService;
use Modules\User\Tests\TestCase;
use PragmaRX\Google2FA\Google2FA;

uses(TestCase::class);

beforeEach(function (): void {
    $this->service = new TwoFactorService();
    $this->user = User::factory()->create();
    $this->google2fa = new Google2FA();
});

test('enable generates secret and qr code', function (): void {
    $result = $this->service->enable($this->user);

    expect($result)->toHaveKeys(['secret', 'qr_code', 'recovery_codes']);
    expect($result['secret'])->toBeString();
    expect($result['qr_code'])->toBeString();
    expect($result['recovery_codes'])->toHaveCount(10);
});

test('enable stores encrypted secret', function (): void {
    $this->service->enable($this->user);

    expect($this->user->fresh()->two_factor_secret)->not->toBeNull();
    expect($this->user->fresh()->two_factor_enabled)->toBeFalse();
});

test('enable generates 10 recovery codes', function (): void {
    $result = $this->service->enable($this->user);

    expect($result['recovery_codes'])->toHaveCount(10);

    foreach ($result['recovery_codes'] as $code) {
        expect($code)->toMatch('/^[a-zA-Z0-9]+-[a-zA-Z0-9]+$/');
    }
});

test('confirm enables 2fa with valid code', function (): void {
    $result = $this->service->enable($this->user);
    $validCode = $this->google2fa->getCurrentOtp($result['secret']);

    $confirmed = $this->service->confirm($this->user, $validCode);

    expect($confirmed)->toBeTrue();
    expect($this->user->fresh()->two_factor_enabled)->toBeTrue();
    expect($this->user->fresh()->two_factor_confirmed_at)->not->toBeNull();
});

test('confirm fails with invalid code', function (): void {
    $this->service->enable($this->user);

    $confirmed = $this->service->confirm($this->user, '000000');

    expect($confirmed)->toBeFalse();
    expect($this->user->fresh()->two_factor_enabled)->toBeFalse();
});

test('disable removes all 2fa data', function (): void {
    $this->service->enable($this->user);
    $this->user->update(['two_factor_enabled' => true]);

    $this->service->disable($this->user);

    $fresh = $this->user->fresh();
    expect($fresh->two_factor_secret)->toBeNull();
    expect($fresh->two_factor_recovery_codes)->toBeNull();
    expect($fresh->two_factor_confirmed_at)->toBeNull();
    expect($fresh->two_factor_enabled)->toBeFalse();
});

test('verify validates correct code', function (): void {
    $result = $this->service->enable($this->user);
    $validCode = $this->google2fa->getCurrentOtp($result['secret']);

    $verified = $this->service->verify($this->user, $validCode);

    expect($verified)->toBeTrue();
});

test('verify rejects incorrect code', function (): void {
    $this->service->enable($this->user);

    $verified = $this->service->verify($this->user, '000000');

    expect($verified)->toBeFalse();
});

test('verify returns false if no secret', function (): void {
    $verified = $this->service->verify($this->user, '123456');

    expect($verified)->toBeFalse();
});

test('verify recovery code works once', function (): void {
    $result = $this->service->enable($this->user);
    $recoveryCode = $result['recovery_codes'][0];

    $verified = $this->service->verifyRecoveryCode($this->user, $recoveryCode);

    expect($verified)->toBeTrue();
    expect($this->user->fresh()->getRecoveryCodes())->toHaveCount(9);
});

test('verify recovery code fails if already used', function (): void {
    $result = $this->service->enable($this->user);
    $recoveryCode = $result['recovery_codes'][0];

    // Use it once
    $this->service->verifyRecoveryCode($this->user, $recoveryCode);

    // Try again
    $verified = $this->service->verifyRecoveryCode($this->user, $recoveryCode);

    expect($verified)->toBeFalse();
});

test('verify recovery code fails with invalid code', function (): void {
    $this->service->enable($this->user);

    $verified = $this->service->verifyRecoveryCode($this->user, 'invalid-code');

    expect($verified)->toBeFalse();
});

test('regenerate recovery codes creates new set', function (): void {
    $result = $this->service->enable($this->user);
    $oldCodes = $result['recovery_codes'];

    $newCodes = $this->service->regenerateRecoveryCodes($this->user);

    expect($newCodes)->toHaveCount(10);
    expect($newCodes)->not->toBe($oldCodes);
});

test('regenerate recovery codes invalidates old ones', function (): void {
    $result = $this->service->enable($this->user);
    $oldCode = $result['recovery_codes'][0];

    $this->service->regenerateRecoveryCodes($this->user);

    $verified = $this->service->verifyRecoveryCode($this->user, $oldCode);

    expect($verified)->toBeFalse();
});

test('qr code contains user email', function (): void {
    $result = $this->service->enable($this->user);

    expect($result['qr_code'])->toContain($this->user->email);
});

test('qr code is valid svg', function (): void {
    $result = $this->service->enable($this->user);

    expect($result['qr_code'])->toContain('<svg');
    expect($result['qr_code'])->toContain('</svg>');
});

test('secret is properly encrypted in database', function (): void {
    $result = $this->service->enable($this->user);

    $encrypted = $this->user->fresh()->two_factor_secret;

    expect($encrypted)->not->toBe($result['secret']);
    expect(decrypt($encrypted))->toBe($result['secret']);
});

test('recovery codes are properly encrypted in database', function (): void {
    $result = $this->service->enable($this->user);

    $encrypted = $this->user->fresh()->two_factor_recovery_codes;

    expect($encrypted)->not->toBeNull();
    expect(json_decode(decrypt($encrypted), true))->toBe($result['recovery_codes']);
});

test('enable can be called multiple times', function (): void {
    $result1 = $this->service->enable($this->user);
    $result2 = $this->service->enable($this->user);

    expect($result1['secret'])->not->toBe($result2['secret']);
});

test('confirm sets confirmed_at timestamp', function (): void {
    $result = $this->service->enable($this->user);
    $validCode = $this->google2fa->getCurrentOtp($result['secret']);

    $this->service->confirm($this->user, $validCode);

    expect($this->user->fresh()->two_factor_confirmed_at)->not->toBeNull();
    expect($this->user->fresh()->two_factor_confirmed_at)->toBeInstanceOf(Carbon::class);
});
