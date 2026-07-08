<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Events;

use Modules\User\Contracts\TeamContract;
use Modules\User\Database\Factories\UserFactory;
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
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Event Classes', function (): void {
    test('recovery codes generated event can be instantiated', function (): void {
        $user = UserFactory::new()->makeOne();
        $event = new RecoveryCodesGenerated($user);

        Assert::assertInstanceOf(RecoveryCodesGenerated::class, $event);
        Assert::assertSame($user, $event->userContract);
    });

    test('team member added event can be instantiated', function (): void {
        $team = typedMock(TeamContract::class);
        $user = UserFactory::new()->makeOne();
        $event = new TeamMemberAdded($team, $user);

        Assert::assertInstanceOf(TeamMemberAdded::class, $event);
    });

    test('team member removed event can be instantiated', function (): void {
        $team = typedMock(TeamContract::class);
        $user = UserFactory::new()->makeOne();
        $event = new TeamMemberRemoved($team, $user);

        Assert::assertInstanceOf(TeamMemberRemoved::class, $event);
    });

    test('two factor authentication enabled event can be instantiated', function (): void {
        $user = UserFactory::new()->makeOne();
        $event = new TwoFactorAuthenticationEnabled($user);

        Assert::assertInstanceOf(TwoFactorAuthenticationEnabled::class, $event);
        Assert::assertSame($user, $event->userContract);
    });

    test('two factor authentication disabled event can be instantiated', function (): void {
        $user = UserFactory::new()->makeOne();
        $event = new TwoFactorAuthenticationDisabled($user);

        Assert::assertInstanceOf(TwoFactorAuthenticationDisabled::class, $event);
        Assert::assertSame($user, $event->userContract);
    });

    test('recovery code replaced event can be instantiated', function (): void {
        $user = UserFactory::new()->makeOne();
        $event = new RecoveryCodeReplaced($user, 'test_code');

        Assert::assertInstanceOf(RecoveryCodeReplaced::class, $event);
        Assert::assertSame($user, $event->user);
        Assert::assertSame('test_code', $event->code);
    });

    test('team member updated event can be instantiated', function (): void {
        $team = typedMock(TeamContract::class);
        $user = UserFactory::new()->makeOne();
        $event = new TeamMemberUpdated($team, $user);

        Assert::assertInstanceOf(TeamMemberUpdated::class, $event);
    });

    test('adding team event can be instantiated', function (): void {
        $user = UserFactory::new()->makeOne();
        $event = new AddingTeam($user);

        Assert::assertInstanceOf(AddingTeam::class, $event);
        Assert::assertSame($user, $event->owner);
    });

    test('adding team member event can be instantiated', function (): void {
        $team = typedMock(TeamContract::class);
        $user = UserFactory::new()->makeOne();
        $event = new AddingTeamMember($team, $user);

        Assert::assertInstanceOf(AddingTeamMember::class, $event);
    });

    test('team switched event can be instantiated', function (): void {
        $team = typedMock(TeamContract::class);
        $user = UserFactory::new()->makeOne();
        $event = new TeamSwitched($team, $user);

        Assert::assertInstanceOf(TeamSwitched::class, $event);
    });
});
