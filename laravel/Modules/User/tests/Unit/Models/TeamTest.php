<?php

declare(strict_types=1);

use Modules\User\Models\Team;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('can create team with minimal data', function (): void {
    $user = User::factory()->create();

    $team = Team::factory()->create([
        'user_id' => $user->id,
        'name' => 'Test Team ' . uniqid(),
    ]);

    expect($team->id)->not->toBeNull();
    expect($team->user_id)->toBe($user->id);
});

test('can create team with all fields', function (): void {
    $user = User::factory()->create();
    $suffix = uniqid();

    $teamData = [
        'user_id' => $user->id,
        'name' => 'Full Team ' . $suffix,
        'personal_team' => false,
        'code' => 'TEAM' . substr($suffix, 0, 6),
        'owner_id' => $user->id,
    ];

    $team = Team::factory()->create($teamData);

    expect($team->id)->not->toBeNull();
    expect($team->user_id)->toBe($user->id);
    expect((bool) $team->personal_team)->toBeFalse();
});

test('can find team by name', function (): void {
    $user = User::factory()->create();
    $uniqueName = 'Unique Team Name ' . uniqid();
    $team = Team::factory()->create([
        'user_id' => $user->id,
        'name' => $uniqueName,
    ]);

    $foundTeam = Team::where('name', $uniqueName)->first();

    expect($foundTeam)->not->toBeNull();
    expect($foundTeam->id)->toBe($team->id);
});

test('can find team by code', function (): void {
    $user = User::factory()->create();
    $code = 'TEAM' . uniqid();
    $team = Team::factory()->create([
        'user_id' => $user->id,
        'code' => $code,
    ]);

    $foundTeam = Team::where('code', $code)->first();

    expect($foundTeam)->not->toBeNull();
    expect($foundTeam->id)->toBe($team->id);
});

test('can find team by uuid', function (): void {
    $user = User::factory()->create();
    // Skip if uuid column doesn't exist
    if (!\Schema::connection('user')->hasColumn('teams', 'uuid')) {
        $this->markTestSkipped('The teams table does not have a uuid column.');
        return;
    }
    $uuid = '550e8400-' . uniqid() . '-41d4-a716-446655440000';
    $team = Team::factory()->create([
        'user_id' => $user->id,
        'uuid' => $uuid,
    ]);

    $foundTeam = Team::where('uuid', $uuid)->first();

    expect($foundTeam)->not->toBeNull();
    expect($foundTeam->id)->toBe($team->id);
});

test('can find team by owner id', function (): void {
    $user = User::factory()->create();
    $team = Team::factory()->create([
        'user_id' => $user->id,
        'owner_id' => $user->id,
    ]);

    $foundTeam = Team::where('owner_id', $user->id)->first();

    expect($foundTeam)->not->toBeNull();
    expect($foundTeam->id)->toBe($team->id);
});

test('can find personal teams', function (): void {
    $user = User::factory()->create();
    Team::factory()->create([
        'user_id' => $user->id,
        'personal_team' => true,
    ]);
    Team::factory()->create([
        'user_id' => $user->id,
        'personal_team' => false,
    ]);

    $personalTeams = Team::where('user_id', $user->id)->where('personal_team', true)->get();

    expect($personalTeams->count())->toBeGreaterThanOrEqual(1);
    expect((bool) $personalTeams->first()->personal_team)->toBeTrue();
});

test('can find teams by user id', function (): void {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    Team::factory()->create(['user_id' => $user1->id]);
    Team::factory()->create(['user_id' => $user1->id]);
    Team::factory()->create(['user_id' => $user2->id]);

    $user1Teams = Team::where('user_id', $user1->id)->get();

    expect($user1Teams->count())->toBeGreaterThanOrEqual(2);
    expect($user1Teams->every(fn ($team) => $team->user_id === $user1->id))->toBeTrue();
});

test('can find teams by name pattern', function (): void {
    $user = User::factory()->create();
    $suffix = uniqid();
    Team::factory()->create(['user_id' => $user->id, 'name' => 'Development Team ' . $suffix]);
    Team::factory()->create(['user_id' => $user->id, 'name' => 'Marketing Team ' . $suffix]);
    Team::factory()->create(['user_id' => $user->id, 'name' => 'Sales Team ' . $suffix]);

    $devTeams = Team::where('name', 'like', '%Team ' . $suffix)->get();

    expect($devTeams->count())->toBeGreaterThanOrEqual(3);
    expect($devTeams->every(fn ($team) => str_contains($team->name, 'Team ' . $suffix)))->toBeTrue();
});

test('can update team', function (): void {
    $user = User::factory()->create();
    $oldName = 'Old Name ' . uniqid();
    $newName = 'New Name ' . uniqid();
    $team = Team::factory()->create([
        'user_id' => $user->id,
        'name' => $oldName,
    ]);

    $team->update(['name' => $newName]);

    expect($team->fresh()->name)->toBe($newName);
});

test('can handle null values', function (): void {
    $user = User::factory()->create();
    $team = Team::factory()->create([
        'user_id' => $user->id,
        'name' => 'Test Team ' . uniqid(),
        'code' => null,
        'owner_id' => null,
    ]);

    expect($team->code)->toBeNull();
    expect($team->owner_id)->toBeNull();
});

test('can find teams by multiple criteria', function (): void {
    $user = User::factory()->create();
    $suffix = uniqid();
    Team::factory()->create([
        'user_id' => $user->id,
        'name' => 'Development Team ' . $suffix,
        'personal_team' => false,
    ]);

    Team::factory()->create([
        'user_id' => $user->id,
        'name' => 'Personal Team ' . $suffix,
        'personal_team' => true,
    ]);

    $teams = Team::where('user_id', $user->id)
        ->where('name', 'like', '% ' . $suffix)
        ->where('personal_team', false)
        ->get();

    expect($teams->count())->toBeGreaterThanOrEqual(1);
    expect($teams->every(fn ($team) => ! (bool) $team->personal_team))->toBeTrue();
});
