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
        'name' => 'Test Team',
    ]);

    expect($team->id)->not->toBeNull();
    expect($team->user_id)->toBe($user->id);
    expect($team->name)->toBe('Test Team');
});

test('can create team with all fields', function (): void {
    $user = User::factory()->create();

    $teamData = [
        'user_id' => $user->id,
        'name' => 'Full Team',
        'personal_team' => 0,
        'code' => 'TEAM001',
        'uuid' => '550e8400-e29b-41d4-a716-446655440000',
        'owner_id' => $user->id,
    ];

    $team = Team::factory()->create($teamData);

    expect($team->id)->not->toBeNull();
    expect($team->user_id)->toBe($user->id);
    expect($team->name)->toBe('Full Team');
    expect($team->personal_team)->toBe(0);
    expect($team->code)->toBe('TEAM001');
    expect($team->uuid)->toBe('550e8400-e29b-41d4-a716-446655440000');
    expect($team->owner_id)->toBe($user->id);
});

test('can find team by name', function (): void {
    $user = User::factory()->create();
    $team = Team::factory()->create([
        'user_id' => $user->id,
        'name' => 'Unique Team Name',
    ]);

    $foundTeam = Team::where('name', 'Unique Team Name')->first();

    expect($foundTeam)->not->toBeNull();
    expect($foundTeam->id)->toBe($team->id);
});

test('can find team by code', function (): void {
    $user = User::factory()->create();
    $team = Team::factory()->create([
        'user_id' => $user->id,
        'code' => 'TEAM123',
    ]);

    $foundTeam = Team::where('code', 'TEAM123')->first();

    expect($foundTeam)->not->toBeNull();
    expect($foundTeam->id)->toBe($team->id);
});

test('can find team by uuid', function (): void {
    $user = User::factory()->create();
    $uuid = '550e8400-e29b-41d4-a716-446655440000';
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
        'personal_team' => 1,
    ]);
    Team::factory()->create([
        'user_id' => $user->id,
        'personal_team' => 0,
    ]);

    $personalTeams = Team::where('personal_team', 1)->get();

    expect($personalTeams->count())->toBeGreaterThanOrEqual(1);
    expect($personalTeams->first()->personal_team)->toBe(1);
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
    Team::factory()->create(['user_id' => $user->id, 'name' => 'Development Team']);
    Team::factory()->create(['user_id' => $user->id, 'name' => 'Marketing Team']);
    Team::factory()->create(['user_id' => $user->id, 'name' => 'Sales Team']);

    $devTeams = Team::where('name', 'like', '%Team%')->get();

    expect($devTeams->count())->toBeGreaterThanOrEqual(3);
    expect($devTeams->every(fn ($team) => str_contains($team->name, 'Team')))->toBeTrue();
});

test('can update team', function (): void {
    $user = User::factory()->create();
    $team = Team::factory()->create([
        'user_id' => $user->id,
        'name' => 'Old Name',
    ]);

    $team->update(['name' => 'New Name']);

    expect($team->fresh()->name)->toBe('New Name');
});

test('can handle null values', function (): void {
    $user = User::factory()->create();
    $team = Team::factory()->create([
        'user_id' => $user->id,
        'name' => 'Test Team',
        'code' => null,
        'uuid' => null,
        'owner_id' => null,
    ]);

    expect($team->code)->toBeNull();
    expect($team->uuid)->toBeNull();
    expect($team->owner_id)->toBeNull();
});

test('can find teams by multiple criteria', function (): void {
    $user = User::factory()->create();
    Team::factory()->create([
        'user_id' => $user->id,
        'name' => 'Development Team',
        'personal_team' => 0,
    ]);

    Team::factory()->create([
        'user_id' => $user->id,
        'name' => 'Personal Team',
        'personal_team' => 1,
    ]);

    $teams = Team::where('user_id', $user->id)->where('personal_team', 0)->get();

    expect($teams->count())->toBeGreaterThanOrEqual(1);
    expect($teams->first()->name)->toBe('Development Team');
    expect($teams->first()->personal_team)->toBe(0);
});
