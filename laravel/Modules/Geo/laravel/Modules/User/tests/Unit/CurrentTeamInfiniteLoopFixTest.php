<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Database\Factories\TeamFactory;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * @param array<string, mixed> $attributes
 */
function currentTeamFixCreateUser(array $attributes = []): User
{
    return createTestUser(array_merge([
        'name' => 'Test User',
        'current_team_id' => null,
    ], $attributes));
}

/**
 * @param array<string, mixed> $attributes
 */
function currentTeamFixCreateTeam(User $user, array $attributes = []): Team
{
    return TeamFactory::new()->createOne(array_merge([
        'user_id' => $user->id,
        'name' => 'Team-'.uniqid(),
        'personal_team' => true,
    ], $attributes));
}

beforeEach(function (): void {
    skipUnlessUsersTableReady();
});

test('current team getter does not crash when user has no teams', function () {
    $user = currentTeamFixCreateUser();

    Assert::assertInstanceOf(BelongsTo::class, $user->currentTeam());
    Assert::assertNull($user->currentTeam);
});

test('current team getter is side effect free', function () {
    $user = currentTeamFixCreateUser(['current_team_id' => null]);
    $originalTeamId = $user->current_team_id;

    Assert::assertNull($user->currentTeam);
    Assert::assertNull($user->currentTeam);
    Assert::assertInstanceOf(BelongsTo::class, $user->currentTeam());

    $user->refresh();
    Assert::assertSame($originalTeamId, $user->current_team_id);
});

test('current team getter does not trigger save operations', function () {
    $user = currentTeamFixCreateUser();
    $updatedAtBefore = $user->updated_at;

    Assert::assertNull($user->currentTeam);

    $user->refresh();
    Assert::assertNotNull($user->updated_at);
    Assert::assertNotNull($updatedAtBefore);
    Assert::assertTrue($user->updated_at->equalTo($updatedAtBefore));
});

test('initialize current team sets personal team correctly', function () {
    $user = currentTeamFixCreateUser(['current_team_id' => null]);
    $personalTeam = currentTeamFixCreateTeam($user, [
        'name' => 'Personal Team',
        'personal_team' => true,
    ]);

    $user->initializeCurrentTeam();
    $user->refresh();

    Assert::assertSame($personalTeam->id, $user->current_team_id);
});

test('initialize current team does not override existing current team id', function () {
    $user = currentTeamFixCreateUser();
    $team1 = currentTeamFixCreateTeam($user, ['name' => 'Team 1', 'personal_team' => false]);
    currentTeamFixCreateTeam($user, ['name' => 'Team 2', 'personal_team' => true]);

    $user->current_team_id = (int) $team1->id;
    $user->save();

    $user->initializeCurrentTeam();
    $user->refresh();

    Assert::assertSame($team1->id, $user->current_team_id);
});

test('initialize current team sets first available team if no personal team', function () {
    $user = currentTeamFixCreateUser(['current_team_id' => null]);
    $team = currentTeamFixCreateTeam($user, [
        'name' => 'Regular Team',
        'personal_team' => false,
    ]);

    $user->initializeCurrentTeam();
    $user->refresh();

    Assert::assertSame($team->id, $user->current_team_id);
});

test('initialize current team handles user without teams gracefully', function () {
    $user = currentTeamFixCreateUser(['current_team_id' => null]);

    $user->initializeCurrentTeam();
    $user->refresh();

    Assert::assertNull($user->current_team_id);
});

test('current team getter does not cause errors on repeated access', function () {
    $user = currentTeamFixCreateUser();
    $team = currentTeamFixCreateTeam($user, ['name' => 'Test Team', 'personal_team' => true]);

    $user->current_team_id = (int) $team->id;
    $user->save();
    $user->refresh();

    Assert::assertInstanceOf(Team::class, $user->currentTeam);
    Assert::assertSame($team->id, $user->currentTeam->id);
    Assert::assertInstanceOf(BelongsTo::class, $user->currentTeam());
});

test('current team getter works correctly with existing team', function () {
    $user = currentTeamFixCreateUser();
    $team = currentTeamFixCreateTeam($user, ['name' => 'Test Team', 'personal_team' => true]);

    $user->current_team_id = (int) $team->id;
    $user->save();

    $currentTeam = $user->currentTeam()->first();

    Assert::assertInstanceOf(Team::class, $currentTeam);
    Assert::assertSame($team->id, $currentTeam->id);
    Assert::assertSame('Test Team', $currentTeam->name);
});

test('user creation does not trigger infinite loop', function () {
    $user = currentTeamFixCreateUser(['name' => 'New User']);

    Assert::assertInstanceOf(User::class, $user);
    Assert::assertNotNull($user->id);
    Assert::assertSame('New User', $user->name);
    Assert::assertNull($user->currentTeam);
    Assert::assertInstanceOf(BelongsTo::class, $user->currentTeam());
});

test('multiple users can be created without issues', function () {
    $users = [];

    for ($i = 1; $i <= 5; ++$i) {
        $users[] = currentTeamFixCreateUser([
            'name' => "User {$i}",
            'email' => "user-{$i}-".uniqid('', true).'@example.com',
        ]);
    }

    Assert::assertCount(5, $users);

    foreach ($users as $user) {
        Assert::assertInstanceOf(User::class, $user);
        Assert::assertNotNull($user->id);
        Assert::assertNull($user->currentTeam);
        Assert::assertInstanceOf(BelongsTo::class, $user->currentTeam());
    }
});
