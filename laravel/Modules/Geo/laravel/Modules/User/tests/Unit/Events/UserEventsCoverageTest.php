<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Laravel\Socialite\Two\InvalidStateException;
use Modules\User\Contracts\TeamContract;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Events\AddingTeam;
use Modules\User\Events\AddingTeamMember;
use Modules\User\Events\InvalidState;
use Modules\User\Events\InvitingTeamMember;
use Modules\User\Events\Login;
use Modules\User\Events\NewPasswordSet;
use Modules\User\Events\RecoveryCodeReplaced;
use Modules\User\Events\RecoveryCodesGenerated;
use Modules\User\Events\Registered;
use Modules\User\Events\RegistrationNotEnabled;
use Modules\User\Events\RemovingTeamMember;
use Modules\User\Events\SocialiteUserConnected;
use Modules\User\Events\TeamCreated;
use Modules\User\Events\TeamDeleted;
use Modules\User\Events\TeamMemberAdded;
use Modules\User\Events\TeamMemberRemoved;
use Modules\User\Events\TeamMemberUpdated;
use Modules\User\Events\TeamSwitched;
use Modules\User\Events\TeamUpdated;
use Modules\User\Events\TwoFactorAuthenticationChallenged;
use Modules\User\Events\TwoFactorAuthenticationConfirmed;
use Modules\User\Events\TwoFactorAuthenticationDisabled;
use Modules\User\Events\TwoFactorAuthenticationEnabled;
use Modules\User\Events\UserNotAllowed;
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

        Assert::assertInstanceOf(AddingTeam::class, new AddingTeam($user));
        Assert::assertInstanceOf(AddingTeamMember::class, new AddingTeamMember($team, $user));
        Assert::assertInstanceOf(InvitingTeamMember::class, new InvitingTeamMember($team, 'member@example.com', 'editor'));
        Assert::assertInstanceOf(RemovingTeamMember::class, new RemovingTeamMember($team, $user));
        Assert::assertInstanceOf(TeamMemberAdded::class, new TeamMemberAdded($team, $user));
        Assert::assertInstanceOf(TeamMemberRemoved::class, new TeamMemberRemoved($team, $user));
        Assert::assertInstanceOf(TeamMemberUpdated::class, new TeamMemberUpdated($team, $user));
        Assert::assertInstanceOf(TeamSwitched::class, new TeamSwitched($team, $user));
        Assert::assertInstanceOf(TeamCreated::class, new TeamCreated($team));
        Assert::assertInstanceOf(TeamUpdated::class, new TeamUpdated($team));
        Assert::assertInstanceOf(TeamDeleted::class, new TeamDeleted($team));
    });

    test('instantiates socialite and auth events', function (): void {
        $socialiteUser = new SocialiteUser([
            'provider' => 'github',
            'provider_id' => 'provider-'.uniqid(),
            'email' => 'oauth-'.uniqid().'@example.com',
        ]);
        $oauthUser = typedMock(SocialiteUserContract::class);

        Assert::assertInstanceOf(Login::class, new Login($socialiteUser));
        Assert::assertInstanceOf(Registered::class, new Registered($socialiteUser));
        Assert::assertInstanceOf(SocialiteUserConnected::class, new SocialiteUserConnected($socialiteUser));
        Assert::assertInstanceOf(RegistrationNotEnabled::class, new RegistrationNotEnabled('github', $oauthUser));
        Assert::assertInstanceOf(UserNotAllowed::class, new UserNotAllowed($oauthUser));
    });

    test('instantiates recovery and invalid state events', function (): void {
        /** @var Authenticatable $auth */
        $auth = UserFactory::new()->makeOne();
        $exception = new InvalidStateException('state invalid');

        Assert::assertInstanceOf(RecoveryCodeReplaced::class, new RecoveryCodeReplaced($auth, '123456'));
        Assert::assertInstanceOf(InvalidState::class, new InvalidState($exception));
    });

    test('instantiates two factor events', function (): void {
        $user = UserFactory::new()->makeOne();

        Assert::assertInstanceOf(TwoFactorAuthenticationEnabled::class, new TwoFactorAuthenticationEnabled($user));
        Assert::assertInstanceOf(TwoFactorAuthenticationDisabled::class, new TwoFactorAuthenticationDisabled($user));
        Assert::assertInstanceOf(TwoFactorAuthenticationConfirmed::class, new TwoFactorAuthenticationConfirmed($user));
        Assert::assertInstanceOf(TwoFactorAuthenticationChallenged::class, new TwoFactorAuthenticationChallenged($user));
    });

    test('exposes broadcast channel for new password set event', function (): void {
        $user = UserFactory::new()->makeOne();
        $event = new NewPasswordSet($user);

        $channels = $event->broadcastOn();

        Assert::assertCount(1, $channels);
        Assert::assertInstanceOf(PrivateChannel::class, $channels[0]);
    });

    test('instantiates recovery generated and user registered events', function (): void {
        $userContract = UserFactory::new()->makeOne();
        $user = new User();

        $generated = new RecoveryCodesGenerated($userContract);
        $registered = new UserRegistered($user, ['source' => 'test'], '127.0.0.1', 'Pest');

        Assert::assertInstanceOf(RecoveryCodesGenerated::class, $generated);
        Assert::assertInstanceOf(UserRegistered::class, $registered);
        Assert::assertSame(['source' => 'test'], $registered->formData);
        Assert::assertSame('127.0.0.1', $registered->ipAddress);
    });
});
