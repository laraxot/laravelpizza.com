<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Models\Team;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var \Modules\User\Tests\TestCase $this */
    /* @var TestCase $this */
    $this->skipUnlessUsersTableReady();
});

describe('Has Teams Trait Current Team', function (): void {
    test('has teams current team does not crash when user has no teams', function (): void {
        /** @var TestCase $this */
        $user = hasTeamsCurrentCreateUser();

        Assert::assertNull($user->currentTeam);
        Assert::assertInstanceOf(BelongsTo::class, $user->currentTeam());
    });

    test('has teams current team is side effect free', function (): void {
        $user = hasTeamsCurrentCreateUser(['current_team_id' => null]);

        Assert::assertNull($user->currentTeam);
        Assert::assertNull($user->currentTeam);

        $user->refresh();
        Assert::assertNull($user->current_team_id);
    });

    test('has teams current team can access personal team when available', function (): void {
        $user = hasTeamsCurrentCreateUser();
        $personalTeam = hasTeamsCurrentCreateTeam($user, [
            'name' => 'Personal Team',
            'personal_team' => true,
        ]);

        $user->current_team_id = (int) $personalTeam->id;
        $user->save();
        $user->refresh();

        Assert::assertInstanceOf(Team::class, $user->currentTeam);
        Assert::assertSame($personalTeam->id, $user->currentTeam->id);
    });

    test('has teams current team does not override existing current team id', function (): void {
        $user = hasTeamsCurrentCreateUser();
        $team1 = hasTeamsCurrentCreateTeam($user, ['name' => 'Team 1', 'personal_team' => false]);
        hasTeamsCurrentCreateTeam($user, ['name' => 'Team 2', 'personal_team' => true]);

        $user->current_team_id = (int) $team1->id;
        $user->save();

        Assert::assertInstanceOf(Team::class, $user->currentTeam);

        $user->refresh();
        Assert::assertSame($team1->id, $user->current_team_id);
    });

    test('has teams switch team can change current team', function (): void {
        /** @var TestCase $this */
        $user = hasTeamsCurrentCreateUser();
        $team1 = hasTeamsCurrentCreateTeam($user, ['name' => 'Team 1', 'personal_team' => false]);
        $team2 = hasTeamsCurrentCreateTeam($user, ['name' => 'Team 2', 'personal_team' => true]);

        $this->attachTeamMember($team1, $user);
        $this->attachTeamMember($team2, $user);

        $result = $user->switchTeam($team1);

        Assert::assertTrue($result);
        $user->refresh();
        Assert::assertSame($team1->id, $user->current_team_id);
    });

    test('has teams current team supports repeated access', function (): void {
        $user = hasTeamsCurrentCreateUser();
        $team = hasTeamsCurrentCreateTeam($user, ['name' => 'Test Team', 'personal_team' => true]);

        $user->current_team_id = (int) $team->id;
        $user->save();
        $user->refresh();

        $currentTeam1 = $user->currentTeam;
        $currentTeam2 = $user->currentTeam;

        Assert::assertInstanceOf(Team::class, $currentTeam1);
        Assert::assertInstanceOf(Team::class, $currentTeam2);
        Assert::assertSame($team->id, $currentTeam1->id);
        Assert::assertSame($team->id, $currentTeam2->id);
    });
});
