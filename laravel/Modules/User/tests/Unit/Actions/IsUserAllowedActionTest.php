<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Actions;

use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Modules\User\Actions\Socialite\IsUserAllowedAction;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('IsUserAllowedAction', function (): void {
    $getMockUser = function (string $email = 'user@example.com'): SocialiteUserContract {
        $mock = \Mockery::mock(SocialiteUserContract::class);
        $mock->shouldReceive('getEmail')->andReturn($email);
        $mock->shouldReceive('getId')->andReturn(uniqid());
        $mock->shouldReceive('getName')->andReturn('Test User');

        return $mock;
    };

    beforeEach(function () {
        // Clear cached action instances before each test to ensure fresh config reading
        app()->forgetInstance(IsUserAllowedAction::class);
        app()->forgetInstance('Modules\User\Actions\Socialite\GetDomainAllowListAction');
    });

    it('allows any user when no restrictions exist', function () use ($getMockUser) {
        // Clear allowlist
        config(['filament-socialite.domain_allowlist' => []]);

        $user = $getMockUser('any@example.com');
        $action = app(IsUserAllowedAction::class);

        expect($action->execute($user))->toBeTrue();
    });

    it('denies user when domain is not in allowed list', function () use ($getMockUser) {
        config(['filament-socialite.domain_allowlist' => ['allowed-company.com']]);

        $user = $getMockUser('denied@other-company.com');
        $action = app(IsUserAllowedAction::class);

        expect($action->execute($user))->toBeFalse();
    });

    it('allows user when domain is in allowed list', function () use ($getMockUser) {
        config(['filament-socialite.domain_allowlist' => ['allowed-company.com']]);

        $user = $getMockUser('user@allowed-company.com');
        $action = app(IsUserAllowedAction::class);

        expect($action->execute($user))->toBeTrue();
    });
});
