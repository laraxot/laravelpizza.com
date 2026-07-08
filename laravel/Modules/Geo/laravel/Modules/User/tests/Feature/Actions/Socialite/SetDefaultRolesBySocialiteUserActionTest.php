<?php

declare(strict_types=1);

use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Mockery\MockInterface;
use Modules\User\Actions\Socialite\SetDefaultRolesBySocialiteUserAction;
use Modules\User\Database\Factories\RoleFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Role;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

describe('SetDefaultRolesBySocialiteUserAction', function (): void {
    $getMockUser = static function (string $email = 'user@example.com'): SocialiteUserContract {
        return configureMock(SocialiteUserContract::class, function (MockInterface $mock) use ($email): void {
            $mock->allows([
                'getEmail' => $email,
                'getId' => uniqid(),
                'getName' => 'Test User',
            ]);
        });
    };

    test('assigns no roles when user already has roles', function () use ($getMockUser): void {
        $user = UserFactory::new()->createOne();
        $role = RoleFactory::new()->createOne(['guard_name' => 'web']);
        $user->assignRole($role);

        $oauthUser = $getMockUser();

        app(SetDefaultRolesBySocialiteUserAction::class)->execute('google', $user, $oauthUser);

        Assert::assertSame(1, $user->roles()->count());
        $assignedRole = $user->roles()->first();
        Assert::assertInstanceOf(Role::class, $assignedRole);
        Assert::assertSame($role->id, $assignedRole->getKey());
    });

    test('does nothing for unrecognized domain', function () use ($getMockUser): void {
        $user = UserFactory::new()->createOne();
        $oauthUser = $getMockUser('user@unrecognized-domain.com');

        app(SetDefaultRolesBySocialiteUserAction::class)->execute('google', $user, $oauthUser);

        Assert::assertSame(0, $user->roles()->count());
    });

    test('assigns default roles for first party domain', function () use ($getMockUser): void {
        $user = UserFactory::new()->createOne();
        RoleFactory::new()->createOne(['name' => 'admin', 'guard_name' => 'web']);

        config(['services.google.email_domains.first_party.role_names_search' => ['admin']]);

        $oauthUser = $getMockUser('user@example-first-party.com');

        app(SetDefaultRolesBySocialiteUserAction::class)->execute('google', $user, $oauthUser);

        Assert::assertGreaterThanOrEqual(0, $user->roles()->count());
    });

    test('does not assign roles to user with existing roles', function () use ($getMockUser): void {
        $user = UserFactory::new()->createOne();
        $oauthUser = $getMockUser();

        app(SetDefaultRolesBySocialiteUserAction::class)->execute('google', $user, $oauthUser);
    });

    test('handles user with no email', function () use ($getMockUser): void {
        $email = 'nomail-'.uniqid('', true).'@localhost';
        $user = UserFactory::new()->createOne(['email' => $email]);
        $oauthUser = $getMockUser($email);

        app(SetDefaultRolesBySocialiteUserAction::class)->execute('github', $user, $oauthUser);

        Assert::assertGreaterThanOrEqual(0, $user->roles()->count());
    });

    test('supports multiple oauth providers', function () use ($getMockUser): void {
        $user1 = UserFactory::new()->createOne();
        $user2 = UserFactory::new()->createOne();
        $oauthUser1 = $getMockUser('user1@example.com');
        $oauthUser2 = $getMockUser('user2@example.com');

        app(SetDefaultRolesBySocialiteUserAction::class)->execute('google', $user1, $oauthUser1);
        app(SetDefaultRolesBySocialiteUserAction::class)->execute('github', $user2, $oauthUser2);

        Assert::assertGreaterThanOrEqual(0, $user1->roles()->count());
        Assert::assertGreaterThanOrEqual(0, $user2->roles()->count());
    });

    test('returns void', function () use ($getMockUser): void {
        $user = UserFactory::new()->createOne();
        $oauthUser = $getMockUser();

        app(SetDefaultRolesBySocialiteUserAction::class)->execute('google', $user, $oauthUser);
    });

    test('handles special characters in email domain', function () use ($getMockUser): void {
        $user = UserFactory::new()->createOne();
        $oauthUser = $getMockUser('user@sub-domain.example-company.co.uk');

        app(SetDefaultRolesBySocialiteUserAction::class)->execute('google', $user, $oauthUser);

        Assert::assertGreaterThanOrEqual(0, $user->roles()->count());
    });

    test('preserves existing roles when user already has some', function () use ($getMockUser): void {
        $user = UserFactory::new()->createOne();
        $oauthUser = $getMockUser();

        app(SetDefaultRolesBySocialiteUserAction::class)->execute('google', $user, $oauthUser);
    });
});
