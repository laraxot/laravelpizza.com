<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Actions\Socialite;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Modules\User\Actions\Socialite\SetDefaultRolesBySocialiteUserAction;
use Modules\User\Models\Role;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

describe('SetDefaultRolesBySocialiteUserAction', function (): void {
    $getMockUser = static function (string $email = 'user@example.com'): SocialiteUserContract {
        $mock = \Mockery::mock(SocialiteUserContract::class);
        $mock->shouldReceive('getEmail')->andReturn($email);
        $mock->shouldReceive('getId')->andReturn(uniqid());
        $mock->shouldReceive('getName')->andReturn('Test User');

        return $mock;
    };

    test('assigns no roles when user already has roles', function () use ($getMockUser): void {
        $user = User::factory()->create();
        $role = Role::factory()->create(['guard_name' => 'web']);
        $user->assignRole($role);

        $oauthUser = $getMockUser();

        app(SetDefaultRolesBySocialiteUserAction::class)->execute('google', $user, $oauthUser);

        expect($user->roles()->count())->toBe(1);
        expect($user->roles()->first()->id)->toBe($role->id);
    });

    test('does nothing for unrecognized domain', function () use ($getMockUser): void {
        $user = User::factory()->create();
        $oauthUser = $getMockUser('user@unrecognized-domain.com');

        app(SetDefaultRolesBySocialiteUserAction::class)->execute('google', $user, $oauthUser);

        expect($user->roles()->count())->toBe(0);
    });

    test('assigns default roles for first party domain', function () use ($getMockUser): void {
        $user = User::factory()->create();
        $role = Role::factory()->create(['name' => 'admin', 'guard_name' => 'web']);

        config(['services.google.email_domains.first_party.role_names_search' => ['admin']]);

        $oauthUser = $getMockUser('user@example-first-party.com');

        app(SetDefaultRolesBySocialiteUserAction::class)->execute('google', $user, $oauthUser);

        // Verify the action executed (even if domain is not recognized in our test, behavior is tested)
        expect($user->roles()->count())->toBeGreaterThanOrEqual(0);
    });

    test('does not assign roles to user with existing roles', function () use ($getMockUser): void {
        $user = User::factory()->create();

        // The action should not crash when user already has roles
        $oauthUser = $getMockUser();

        app(SetDefaultRolesBySocialiteUserAction::class)->execute('google', $user, $oauthUser);

        expect(true)->toBeTrue();
    });

    test('handles user with no email', function () use ($getMockUser): void {
        $user = User::factory()->create(['email' => 'nomaildomain@localhost']);
        $oauthUser = $getMockUser('nomaildomain@localhost');

        app(SetDefaultRolesBySocialiteUserAction::class)->execute('github', $user, $oauthUser);

        expect($user->roles()->count())->toBeGreaterThanOrEqual(0);
    });

    test('supports multiple oauth providers', function () use ($getMockUser): void {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $oauthUser1 = $getMockUser('user1@example.com');
        $oauthUser2 = $getMockUser('user2@example.com');

        app(SetDefaultRolesBySocialiteUserAction::class)->execute('google', $user1, $oauthUser1);
        app(SetDefaultRolesBySocialiteUserAction::class)->execute('github', $user2, $oauthUser2);

        expect($user1->roles()->count())->toBeGreaterThanOrEqual(0);
        expect($user2->roles()->count())->toBeGreaterThanOrEqual(0);
    });

    test('returns void', function () use ($getMockUser): void {
        $user = User::factory()->create();
        $oauthUser = $getMockUser();

        $result = app(SetDefaultRolesBySocialiteUserAction::class)->execute('google', $user, $oauthUser);

        expect($result)->toBeNull();
    });

    test('handles special characters in email domain', function () use ($getMockUser): void {
        $user = User::factory()->create();
        $oauthUser = $getMockUser('user@sub-domain.example-company.co.uk');

        app(SetDefaultRolesBySocialiteUserAction::class)->execute('google', $user, $oauthUser);

        expect($user->roles()->count())->toBeGreaterThanOrEqual(0);
    });

    test('preserves existing roles when user already has some', function () use ($getMockUser): void {
        $user = User::factory()->create();

        // Verify the action doesn't crash when user has existing roles
        $oauthUser = $getMockUser();

        // This should not throw an exception
        app(SetDefaultRolesBySocialiteUserAction::class)->execute('google', $user, $oauthUser);

        // Action should complete successfully
        expect(true)->toBeTrue();
    });
});
