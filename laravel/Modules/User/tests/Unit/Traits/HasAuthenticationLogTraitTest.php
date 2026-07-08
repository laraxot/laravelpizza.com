<?php

declare(strict_types=1);

use Modules\User\Models\AuthenticationLog;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

/**
 * @param array<string, mixed> $attributes
 */
function makeAuthenticationLogFor(User $user, array $attributes = []): AuthenticationLog
{
    $log = new AuthenticationLog();
    $log->forceFill(array_merge([
        'authenticatable_type' => $user->getMorphClass(),
        'authenticatable_id' => $user->getKey(),
        'ip_address' => '127.0.0.1',
        'login_at' => now(),
        'login_successful' => true,
    ], $attributes));
    $log->save();

    return $log->fresh() ?? $log;
}

it('returns null for lastLoginAt when user has no authentication logs', function (): void {
    $user = Modules\User\Tests\TestCase::createTestUser();

    Assert::assertNull($user->lastLoginAt());
    Assert::assertNull($user->lastLoginIp());
    Assert::assertNull($user->lastSuccessfulLoginAt());
    Assert::assertNull($user->lastSuccessfulLoginIp());
    Assert::assertNull($user->previousLoginAt());
    Assert::assertNull($user->previousLoginIp());
});

it('returns the most recent login timestamp and ip', function (): void {
    $user = Modules\User\Tests\TestCase::createTestUser();

    makeAuthenticationLogFor($user, [
        'ip_address' => '10.0.0.1',
        'login_at' => now()->subDays(2),
        'login_successful' => true,
    ]);
    makeAuthenticationLogFor($user, [
        'ip_address' => '10.0.0.2',
        'login_at' => now()->subDay(),
        'login_successful' => true,
    ]);

    Assert::assertSame('10.0.0.2', $user->fresh()->lastLoginIp());
    Assert::assertNotNull($user->fresh()->lastLoginAt());
});

it('distinguishes successful logins from failed ones', function (): void {
    $user = Modules\User\Tests\TestCase::createTestUser();

    makeAuthenticationLogFor($user, [
        'ip_address' => '10.0.0.3',
        'login_at' => now()->subMinutes(5),
        'login_successful' => false,
    ]);
    makeAuthenticationLogFor($user, [
        'ip_address' => '10.0.0.4',
        'login_at' => now()->subMinutes(1),
        'login_successful' => true,
    ]);

    $fresh = $user->fresh();

    Assert::assertSame('10.0.0.4', $fresh->lastLoginIp());
    Assert::assertSame('10.0.0.4', $fresh->lastSuccessfulLoginIp());
});

it('returns the previous login when at least two logins exist', function (): void {
    $user = Modules\User\Tests\TestCase::createTestUser();

    makeAuthenticationLogFor($user, [
        'ip_address' => '10.0.0.5',
        'login_at' => now()->subDays(3),
    ]);
    makeAuthenticationLogFor($user, [
        'ip_address' => '10.0.0.6',
        'login_at' => now()->subDay(),
    ]);

    $fresh = $user->fresh();

    Assert::assertSame('10.0.0.5', $fresh->previousLoginIp());
    Assert::assertNotNull($fresh->previousLoginAt());
});

it('counts consecutive days of login starting today', function (): void {
    $user = Modules\User\Tests\TestCase::createTestUser();

    makeAuthenticationLogFor($user, ['login_at' => now()]);
    makeAuthenticationLogFor($user, ['login_at' => now()->subDay()]);
    makeAuthenticationLogFor($user, ['login_at' => now()->subDays(2)]);

    Assert::assertSame(3, $user->fresh()->consecutiveDaysLogin());
});

it('returns zero consecutive days when there is no login today', function (): void {
    $user = Modules\User\Tests\TestCase::createTestUser();

    makeAuthenticationLogFor($user, ['login_at' => now()->subDays(5)]);

    Assert::assertSame(0, $user->fresh()->consecutiveDaysLogin());
});
