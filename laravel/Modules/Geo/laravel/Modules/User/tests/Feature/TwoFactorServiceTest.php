<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Illuminate\Support\Carbon;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;
use PragmaRX\Google2FA\Google2FA;

use function Safe\json_decode;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var \Modules\User\Tests\TestCase $this */
    /* @var TestCase $this */
    $this->skipUnlessUserColumn('users', 'two_factor_secret');
    $this->skipUnlessUserColumn('users', 'two_factor_recovery_codes');
    $this->skipUnlessUserColumn('users', 'two_factor_confirmed_at');

    $this->user = $this->createTestUser();
    $this->google2fa = new Google2FA();
});

describe('Two Factor Service', function (): void {
    test('enable generates secret and qr code', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $result = enableTwoFactorForUser($user, $google2fa);

        Assert::assertIsString($result['secret']);
        Assert::assertIsString($result['qr_code']);
        Assert::assertCount(10, $result['recovery_codes']);
    });

    test('enable stores encrypted secret', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        enableTwoFactorForUser($user, $google2fa);

        $fresh = $user->fresh();
        Assert::assertNotNull($fresh);
        Assert::assertNotNull($fresh->two_factor_secret);
        $fresh = $user->fresh();
        Assert::assertNotNull($fresh);
        Assert::assertNull($fresh->two_factor_confirmed_at);
    });

    test('enable generates10recovery codes', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $result = enableTwoFactorForUser($user, $google2fa);

        Assert::assertCount(10, $result['recovery_codes']);
        foreach ($result['recovery_codes'] as $code) {
            Assert::assertMatchesRegularExpression('/^[a-zA-Z0-9]+-[a-zA-Z0-9]+$/', (string) $code);
        }
    });

    test('confirm enables2fa with valid code', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $result = enableTwoFactorForUser($user, $google2fa);
        $validCode = $google2fa->getCurrentOtp($result['secret']);

        $confirmed = confirmTwoFactorForUser($user, $google2fa, $result['secret'], $validCode);

        Assert::assertTrue($confirmed);
        $fresh = $user->fresh();
        Assert::assertNotNull($fresh);
        Assert::assertNotNull($fresh->two_factor_confirmed_at);
    });

    test('confirm fails with invalid code', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $result = enableTwoFactorForUser($user, $google2fa);

        $confirmed = confirmTwoFactorForUser($user, $google2fa, $result['secret'], '000000');

        Assert::assertFalse($confirmed);
        $fresh = $user->fresh();
        Assert::assertNotNull($fresh);
        Assert::assertNull($fresh->two_factor_confirmed_at);
    });

    test('disable removes all2fa data', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $result = enableTwoFactorForUser($user, $google2fa);
        confirmTwoFactorForUser(
            $user,
            $google2fa,
            $result['secret'],
            $google2fa->getCurrentOtp($result['secret'])
        );

        disableTwoFactorForUser($user);

        $fresh = $user->fresh();
        Assert::assertNotNull($fresh);
        Assert::assertNull($fresh->two_factor_secret);
        Assert::assertNull($fresh->two_factor_recovery_codes);
        Assert::assertNull($fresh->two_factor_confirmed_at);
    });

    test('verify validates correct code', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $result = enableTwoFactorForUser($user, $google2fa);
        $validCode = $google2fa->getCurrentOtp($result['secret']);

        $verified = verifyTwoFactorCode($user, $google2fa, $validCode);

        Assert::assertTrue($verified);
    });

    test('verify rejects incorrect code', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        enableTwoFactorForUser($user, $google2fa);

        $verified = verifyTwoFactorCode($user, $google2fa, '000000');

        Assert::assertFalse($verified);
    });

    test('verify returns false if no secret', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $verified = verifyTwoFactorCode($user, $google2fa, '123456');

        Assert::assertFalse($verified);
    });

    test('verify recovery code works once', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $result = enableTwoFactorForUser($user, $google2fa);
        $recoveryCode = $result['recovery_codes'][0];

        $verified = verifyTwoFactorRecoveryCode($user, $recoveryCode);

        Assert::assertTrue($verified);
        $freshUser = $user->fresh();
        Assert::assertNotNull($freshUser);
        Assert::assertCount(9, readStoredRecoveryCodes($freshUser));
    });

    test('verify recovery code fails if already used', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $result = enableTwoFactorForUser($user, $google2fa);
        $recoveryCode = $result['recovery_codes'][0];

        verifyTwoFactorRecoveryCode($user, $recoveryCode);

        $verified = verifyTwoFactorRecoveryCode($user, $recoveryCode);

        Assert::assertFalse($verified);
    });

    test('verify recovery code fails with invalid code', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        enableTwoFactorForUser($user, $google2fa);

        $verified = verifyTwoFactorRecoveryCode($user, 'invalid-code');

        Assert::assertFalse($verified);
    });

    test('regenerate recovery codes creates new set', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $result = enableTwoFactorForUser($user, $google2fa);
        $oldCodes = $result['recovery_codes'];

        $newCodes = regenerateTwoFactorRecoveryCodes($user);

        Assert::assertCount(10, $newCodes);
        Assert::assertNotSame($oldCodes, $newCodes);
    });

    test('regenerate recovery codes invalidates old ones', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $result = enableTwoFactorForUser($user, $google2fa);
        $oldCode = $result['recovery_codes'][0];

        regenerateTwoFactorRecoveryCodes($user);

        $verified = verifyTwoFactorRecoveryCode($user, $oldCode);

        Assert::assertFalse($verified);
    });

    test('qr code contains user email', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $result = enableTwoFactorForUser($user, $google2fa);

        Assert::assertStringContainsString((string) rawurlencode($user->email), (string) $result['qr_code']);
    });

    test('qr code is valid otpauth url', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $result = enableTwoFactorForUser($user, $google2fa);

        Assert::assertStringStartsWith('otpauth://totp/', (string) $result['qr_code']);
        Assert::assertStringContainsString((string) 'secret=', (string) $result['qr_code']);
    });

    test('secret is properly encrypted in database', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $result = enableTwoFactorForUser($user, $google2fa);

        $freshUser = $user->fresh();
        Assert::assertNotNull($freshUser);
        $encrypted = $freshUser->two_factor_secret;

        Assert::assertNotNull($encrypted);
        Assert::assertIsString($encrypted);
        Assert::assertNotSame($result['secret'], $encrypted);
        Assert::assertSame($result['secret'], decrypt($encrypted));
    });

    test('recovery codes are properly encrypted in database', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $result = enableTwoFactorForUser($user, $google2fa);

        $freshUser = $user->fresh();
        Assert::assertNotNull($freshUser);
        $encrypted = $freshUser->two_factor_recovery_codes;

        Assert::assertNotNull($encrypted);
        Assert::assertSame($result['recovery_codes'], json_decode((string) decrypt($encrypted), true));
    });

    test('enable can be called multiple times', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $result1 = enableTwoFactorForUser($user, $google2fa);
        $result2 = enableTwoFactorForUser($user, $google2fa);

        Assert::assertNotSame($result2['secret'], $result1['secret']);
    });

    test('confirm sets confirmed at timestamp', function (): void {
        /** @var TestCase $this */
        $google2fa = $this->requireGoogle2fa();
        $user = $this->requireUser();
        $result = enableTwoFactorForUser($user, $google2fa);
        $validCode = $google2fa->getCurrentOtp($result['secret']);

        confirmTwoFactorForUser($user, $google2fa, $result['secret'], $validCode);

        $freshUser = $user->fresh();
        Assert::assertNotNull($freshUser);
        $confirmedAt = $freshUser->two_factor_confirmed_at;

        Assert::assertNotNull($confirmedAt);
        Assert::assertInstanceOf(Carbon::class, Carbon::parse((string) $confirmedAt));
    });
});
