<?php

declare(strict_types=1);

use Modules\User\Models\User;
use Modules\User\Actions\Socialite\IsUserAllowedAction;
use Modules\User\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(TestCase::class, DatabaseTransactions::class);

describe('IsUserAllowedAction', function (): void {
    test('allows user with whitelisted email domain', function (): void {
        $user = User::factory()->create(['email' => 'user@allowed-company.com']);
        
        config(['user.allowed_domains' => ['allowed-company.com']]);

        $result = app(IsUserAllowedAction::class)->execute($user);

        expect($result)->toBeTrue();
    });

    test('denies user with non-whitelisted email domain', function (): void {
        $user = User::factory()->create(['email' => 'user@unknown-domain.com']);
        
        config(['user.allowed_domains' => ['allowed-company.com']]);

        $result = app(IsUserAllowedAction::class)->execute($user);

        expect($result)->toBeFalse();
    });

    test('allows user when whitelist is empty', function (): void {
        $user = User::factory()->create(['email' => 'user@any-domain.com']);
        
        config(['user.allowed_domains' => []]);

        $result = app(IsUserAllowedAction::class)->execute($user);

        expect($result)->toBeTrue();
    });
});
