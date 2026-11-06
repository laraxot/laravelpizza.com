<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Laravel\Socialite\Two\InvalidStateException;
use Modules\User\Contracts\TeamContract;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Events\AddingTeam;
use Modules\User\Events\AddingTeamMember;
use Modules\User\Events\InvalidState;
use Modules\User\Events\Login;
use Modules\User\Events\NewPasswordSet;
use Modules\User\Events\RecoveryCodesGenerated;
use Modules\User\Events\SocialiteUserConnected;
use Modules\User\Events\TwoFactorAuthenticationEnabled;
use Modules\User\Events\UserRegistered;
use Modules\User\Models\SocialiteUser;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('User Events Coverage', function (): void {
    test('instantiates team and membership events', function (): void {
        $team = typedMock(TeamContract::class);
        $user = UserFactory::new()->makeOne();
        $addingTeam = new AddingTeam($user);
        $addingMember = new AddingTeamMember($team, $user);

        Assert::assertSame($user, $addingTeam->owner);
        Assert::assertSame($team, $addingMember->teamContract);
        Assert::assertSame($user, $addingMember->userContract);
    });

    test('instantiates socialite and auth events', function (): void {
        $socialiteUser = new SocialiteUser([
            'provider' => 'github',
            'provider_id' => 'provider-'.uniqid(),
            'email' => 'oauth-'.uniqid().'@example.com',
        ]);
        $connected = new SocialiteUserConnected($socialiteUser);
        $login = new Login($socialiteUser);

        Assert::assertSame($socialiteUser, $connected->socialiteUser);
        Assert::assertSame($socialiteUser, $login->socialiteUser);
    });

    test('instantiates recovery and invalid state events', function (): void {
        $exception = new InvalidStateException('state invalid');
        $invalidState = new InvalidState($exception);

        Assert::assertSame($exception, $invalidState->exception);
    });

    test('instantiates two factor events', function (): void {
        $user = UserFactory::new()->makeOne();
        $enabled = new TwoFactorAuthenticationEnabled($user);

        Assert::assertSame($user, $enabled->userContract);
    });

    test('exposes broadcast channel for new password set event', function (): void {
        $user = UserFactory::new()->makeOne();
        $event = new NewPasswordSet($user);

        $channels = $event->broadcastOn();

        Assert::assertCount(1, $channels);
        Assert::assertSame(PrivateChannel::class, $channels[0]::class);
    });

    test('instantiates recovery generated and user registered events', function (): void {
        $userContract = UserFactory::new()->makeOne();
        $user = new User;

        $recovery = new RecoveryCodesGenerated($userContract);
        $registered = new UserRegistered($user, ['source' => 'test'], '127.0.0.1', 'Pest');

        Assert::assertSame($userContract, $recovery->userContract);

        Assert::assertSame(['source' => 'test'], $registered->formData);
        Assert::assertSame('127.0.0.1', $registered->ipAddress);
    });
});
