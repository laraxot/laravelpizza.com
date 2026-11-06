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

        Assert::assertSame($user, $event->userContract);
    });

    test('team member added event can be instantiated', function (): void {
        $team = typedMock(TeamContract::class);
        $user = UserFactory::new()->makeOne();
        $event = new TeamMemberAdded($team, $user);

        Assert::assertSame($team, $event->teamContract);
        Assert::assertSame($user, $event->userContract);
    });

    test('team member removed event can be instantiated', function (): void {
        $team = typedMock(TeamContract::class);
        $user = UserFactory::new()->makeOne();
        $event = new TeamMemberRemoved($team, $user);

        Assert::assertSame($team, $event->teamContract);
        Assert::assertSame($user, $event->userContract);
    });

    test('two factor authentication enabled event can be instantiated', function (): void {
        $user = UserFactory::new()->makeOne();
        $event = new TwoFactorAuthenticationEnabled($user);

        Assert::assertSame($user, $event->userContract);
    });

    test('two factor authentication disabled event can be instantiated', function (): void {
        $user = UserFactory::new()->makeOne();
        $event = new TwoFactorAuthenticationDisabled($user);

        Assert::assertSame($user, $event->userContract);
    });

    test('recovery code replaced event can be instantiated', function (): void {
        $user = UserFactory::new()->makeOne();
        $event = new RecoveryCodeReplaced($user, 'test_code');

        Assert::assertSame($user, $event->user);
        Assert::assertSame('test_code', $event->code);
    });

    test('team member updated event can be instantiated', function (): void {
        $team = typedMock(TeamContract::class);
        $user = UserFactory::new()->makeOne();
        $event = new TeamMemberUpdated($team, $user);

        Assert::assertSame($team, $event->teamContract);
        Assert::assertSame($user, $event->userContract);
    });

    test('adding team event can be instantiated', function (): void {
        $user = UserFactory::new()->makeOne();
        $event = new AddingTeam($user);

        Assert::assertSame($user, $event->owner);
    });

    test('adding team member event can be instantiated', function (): void {
        $team = typedMock(TeamContract::class);
        $user = UserFactory::new()->makeOne();
        $event = new AddingTeamMember($team, $user);

        Assert::assertSame($team, $event->teamContract);
        Assert::assertSame($user, $event->userContract);
    });

    test('team switched event can be instantiated', function (): void {
        $team = typedMock(TeamContract::class);
        $user = UserFactory::new()->makeOne();
        $event = new TeamSwitched($team, $user);

        Assert::assertSame($team, $event->teamContract);
        Assert::assertSame($user, $event->userContract);
    });
});
