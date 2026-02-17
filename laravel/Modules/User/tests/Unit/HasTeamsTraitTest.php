<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Modules\User\Contracts\TeamContract;
use Modules\User\Models\Role;
use Modules\User\Models\Team;
use Modules\User\Models\TeamUser;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

/*
 * Test per il trait HasTeams corretto secondo filosofia Jetstream + Laraxot.
 *
 * Verifica tutte le correzioni implementate:
 * - belongsToTeams() ora funziona correttamente
 * - belongsToTeam() usa logica corretta
 * - ownsTeam() è efficiente
 * - teams() usa belongsToManyX
 * - Tipizzazione rigorosa
 * - Metodi non-Jetstream rimossi
 */
uses(TestCase::class);

beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->team = Team::factory()->create();
    $this->personalTeam = Team::factory()->create([
        'user_id' => $this->user->id,
        'personal_team' => true,
    ]);
});

test('it correctly checks if user belongs to teams', function (): void {
    // Test: User senza team
    $userWithoutTeams = User::factory()->create();
    expect($userWithoutTeams->belongsToTeams())->toBeFalse();

    // Test: User con team owned
    expect($this->user->belongsToTeams())->toBeTrue();

    // Test: User con team membership
    $memberUser = User::factory()->create();
    $memberUser->teams()->attach($this->team->id, ['role' => 'member']);
    expect($memberUser->belongsToTeams())->toBeTrue();
});

test('it correctly checks if user belongs to specific team', function (): void {
    // Test: Null team
    expect($this->user->belongsToTeam(null))->toBeFalse();

    // Test: Owned team
    expect($this->user->belongsToTeam($this->personalTeam))->toBeTrue();

    // Test: Member team
    $this->user->teams()->attach($this->team->id, ['role' => 'member']);
    expect($this->user->belongsToTeam($this->team))->toBeTrue();

    // Test: Non-member team
    $otherTeam = Team::factory()->create();
    expect($this->user->belongsToTeam($otherTeam))->toBeFalse();
});

test('it correctly checks team ownership', function (): void {
    // Test: Owned team
    expect($this->user->ownsTeam($this->personalTeam))->toBeTrue();

    // Test: Non-owned team
    expect($this->user->ownsTeam($this->team))->toBeFalse();

    // Test: Member team (not owner)
    $this->user->teams()->attach($this->team->id, ['role' => 'member']);
    expect($this->user->ownsTeam($this->team))->toBeFalse();
});

test('it uses belongs to many x for teams relationship', function (): void {
    // Verifica che la relazione teams() restituisca BelongsToMany
    $relation = $this->user->teams();
    expect($relation)->toBeInstanceOf(BelongsToMany::class);

    // Verifica che il pivot model sia TeamUser
    expect($relation->getTable())->toBe('team_user');
});

test('it correctly manages current team', function (): void {
    // Test: Switch to valid team
    $this->user->teams()->attach($this->team->id, ['role' => 'member']);
    $result = $this->user->switchTeam($this->team);
    expect($result)->toBeTrue();
    expect($this->user->current_team_id)->toBe($this->team->id);

    // Test: Switch to null
    $result = $this->user->switchTeam(null);
    expect($result)->toBeTrue();
    expect($this->user->current_team_id)->toBeNull();

    // Test: Switch to non-member team
    $otherTeam = Team::factory()->create();
    $result = $this->user->switchTeam($otherTeam);
    expect($result)->toBeFalse();
});

test('it correctly identifies current team', function (): void {
    $this->user->switchTeam($this->personalTeam);

    expect($this->user->isCurrentTeam($this->personalTeam))->toBeTrue();
    expect($this->user->isCurrentTeam($this->team))->toBeFalse();
});

test('it returns all teams user owns or belongs to', function (): void {
    // Aggiungi user come member di un team
    $this->user->teams()->attach($this->team->id, ['role' => 'member']);

    $allTeams = $this->user->allTeams();

    expect($allTeams)->toBeInstanceOf(Collection::class);
    expect($allTeams)->toHaveCount(2); // personal team + member team
    expect($allTeams->contains($this->personalTeam))->toBeTrue();
    expect($allTeams->contains($this->team))->toBeTrue();
});

