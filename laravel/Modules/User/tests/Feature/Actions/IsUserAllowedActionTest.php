<?php

declare(strict_types=1);

use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Modules\User\Actions\Socialite\IsUserAllowedAction;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

function fakeSocialiteUser(string $email): SocialiteUserContract
{
    $user = Mockery::mock(SocialiteUserContract::class);
    $user->shouldReceive('getEmail')->andReturn($email);

    return $user;
}

describe('IsUserAllowedAction', function (): void {
    test('allows user with whitelisted email domain', function (): void {
        $user = fakeSocialiteUser('user@allowed-company.com');
        config(['filament-socialite.domain_allowlist' => ['allowed-company.com']]);

        $result = app(IsUserAllowedAction::class)->execute($user);

        expect($result)->toBeTrue();
    });

    test('denies user with non-whitelisted email domain', function (): void {
        $user = fakeSocialiteUser('user@unknown-domain.com');
        config(['filament-socialite.domain_allowlist' => ['allowed-company.com']]);

        $result = app(IsUserAllowedAction::class)->execute($user);

        expect($result)->toBeFalse();
    });

    test('allows user when whitelist is empty', function (): void {
        $user = fakeSocialiteUser('user@any-domain.com');
        config(['filament-socialite.domain_allowlist' => []]);

        $result = app(IsUserAllowedAction::class)->execute($user);

        expect($result)->toBeTrue();
    });
});
