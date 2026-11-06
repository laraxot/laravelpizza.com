<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Traits;

use Modules\User\Models\AuthenticationLog;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

/**
 * @param  array<string, mixed>  $attributes
 */
function makeAuthenticationLogFor(User $user, array $attributes = []): AuthenticationLog
{
    $log = new AuthenticationLog;
    $log->forceFill(array_merge([
        'authenticatable_type' => $user->getMorphClass(),
        'authenticatable_id' => $user->getKey(),
        'ip_address' => '127.0.0.1',
        'login_at' => now(),
        'login_successful' => true,
    ], $attributes));
    $log->save();

    return $log->refresh();
}

it('returns null for lastLoginAt when user has no authentication logs', function (): void {
    $user = TestCase::createTestUser();

    expect($user->lastLoginAt())->toBeNull();
    expect($user->lastLoginIp())->toBeNull();
    expect($user->lastSuccessfulLoginAt())->toBeNull();
    expect($user->lastSuccessfulLoginIp())->toBeNull();
    expect($user->previousLoginAt())->toBeNull();
    expect($user->previousLoginIp())->toBeNull();
});

it('returns the most recent login timestamp and ip', function (): void {
    $user = TestCase::createTestUser();

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

    expect($user->refresh()->lastLoginIp())->toBe('10.0.0.2');
    expect($user->refresh()->lastLoginAt())->not->toBeNull();
});

it('distinguishes successful logins from failed ones', function (): void {
    $user = TestCase::createTestUser();

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

    $fresh = $user->refresh();

    expect($fresh->lastLoginIp())->toBe('10.0.0.4');
    expect($fresh->lastSuccessfulLoginIp())->toBe('10.0.0.4');
});

it('returns the previous login when at least two logins exist', function (): void {
    $user = TestCase::createTestUser();

    makeAuthenticationLogFor($user, [
        'ip_address' => '10.0.0.5',
        'login_at' => now()->subDays(3),
    ]);
    makeAuthenticationLogFor($user, [
        'ip_address' => '10.0.0.6',
        'login_at' => now()->subDay(),
    ]);

    $fresh = $user->refresh();

    expect($fresh->previousLoginIp())->toBe('10.0.0.5');
    expect($fresh->previousLoginAt())->not->toBeNull();
});

it('counts consecutive days of login starting today', function (): void {
    $user = TestCase::createTestUser();

    makeAuthenticationLogFor($user, ['login_at' => now()]);
    makeAuthenticationLogFor($user, ['login_at' => now()->subDay()]);
    makeAuthenticationLogFor($user, ['login_at' => now()->subDays(2)]);

    expect($user->refresh()->consecutiveDaysLogin())->toBe(3);
});

it('returns zero consecutive days when there is no login today', function (): void {
    $user = TestCase::createTestUser();

    makeAuthenticationLogFor($user, ['login_at' => now()->subDays(5)]);

    expect($user->refresh()->consecutiveDaysLogin())->toBe(0);
});
