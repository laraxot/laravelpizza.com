<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Modules\User\Actions\Auth\ConsumeAuthSubmissionSlotAction;
use Modules\User\Enums\AuthThrottleScope;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * Contratto: docs/contracts/consume-auth-submission-slot-action.md. Solo cache (store `array`), nessun database.
 */
beforeEach(function (): void {
    config(['cache.default' => 'array']);
    Cache::flush();
});

it('counts every submission and blocks the email after its limit', function (): void {
    $action = app(ConsumeAuthSubmissionSlotAction::class);
    $max = AuthThrottleScope::ForgotPassword->maxPerEmail();

    for ($i = 1; $i <= $max; $i++) {
        // IP diversi: il freno per email deve scattare anche quando l'IP cambia
        Assert::assertSame(0, $action->execute(AuthThrottleScope::ForgotPassword, 'mario@example.org', '10.0.0.'.$i));
    }

    Assert::assertGreaterThan(0, $action->execute(AuthThrottleScope::ForgotPassword, 'mario@example.org', '10.0.1.1'));
})->group('USER-AUTH-THROTTLE-INV-1', 'USER-AUTH-THROTTLE-INV-2');

it('blocks an IP after MAX_PER_IP submissions with different emails', function (): void {
    $action = app(ConsumeAuthSubmissionSlotAction::class);

    for ($i = 1; $i <= AuthThrottleScope::MAX_PER_IP; $i++) {
        Assert::assertSame(0, $action->execute(AuthThrottleScope::Register, 'user'.$i.'@example.org', '192.0.2.7'));
    }

    Assert::assertGreaterThan(0, $action->execute(AuthThrottleScope::Register, 'altro@example.org', '192.0.2.7'));
})->group('USER-AUTH-THROTTLE-INV-2');

it('treats the email case- and space-insensitively and keeps scopes apart', function (): void {
    $action = app(ConsumeAuthSubmissionSlotAction::class);
    $max = AuthThrottleScope::ForgotPassword->maxPerEmail();

    for ($i = 1; $i <= $max; $i++) {
        $action->execute(AuthThrottleScope::ForgotPassword, ' Mario@Example.org ', '10.1.0.'.$i);
    }

    Assert::assertGreaterThan(0, $action->execute(AuthThrottleScope::ForgotPassword, 'mario@example.org', '10.1.1.1'));
    Assert::assertSame(0, $action->execute(AuthThrottleScope::Register, 'mario@example.org', '10.1.1.1'));
})->group('USER-AUTH-THROTTLE-INV-3');

it('never puts the plain IP or email in the rate limiter key', function (): void {
    app(ConsumeAuthSubmissionSlotAction::class)->execute(AuthThrottleScope::Register, 'mario@example.org', '192.0.2.9');

    Assert::assertSame(1, RateLimiter::attempts('auth-submit:register:email:'.hash('sha256', 'mario@example.org')));
    Assert::assertSame(1, RateLimiter::attempts('auth-submit:register:ip:'.hash('sha256', '192.0.2.9')));
    Assert::assertSame(0, RateLimiter::attempts('auth-submit:register:email:mario@example.org'));
})->group('USER-AUTH-THROTTLE-INV-4');
