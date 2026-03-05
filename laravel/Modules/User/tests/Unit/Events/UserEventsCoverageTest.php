<?php

declare(strict_types=1);

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Laravel\Socialite\Two\InvalidStateException;
use Modules\User\Contracts\TeamContract;
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
use Modules\Xot\Contracts\UserContract;

describe('User events coverage', function (): void {
    it('instantiates team and membership events', function (): void {
        $team = Mockery::mock(TeamContract::class);
        $user = Mockery::mock(UserContract::class);

        expect(new AddingTeam($user))->toBeInstanceOf(AddingTeam::class)
            ->and(new AddingTeamMember($team, $user))->toBeInstanceOf(AddingTeamMember::class)
            ->and(new InvitingTeamMember($team, 'member@example.com', 'editor'))->toBeInstanceOf(InvitingTeamMember::class)
            ->and(new RemovingTeamMember($team, $user))->toBeInstanceOf(RemovingTeamMember::class)
            ->and(new TeamMemberAdded($team, $user))->toBeInstanceOf(TeamMemberAdded::class)
            ->and(new TeamMemberRemoved($team, $user))->toBeInstanceOf(TeamMemberRemoved::class)
            ->and(new TeamMemberUpdated($team, $user))->toBeInstanceOf(TeamMemberUpdated::class)
            ->and(new TeamSwitched($team, $user))->toBeInstanceOf(TeamSwitched::class)
            ->and(new TeamCreated($team))->toBeInstanceOf(TeamCreated::class)
            ->and(new TeamUpdated($team))->toBeInstanceOf(TeamUpdated::class)
            ->and(new TeamDeleted($team))->toBeInstanceOf(TeamDeleted::class);
    });

    it('instantiates socialite and auth events', function (): void {
        $socialiteUser = $this->createMock(SocialiteUser::class);
        $oauthUser = Mockery::mock(SocialiteUserContract::class);

        expect(new Login($socialiteUser))->toBeInstanceOf(Login::class)
            ->and(new Registered($socialiteUser))->toBeInstanceOf(Registered::class)
            ->and(new SocialiteUserConnected($socialiteUser))->toBeInstanceOf(SocialiteUserConnected::class)
            ->and(new RegistrationNotEnabled('github', $oauthUser))->toBeInstanceOf(RegistrationNotEnabled::class)
            ->and(new UserNotAllowed($oauthUser))->toBeInstanceOf(UserNotAllowed::class);
    });

    it('instantiates recovery and invalid-state events', function (): void {
        $auth = Mockery::mock(Authenticatable::class);
        $exception = new InvalidStateException('state invalid');

        expect(new RecoveryCodeReplaced($auth, '123456'))->toBeInstanceOf(RecoveryCodeReplaced::class)
            ->and(new InvalidState($exception))->toBeInstanceOf(InvalidState::class);
    });

    it('instantiates two-factor events', function (): void {
        $user = Mockery::mock(UserContract::class);

        expect(new TwoFactorAuthenticationEnabled($user))->toBeInstanceOf(TwoFactorAuthenticationEnabled::class)
            ->and(new TwoFactorAuthenticationDisabled($user))->toBeInstanceOf(TwoFactorAuthenticationDisabled::class)
            ->and(new TwoFactorAuthenticationConfirmed($user))->toBeInstanceOf(TwoFactorAuthenticationConfirmed::class)
            ->and(new TwoFactorAuthenticationChallenged($user))->toBeInstanceOf(TwoFactorAuthenticationChallenged::class);
    });

    it('exposes broadcast channel for new password set event', function (): void {
        $user = Mockery::mock(UserContract::class);
        $event = new NewPasswordSet($user);

        $channels = $event->broadcastOn();

        expect($channels)->toHaveCount(1)
            ->and($channels[0])->toBeInstanceOf(PrivateChannel::class);
    });

    it('instantiates recovery-generated and user-registered events', function (): void {
        $userContract = Mockery::mock(UserContract::class);
        $user = new User();

        $generated = new RecoveryCodesGenerated($userContract);
        $registered = new UserRegistered($user, ['source' => 'test'], '127.0.0.1', 'Pest');

        expect($generated)->toBeInstanceOf(RecoveryCodesGenerated::class)
            ->and($registered)->toBeInstanceOf(UserRegistered::class)
            ->and($registered->formData)->toBe(['source' => 'test'])
            ->and($registered->ipAddress)->toBe('127.0.0.1');
    });
});