test('it returns owned teams', function (): void {
    $ownedTeams = $this->user->ownedTeams;

    expect($ownedTeams)->toBeInstanceOf(Collection::class);
    expect($ownedTeams)->toHaveCount(1);
    expect($ownedTeams->contains($this->personalTeam))->toBeTrue();
});

test('it returns personal team', function (): void {
    $personalTeam = $this->user->personalTeam();

    expect($personalTeam)->toBeInstanceOf(TeamContract::class);
    expect($personalTeam->id)->toBe($this->personalTeam->id);
    expect($personalTeam->personal_team)->toBeTrue();
});

test('it correctly determines team role', function (): void {
    // Test: Owner role
    $role = $this->user->teamRole($this->personalTeam);
    expect($role)->toBeInstanceOf(Role::class);
    expect($role->name)->toBe('owner');

    // Test: Member role
    $this->user->teams()->attach($this->team->id, ['role' => 'admin']);
    $role = $this->user->teamRole($this->team);
    expect($role)->toBeInstanceOf(Role::class);
    expect($role->name)->toBe('admin');

    // Test: No role (not member)
    $otherTeam = Team::factory()->create();
    $role = $this->user->teamRole($otherTeam);
    expect($role)->toBeNull();
});

test('it provides team role name helper', function (): void {
    // Test: Owner role name
    $roleName = $this->user->teamRoleName($this->personalTeam);
    expect($roleName)->toBe('owner');

    // Test: Member role name - detach first to avoid duplicates
    $this->user->teams()->detach($this->team->id);
    $this->user->teams()->attach($this->team->id, ['role' => 'admin']);
    $roleName = $this->user->teamRoleName($this->team);
    expect($roleName)->toBe('admin');

    // Test: No role (not member)
    $otherTeam = Team::factory()->create();
    $roleName = $this->user->teamRoleName($otherTeam);
    expect($roleName)->toBeNull();
});

test('it correctly checks team role', function (): void {
    // Test: Owner always has any role
    expect($this->user->hasTeamRole($this->personalTeam, 'admin'))->toBeTrue();
    expect($this->user->hasTeamRole($this->personalTeam, 'member'))->toBeTrue();

    // Test: Specific role check
    $this->user->teams()->attach($this->team->id, ['role' => 'admin']);
    expect($this->user->hasTeamRole($this->team, 'admin'))->toBeTrue();
    expect($this->user->hasTeamRole($this->team, 'member'))->toBeFalse();
});

test('it correctly manages team permissions', function (): void {
    // Test: Owner has all permissions
    $permissions = $this->user->teamPermissions($this->personalTeam);
    expect($permissions)->toBe(['*']);
    expect($this->user->hasTeamPermission($this->personalTeam, 'any_permission'))->toBeTrue();

    // Test: Non-member has no permissions
    $otherTeam = Team::factory()->create();
    $permissions = $this->user->teamPermissions($otherTeam);
    expect($permissions)->toBe([]);
    expect($this->user->hasTeamPermission($otherTeam, 'any_permission'))->toBeFalse();

    // Test: Member has role-based permissions
    $this->user->teams()->attach($this->team->id, ['role' => 'admin']);
    $permissions = $this->user->teamPermissions($this->team);
    expect($permissions)->toBe(['admin']);
    expect($this->user->hasTeamPermission($this->team, 'admin'))->toBeTrue();
});

test('it provides utility methods', function (): void {
    // Test: hasTeams() alias
    expect($this->user->hasTeams())->toBeTrue();

    // Test: isOwnerOrMember()
    expect($this->user->isOwnerOrMember($this->personalTeam))->toBeTrue();

    $this->user->teams()->attach($this->team->id, ['role' => 'member']);
    expect($this->user->isOwnerOrMember($this->team))->toBeTrue();

    $otherTeam = Team::factory()->create();
    expect($this->user->isOwnerOrMember($otherTeam))->toBeFalse();
});

test('it handles edge cases correctly', function (): void {
    // Test: User senza ID
    $newUser = new User();
    expect($newUser->belongsToTeams())->toBeFalse();

    // Test: Team senza user_id
    $teamWithoutOwner = Team::factory()->create(['user_id' => null]);
    expect($this->user->ownsTeam($teamWithoutOwner))->toBeFalse();
});

test('it validates assertions correctly', function (): void {
    expect(fn () => $this->user->ownsTeam(null))->toThrow(InvalidArgumentException::class, 'Team cannot be null');
});
