<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Modules\User\Database\Factories\TeamFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use Modules\User\Tests\Unit\Models\Traits\Fixtures\MockUserWithTeams;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

function traitsHasTeamsMockUser(string $id = 'mock-user-1'): MockUserWithTeams
{
    $user = new MockUserWithTeams();
    $user->forceFill(['id' => $id]);

    return $user;
}

test('has teams trait can be used in mock model', function (): void {
    Assert::assertInstanceOf(MockUserWithTeams::class, traitsHasTeamsMockUser());
});

test('has teams trait belongsToTeam when team is in relation', function (): void {
    $user = traitsHasTeamsMockUser();
    $team = new Team();
    $team->forceFill(['id' => 5, 'user_id' => 'other-user', 'name' => 'Team 5']);
    $user->setRelation('teams', collect([$team]));

    Assert::assertTrue($user->belongsToTeam($team));
});

test('has teams trait belongsToTeam when user owns team', function (): void {
    $user = traitsHasTeamsMockUser('owner-user');
    $team = new Team();
    $team->forceFill(['id' => 15, 'user_id' => 'owner-user', 'name' => 'Owned']);

    Assert::assertTrue($user->belongsToTeam($team));
});

test('has teams trait belongsToTeam returns false for unknown team', function (): void {
    $user = traitsHasTeamsMockUser();
    $team = new Team();
    $team->forceFill(['id' => 999, 'user_id' => 'other-user', 'name' => 'Missing']);
    $user->setRelation('teams', collect([]));

    Assert::assertFalse($user->belongsToTeam($team));
});

test('has teams trait belongsToTeam returns false for null team', function (): void {
    Assert::assertFalse(traitsHasTeamsMockUser()->belongsToTeam(null));
});

test('has teams trait ownsTeam matches user id', function (): void {
    $user = traitsHasTeamsMockUser('owner-1');
    $team = new Team();
    $team->forceFill(['id' => 1, 'user_id' => 'owner-1', 'name' => 'Mine']);

    Assert::assertTrue($user->ownsTeam($team));
});

test('has teams trait ownsTeam returns false for other owner', function (): void {
    $user = traitsHasTeamsMockUser('owner-1');
    $team = new Team();
    $team->forceFill(['id' => 2, 'user_id' => 'other', 'name' => 'Other']);

    Assert::assertFalse($user->ownsTeam($team));
});

test('has teams trait handles multiple memberships via relation', function (): void {
    $user = traitsHasTeamsMockUser();
    $teams = collect([1, 2, 3])->map(static function (int $teamId): Team {
        $team = new Team();
        $team->forceFill(['id' => $teamId, 'name' => "Team {$teamId}", 'user_id' => 'x']);

        return $team;
    });
    $user->setRelation('teams', $teams);

    foreach ([1, 2, 3] as $teamId) {
        $team = new Team();
        $team->forceFill(['id' => $teamId, 'user_id' => 'x', 'name' => "Team {$teamId}"]);
        Assert::assertTrue($user->belongsToTeam($team));
    }
});

test('has teams trait concurrent checks use loaded relation', function (): void {
    $user = traitsHasTeamsMockUser();
    $team20 = new Team();
    $team20->forceFill(['id' => 20, 'user_id' => 'x', 'name' => 'T20']);
    $team10 = new Team();
    $team10->forceFill(['id' => 10, 'user_id' => 'x', 'name' => 'T10']);
    $team30 = new Team();
    $team30->forceFill(['id' => 30, 'user_id' => 'x', 'name' => 'T30']);
    $user->setRelation('teams', collect([$team20]));

    Assert::assertTrue($user->belongsToTeam($team20));
    Assert::assertFalse($user->belongsToTeam($team10));
    Assert::assertFalse($user->belongsToTeam($team30));
});

test('has teams trait integration with real user model', function (): void {
    $user = UserFactory::new()->createOne(['email' => 'traits-'.uniqid('', true).'@example.com']);
    $team = TeamFactory::new()->createOne(['name' => 'integration-'.uniqid(), 'user_id' => $user->id]);

    Assert::assertTrue($user->ownsTeam($team));
});

test('has teams trait user model exposes teams relation', function (): void {
    Assert::assertInstanceOf(BelongsToMany::class, (new User())->membershipTeams());
});

test('has teams trait empty teams collection', function (): void {
    $user = traitsHasTeamsMockUser();
    $user->setRelation('teams', collect([]));

    Assert::assertInstanceOf(Collection::class, $user->teams);
    Assert::assertCount(0, $user->teams);
    Assert::assertTrue($user->teams->isEmpty());
});

test('has teams trait belongsToTeams is false without teams', function (): void {
    $user = UserFactory::new()->createOne(['email' => 'no-teams-'.uniqid('', true).'@example.com']);

    Assert::assertFalse($user->belongsToTeams());
});
