<?php

declare(strict_types=1);

uses(Modules\User\Tests\TestCase::class);

use Modules\User\Events\AddingTeam;
use Modules\User\Events\AddingTeamMember;
use Modules\User\Events\RecoveryCodeReplaced;
use Modules\User\Events\RecoveryCodesGenerated;
use Modules\User\Events\TeamMemberAdded;
use Modules\User\Events\TeamMemberRemoved;
use Modules\User\Events\TeamMemberUpdated;
use Modules\User\Events\TeamSwitched;
use Modules\User\Events\TwoFactorAuthenticationDisabled;
use Modules\User\Events\TwoFactorAuthenticationEnabled;
use Modules\User\Models\User;

// Using mock for contracts since they are interfaces
test('RecoveryCodesGenerated event can be instantiated', function () {
    $user = User::factory()->make();
    $event = new RecoveryCodesGenerated($user);

    expect($event)->toBeInstanceOf(RecoveryCodesGenerated::class)
        ->and($event->userContract)->toBe($user);
});

test('TeamMemberAdded event can be instantiated', function () {
    $team = $this->getMockBuilder(Modules\User\Contracts\TeamContract::class)
                 ->getMock();
    $user = User::factory()->make();
    $event = new TeamMemberAdded($team, $user);

    expect($event)->toBeInstanceOf(TeamMemberAdded::class);
});

test('TeamMemberRemoved event can be instantiated', function () {
    $team = $this->getMockBuilder(Modules\User\Contracts\TeamContract::class)
                 ->getMock();
    $user = User::factory()->make();
    $event = new TeamMemberRemoved($team, $user);

    expect($event)->toBeInstanceOf(TeamMemberRemoved::class);
});

test('TwoFactorAuthenticationEnabled event can be instantiated', function () {
    $user = User::factory()->make();
    $event = new TwoFactorAuthenticationEnabled($user);

    expect($event)->toBeInstanceOf(TwoFactorAuthenticationEnabled::class)
        ->and($event->userContract)->toBe($user);
});

test('TwoFactorAuthenticationDisabled event can be instantiated', function () {
    $user = User::factory()->make();
    $event = new TwoFactorAuthenticationDisabled($user);

    expect($event)->toBeInstanceOf(TwoFactorAuthenticationDisabled::class)
        ->and($event->userContract)->toBe($user);
});

test('RecoveryCodeReplaced event can be instantiated', function () {
    $user = User::factory()->make();
    $event = new RecoveryCodeReplaced($user, 'test_code');

    expect($event)->toBeInstanceOf(RecoveryCodeReplaced::class)
        ->and($event->user)->toBe($user)
        ->and($event->code)->toBe('test_code');
});

test('TeamMemberUpdated event can be instantiated', function () {
    $team = $this->getMockBuilder(Modules\User\Contracts\TeamContract::class)
                 ->getMock();
    $user = User::factory()->make();
    $event = new TeamMemberUpdated($team, $user);

    expect($event)->toBeInstanceOf(TeamMemberUpdated::class);
});

test('AddingTeam event can be instantiated', function () {
    $user = User::factory()->make();
    $event = new AddingTeam($user);

    expect($event)->toBeInstanceOf(AddingTeam::class)
        ->and($event->owner)->toBe($user);
});

test('AddingTeamMember event can be instantiated', function () {
    $team = $this->getMockBuilder(Modules\User\Contracts\TeamContract::class)
                 ->getMock();
    $user = User::factory()->make();
    $event = new AddingTeamMember($team, $user);

    expect($event)->toBeInstanceOf(AddingTeamMember::class);
});

test('TeamSwitched event can be instantiated', function () {
    $team = $this->getMockBuilder(Modules\User\Contracts\TeamContract::class)
                 ->getMock();
    $user = User::factory()->make();
    $event = new TeamSwitched($team, $user);

    expect($event)->toBeInstanceOf(TeamSwitched::class);
});
