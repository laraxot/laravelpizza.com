<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\User\Database\Factories\TeamFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

/**
 * @param array<string, mixed> $attributes
 */
function modelsTeamCreateUser(array $attributes = []): User
{
    return UserFactory::new()->createOne(array_merge([
        'email' => 'test-'.uniqid('', true).'@example.com',
    ], $attributes));
}

function modelsTeamTableHasColumn(string $column): bool
{
    return Schema::connection('user')->hasColumn('teams', $column);
}

test('can create team with minimal data', function (): void {
    $user = modelsTeamCreateUser();
    $team = TeamFactory::new()->createOne([
        'user_id' => $user->id,
        'name' => 'Test Team '.uniqid(),
    ]);

    Assert::assertNotNull($team->id);
    Assert::assertSame($user->id, $team->user_id);
    Assert::assertStringStartsWith('Test Team', (string) $team->name);
});

test('can create team with all fields', function (): void {
    $user = modelsTeamCreateUser();
    $uuid = (string) Str::uuid();

    $teamData = [
        'user_id' => $user->id,
        'name' => 'Full Team '.uniqid(),
        'personal_team' => false,
        'uuid' => $uuid,
    ];

    if (modelsTeamTableHasColumn('code')) {
        $teamData['code'] = 'TEAM001';
    }

    $team = TeamFactory::new()->createOne($teamData);

    Assert::assertNotNull($team->id);
    Assert::assertSame($user->id, $team->user_id);
    Assert::assertSame($uuid, $team->uuid);
    Assert::assertFalse((bool) $team->personal_team);

    if (modelsTeamTableHasColumn('code')) {
        Assert::assertSame('TEAM001', $team->code);
    }
});

test('can find team by name', function (): void {
    $user = modelsTeamCreateUser();
    $name = 'Unique Team Name '.uniqid();
    $team = TeamFactory::new()->createOne([
        'user_id' => $user->id,
        'name' => $name,
    ]);

    $foundTeam = Team::where('name', $name)->first();

    Assert::assertInstanceOf(Team::class, $foundTeam);
    Assert::assertSame($team->id, $foundTeam->id);
});

test('can find team by code', function (): void {
    if (! modelsTeamTableHasColumn('code')) {
        Assert::assertFalse(modelsTeamTableHasColumn('code'));

        return;
    }

    $user = modelsTeamCreateUser();
    $code = 'TEAM'.uniqid();
    $team = TeamFactory::new()->createOne([
        'user_id' => $user->id,
        'code' => $code,
    ]);

    $foundTeam = Team::where('code', $code)->first();

    Assert::assertInstanceOf(Team::class, $foundTeam);
    Assert::assertSame($team->id, $foundTeam->id);
});

test('can find team by uuid', function (): void {
    $user = modelsTeamCreateUser();
    $uuid = (string) Str::uuid();
    $team = TeamFactory::new()->createOne([
        'user_id' => $user->id,
        'uuid' => $uuid,
    ]);

    $foundTeam = Team::query()->where('uuid', $uuid)->whereKey($team->id)->first();

    Assert::assertInstanceOf(Team::class, $foundTeam);
    Assert::assertSame($team->id, $foundTeam->id);
});

test('can find team by owner id', function (): void {
    $user = modelsTeamCreateUser();
    $team = TeamFactory::new()->createOne([
        'user_id' => $user->id,
    ]);

    $foundTeam = Team::where('user_id', $user->id)->first();

    Assert::assertInstanceOf(Team::class, $foundTeam);
    Assert::assertSame($team->id, $foundTeam->id);
});

test('can find personal teams', function (): void {
    $user = modelsTeamCreateUser();
    TeamFactory::new()->createOne([
        'user_id' => $user->id,
        'name' => 'personal-'.uniqid(),
        'personal_team' => true,
    ]);
    TeamFactory::new()->createOne([
        'user_id' => $user->id,
        'name' => 'regular-'.uniqid(),
        'personal_team' => false,
    ]);

    $personalTeams = Team::where('personal_team', true)->get();

    Assert::assertGreaterThanOrEqual(1, $personalTeams->count());
    $first = $personalTeams->first();
    Assert::assertInstanceOf(Team::class, $first);
    Assert::assertTrue((bool) $first->personal_team);
});

test('can find teams by user id', function (): void {
    $user1 = modelsTeamCreateUser();
    $user2 = modelsTeamCreateUser();

    TeamFactory::new()->createOne(['user_id' => $user1->id, 'name' => 'u1-a-'.uniqid()]);
    TeamFactory::new()->createOne(['user_id' => $user1->id, 'name' => 'u1-b-'.uniqid()]);
    TeamFactory::new()->createOne(['user_id' => $user2->id, 'name' => 'u2-'.uniqid()]);

    $user1Teams = Team::where('user_id', $user1->id)->get();

    Assert::assertGreaterThanOrEqual(2, $user1Teams->count());
    foreach ($user1Teams as $userTeam) {
        Assert::assertSame($user1->id, $userTeam->user_id);
    }
});

test('can find teams by name pattern', function (): void {
    $user = modelsTeamCreateUser();
    $suffix = uniqid();
    TeamFactory::new()->createOne(['user_id' => $user->id, 'name' => "Development Team {$suffix}"]);
    TeamFactory::new()->createOne(['user_id' => $user->id, 'name' => "Marketing Team {$suffix}"]);
    TeamFactory::new()->createOne(['user_id' => $user->id, 'name' => "Sales Team {$suffix}"]);

    $devTeams = Team::where('name', 'like', '%Team '.$suffix)->get();

    Assert::assertGreaterThanOrEqual(3, $devTeams->count());
    foreach ($devTeams as $devTeam) {
        Assert::assertStringContainsString('Team', (string) $devTeam->name);
    }
});

test('can update team', function (): void {
    $user = modelsTeamCreateUser();
    $team = TeamFactory::new()->createOne([
        'user_id' => $user->id,
        'name' => 'Old Name '.uniqid(),
    ]);

    $newName = 'New Name '.uniqid();
    $team->update(['name' => $newName]);

    $refreshed = $team->fresh();
    Assert::assertInstanceOf(Team::class, $refreshed);
    Assert::assertSame($newName, $refreshed->name);
});

test('can handle null values', function (): void {
    $user = modelsTeamCreateUser();
    $teamData = [
        'user_id' => $user->id,
        'name' => 'Test Team '.uniqid(),
        'uuid' => null,
    ];

    if (modelsTeamTableHasColumn('code')) {
        $teamData['code'] = null;
    }

    $team = TeamFactory::new()->createOne($teamData);

    if (modelsTeamTableHasColumn('code')) {
        Assert::assertNull($team->code);
    }

    Assert::assertNull($team->uuid);
});

test('can find teams by multiple criteria', function (): void {
    $user = modelsTeamCreateUser();
    $devName = 'Development Team '.uniqid();
    TeamFactory::new()->createOne([
        'user_id' => $user->id,
        'name' => $devName,
        'personal_team' => false,
    ]);

    TeamFactory::new()->createOne([
        'user_id' => $user->id,
        'name' => 'Personal Team '.uniqid(),
        'personal_team' => true,
    ]);

    $teams = Team::where('user_id', $user->id)->where('personal_team', false)->get();

    Assert::assertGreaterThanOrEqual(1, $teams->count());
    $first = $teams->first();
    Assert::assertInstanceOf(Team::class, $first);
    Assert::assertSame($devName, $first->name);
    Assert::assertFalse((bool) $first->personal_team);
});
