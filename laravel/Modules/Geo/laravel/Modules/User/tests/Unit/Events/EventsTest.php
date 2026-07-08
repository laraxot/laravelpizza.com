<?php

declare(strict_types=1);

use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Mockery\MockInterface;
use Modules\User\Events\Login;
use Modules\User\Events\Registered;
use Modules\User\Events\TeamCreated;
use Modules\User\Events\TeamMemberAdded;
use Modules\User\Events\TwoFactorAuthenticationEnabled;
use Modules\User\Events\UserNotAllowed;
use Modules\User\Models\SocialiteUser;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

test('Login event can be instantiated', function () {
    $socialiteUser = SocialiteUser::query()->first() ?? new SocialiteUser([
        'id' => 1,
        'provider' => 'github',
        'provider_id' => 'provider-1',
    ]);

    $event = new Login($socialiteUser);

    Assert::assertInstanceOf(Login::class, $event);
});

test('Registered event can be instantiated', function () {
    $socialiteUser = SocialiteUser::query()->first() ?? new SocialiteUser([
        'id' => 1,
        'provider' => 'github',
        'provider_id' => 'provider-1',
    ]);

    $event = new Registered($socialiteUser);

    Assert::assertInstanceOf(Registered::class, $event);
});

test('TeamCreated event can be instantiated', function () {
    $team = Team::query()->first() ?? new Team(['id' => 1, 'name' => 'Test Team']);
    $event = new TeamCreated($team);

    Assert::assertInstanceOf(TeamCreated::class, $event);
});

test('TeamMemberAdded event can be instantiated', function () {
    $team = Team::query()->first() ?? new Team(['id' => 1, 'name' => 'Test Team']);
    $user = User::query()->first() ?? new User(['id' => 1, 'email' => 'test@example.com']);

    $event = new TeamMemberAdded($team, $user);

    Assert::assertInstanceOf(TeamMemberAdded::class, $event);
});

test('TwoFactorAuthenticationEnabled event can be instantiated', function () {
    $user = User::query()->first() ?? new User(['id' => 1, 'email' => 'test@example.com']);
    $event = new TwoFactorAuthenticationEnabled($user);

    Assert::assertInstanceOf(TwoFactorAuthenticationEnabled::class, $event);
});

test('UserNotAllowed event can be instantiated', function () {
    $oauthUser = configureMock(SocialiteUserContract::class, function (MockInterface $mock): void {
        $mock->allows(['getEmail' => 'denied@example.com']);
    });

    $event = new UserNotAllowed($oauthUser);

    Assert::assertInstanceOf(UserNotAllowed::class, $event);
});
