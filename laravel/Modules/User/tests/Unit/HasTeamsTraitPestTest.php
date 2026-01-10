<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Modules\User\Contracts\TeamContract;
use Modules\User\Models\Role;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->team = Team::factory()->create();
    $this->personalTeam = Team::factory()->create([
        'user_id' => $this->user->id,
        'personal_team' => true,
    ]);
});

test('it correctly checks if user belongs to teams', function () {
    // Test: User without teams
    $userWithoutTeams = User::factory()->create();
    expect($userWithoutTeams->belongsToTeams())->toBeFalse();

    // Test: User with owned team
    expect($this->user->belongsToTeams())->toBeTrue();

    // Test: User with team membership
    $memberUser = User::factory()->create();
    $memberUser->teams()->attach($this->team->id, ['role' => 'member']);
    expect($memberUser->belongsToTeams())->toBeTrue();
});

test('it correctly checks if user belongs to specific team', function () {
    // Test: Null team
    expect($this->user->belongsToTeam(null))->toBeFalse();

    // Test: Owned team
    expect($this->user->belongsToTeam($this->personalTeam))->toBeTrue();

    // Test: Member team
    $this->user->teams()->attach($this->team->id, ['role' => 'member']);
    $this->user->refresh();
    expect($this->user->belongsToTeam($this->team))->toBeTrue();

    // Test: Non-member team
    $otherTeam = Team::factory()->create();
    expect($this->user->belongsToTeam($otherTeam))->toBeFalse();
});

test('it correctly checks team ownership', function () {
    // Test: Owned team
    expect($this->user->ownsTeam($this->personalTeam))->toBeTrue();

    // Test: Non-owned team
    expect($this->user->ownsTeam($this->team))->toBeFalse();

    // Test: Member team (not owner)
    $this->user->teams()->attach($this->team->id, ['role' => 'member']);
    expect($this->user->ownsTeam($this->team))->toBeFalse();
});

test('it uses belongs to many x for teams relationship', function () {
    // Verify teams() relationship returns BelongsToMany
    $relation = $this->user->teams();
    expect($relation)
        ->toBeInstanceOf(BelongsToMany::class)
        ->getTable()
        ->toBe('team_user');
});

test('it correctly manages current team', function () {
    // Test: Switch to valid team
    $this->user->teams()->attach($this->team->id, ['role' => 'member']);
    $this->user->refresh();
    $result = $this->user->switchTeam($this->team);

    expect($result)->toBeTrue()->and($this->user->current_team_id)->toBe((string) $this->team->id);

    // Test: Switch to null
    $result = $this->user->switchTeam(null);
    expect($result)->toBeTrue()->and($this->user->current_team_id)->toBeNull();

    // Test: Switch to non-member team
    $otherTeam = Team::factory()->create();
    $result = $this->user->switchTeam($otherTeam);
    expect($result)->toBeFalse();
});

test('it correctly identifies current team', function () {
    $this->user->switchTeam($this->personalTeam);

    expect($this->user->isCurrentTeam($this->personalTeam))
        ->toBeTrue()
        ->and($this->user->isCurrentTeam($this->team))
        ->toBeFalse();
});

test('it returns all teams user owns or belongs to', function () {
    // Add user as member of a team
    $this->user->teams()->attach($this->team->id, ['role' => 'member']);
    $this->user->refresh();

    $allTeams = $this->user->allTeams();

    expect($allTeams)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(2);

    expect($allTeams->pluck('id')->toArray())
        ->toContain($this->personalTeam->id)
        ->toContain($this->team->id); // personal team + member team
});

test('it returns owned teams', function () {
    $ownedTeams = $this->user->ownedTeams;

    expect($ownedTeams)->toBeInstanceOf(Collection::class)->toHaveCount(1);
    expect($ownedTeams->pluck('id')->toArray())->toContain($this->personalTeam->id);
});

test('it returns personal team', function () {
    $personalTeam = $this->user->personalTeam();

    expect($personalTeam)
        ->toBeInstanceOf(TeamContract::class)
        ->id->toBe($this->personalTeam->id)
        ->personal_team->toBeTrue();
});

test('it correctly determines team role', function () {
    // Test: Owner role
    $role = $this->user->teamRole($this->personalTeam);
    expect($role)->toBeInstanceOf(Role::class)->name->toBe('owner');

    // Test: Member role
    $this->user->teams()->attach($this->team->id, ['role' => 'admin']);
    $role = $this->user->teamRole($this->team);
    expect($role)->toBeInstanceOf(Role::class)->name->toBe('admin');

    // Test: No role
    $otherUser = User::factory()->create();
    expect($otherUser->teamRole($this->team))->toBeNull();
});

test('it provides team role name helper', function () {
    // Test: Owner role name
    $roleName = $this->user->teamRoleName($this->personalTeam);
    expect($roleName)->toBe('owner');

    // Test: Member role name - detach first to avoid duplicates
    $this->user->teams()->detach($this->team->id);
    $this->user->teams()->attach($this->team->id, ['role' => 'admin']);
    $roleName = $this->user->teamRoleName($this->team);
    expect($roleName)->toBe('admin');

    // Test: Unknown role
    $otherTeam = Team::factory()->create();
    $roleName = $this->user->teamRoleName($otherTeam);
    expect($roleName)->toBe('Unknown');
});

test('it correctly checks team role', function () {
    // Test: Has role
    $this->user->teams()->attach($this->team->id, ['role' => 'admin']);
    expect($this->user->hasTeamRole($this->team, 'admin'))
        ->toBeTrue()
        ->and($this->user->hasTeamRole($this->team, 'editor'))
        ->toBeFalse();

    // Test: Owner has all roles
    expect($this->user->hasTeamRole($this->personalTeam, 'admin'))
        ->toBeTrue()
        ->and($this->user->hasTeamRole($this->personalTeam, 'editor'))
        ->toBeTrue();

    // Test: No role
    $otherTeam = Team::factory()->create();
    expect($this->user->hasTeamRole($otherTeam, 'admin'))->toBeFalse();
});

test('it correctly manages team permissions', function () {
    // Test: Owner has all permissions
    expect($this->user->hasTeamPermission($this->personalTeam, 'edit-team'))->toBeTrue();

    // Test: Member with specific permission
    $this->user->teams()->attach($this->team->id, [
        'role' => 'editor',
        'permissions' => ['edit-content' => true],
    ]);

    expect($this->user->hasTeamPermission($this->team, 'edit-content'))
        ->toBeTrue()
        ->and($this->user->hasTeamPermission($this->team, 'delete-content'))
        ->toBeFalse();
});

test('it handles edge cases', function () {
    // Test: User without ID
    $newUser = new User();
    expect($newUser->belongsToTeams())->toBeFalse();

    // Test: Team without owner
    $teamWithoutOwner = Team::factory()->create(['user_id' => null]);
    expect($this->user->ownsTeam($teamWithoutOwner))->toBeFalse();

    // Test: Non-existent team
    $nonExistentTeam = new Team(['id' => 9999]);
    expect($this->user->belongsToTeam($nonExistentTeam))->toBeFalse();
});
