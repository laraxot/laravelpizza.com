<?php

declare(strict_types=1);

use Modules\User\Contracts\TeamContract;
use Modules\User\Models\Role;
use Modules\User\Models\Team;
use Modules\User\Models\TeamUser;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

/**
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

/**
 * Fixture tipizzata: le proprieta' dinamiche del TestCase sono nullable,
 * quindi ogni test lavora su variabili locali non nulle.
 *
 * @return array{user: User, team: Team, personalTeam: Team}
 */
function hasTeamsTraitTestFixture(): array
{
    $user = User::factory()->create();
    $team = Team::factory()->create();
    $personalTeam = Team::factory()->create([
        'user_id' => $user->id,
        'personal_team' => true,
    ]);

    return [
        'user' => $user,
        'team' => $team,
        'personalTeam' => $personalTeam,
    ];
}

test('it correctly checks if user belongs to teams', function (): void {
    ['user' => $user, 'team' => $team] = hasTeamsTraitTestFixture();

    // Test: User senza team
    $userWithoutTeams = User::factory()->create();
    expect($userWithoutTeams->belongsToTeams())->toBeFalse();

    // Test: User con team owned
    expect($user->belongsToTeams())->toBeTrue();

    // Test: User con team membership
    $memberUser = User::factory()->create();
    $memberUser->membershipTeams()->attach($team->id, ['role' => 'member']);
    expect($memberUser->belongsToTeams())->toBeTrue();
});

test('it correctly checks if user belongs to specific team', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = hasTeamsTraitTestFixture();

    // Test: Null team
    expect($user->belongsToTeam(null))->toBeFalse();

    // Test: Owned team
    expect($user->belongsToTeam($personalTeam))->toBeTrue();

    // Test: Member team
    $user->membershipTeams()->attach($team->id, ['role' => 'member']);
    expect($user->belongsToTeam($team))->toBeTrue();

    // Test: Non-member team
    $otherTeam = Team::factory()->create();
    expect($user->belongsToTeam($otherTeam))->toBeFalse();
});

test('it correctly checks team ownership', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = hasTeamsTraitTestFixture();

    // Test: Owned team
    expect($user->ownsTeam($personalTeam))->toBeTrue();

    // Test: Non-owned team
    expect($user->ownsTeam($team))->toBeFalse();

    // Test: Member team (not owner)
    $user->membershipTeams()->attach($team->id, ['role' => 'member']);
    expect($user->ownsTeam($team))->toBeFalse();
});

test('it uses belongs to many x for teams relationship', function (): void {
    ['user' => $user] = hasTeamsTraitTestFixture();

    // Su BaseUser teams() e' la relazione Spatie (model_has_role): l'appartenenza
    // Jetstream-style costruita con belongsToManyX e' esposta come membershipTeams().
    $relation = $user->membershipTeams();
    // Verifica che il pivot model sia TeamUser
    expect($relation->getTable())->toBe('team_user');
});

test('it correctly manages current team', function (): void {
    ['user' => $user, 'team' => $team] = hasTeamsTraitTestFixture();

    // Test: Switch to valid team
    $user->membershipTeams()->attach($team->id, ['role' => 'member']);
    $result = $user->switchTeam($team);
    expect($result)->toBeTrue();
    expect($user->current_team_id)->toBe($team->id);

    // Test: Switch to non-member team
    $otherTeam = Team::factory()->create();
    $result = $user->switchTeam($otherTeam);
    expect($result)->toBeFalse();
});

test('it correctly identifies current team', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = hasTeamsTraitTestFixture();

    $user->switchTeam($personalTeam);

    expect($user->isCurrentTeam($personalTeam))->toBeTrue();
    expect($user->isCurrentTeam($team))->toBeFalse();
});

test('it returns all teams user owns or belongs to', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = hasTeamsTraitTestFixture();

    // Aggiungi user come member di un team
    $user->membershipTeams()->attach($team->id, ['role' => 'member']);

    $allTeams = $user->allTeams();

    expect($allTeams)->toHaveCount(2); // personal team + member team
    expect($allTeams->contains($personalTeam))->toBeTrue();
    expect($allTeams->contains($team))->toBeTrue();
});

test('it returns owned teams', function (): void {
    ['user' => $user, 'personalTeam' => $personalTeam] = hasTeamsTraitTestFixture();

    $ownedTeams = $user->ownedTeams;

    expect($ownedTeams)->toHaveCount(1);
    expect($ownedTeams->contains($personalTeam))->toBeTrue();
});

test('it returns personal team', function (): void {
    ['user' => $user, 'personalTeam' => $personalTeam] = hasTeamsTraitTestFixture();

    $resolvedPersonalTeam = $user->personalTeam();

    if (! $resolvedPersonalTeam instanceof TeamContract) {
        throw new RuntimeException('Expected the user to have a personal team.');
    }
    expect($resolvedPersonalTeam->id)->toBe($personalTeam->id);
    expect($resolvedPersonalTeam->personal_team)->toBeTrue();
});

test('it correctly determines team role', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = hasTeamsTraitTestFixture();

    // Test: Owner role
    $role = $user->teamRole($personalTeam);
    if (! $role instanceof Role) {
        throw new RuntimeException('Expected an owner role.');
    }
    expect($role->name)->toBe('owner');

    // Test: Member role
    $user->membershipTeams()->attach($team->id, ['role' => 'admin']);
    $role = $user->teamRole($team);
    if (! $role instanceof Role) {
        throw new RuntimeException('Expected a member role.');
    }
    expect($role->name)->toBe('admin');

    // Test: No role (not member)
    $otherTeam = Team::factory()->create();
    $role = $user->teamRole($otherTeam);
    expect($role)->toBeNull();
});

test('it provides team role name helper', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = hasTeamsTraitTestFixture();

    // Test: Owner role name
    $roleName = $user->teamRoleName($personalTeam);
    expect($roleName)->toBe('owner');

    // Test: Member role name - detach first to avoid duplicates
    $user->membershipTeams()->detach($team->id);
    $user->membershipTeams()->attach($team->id, ['role' => 'admin']);
    $roleName = $user->teamRoleName($team);
    expect($roleName)->toBe('admin');

    // Test: No role (not member)
    $otherTeam = Team::factory()->create();
    $roleName = $user->teamRoleName($otherTeam);
    expect($roleName)->toBe('Unknown');
});

test('it correctly checks team role', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = hasTeamsTraitTestFixture();

    // Test: Owner always has any role
    expect($user->hasTeamRole($personalTeam, 'admin'))->toBeTrue();
    expect($user->hasTeamRole($personalTeam, 'member'))->toBeTrue();

    // Test: Specific role check
    $user->membershipTeams()->attach($team->id, ['role' => 'admin']);
    expect($user->hasTeamRole($team, 'admin'))->toBeTrue();
    expect($user->hasTeamRole($team, 'member'))->toBeFalse();
});

test('it correctly manages team permissions', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = hasTeamsTraitTestFixture();

    // Test: Owner has all permissions
    $permissions = $user->teamPermissions($personalTeam);
    expect($permissions)->toBe(['*']);
    expect($user->hasTeamPermission($personalTeam, 'any_permission'))->toBeTrue();

    // Test: Non-member has no permissions
    $otherTeam = Team::factory()->create();
    $permissions = $user->teamPermissions($otherTeam);
    expect($permissions)->toBe([]);
    expect($user->hasTeamPermission($otherTeam, 'any_permission'))->toBeFalse();

    // Test: Member has the permissions granted on the team_user pivot
    $user->membershipTeams()->attach($team->id, [
        'role' => 'admin',
        // Array, non JSON: il pivot TeamUser casta `permissions` ad array e una stringa
        // JSON verrebbe codificata due volte.
        'permissions' => ['admin' => true, 'delete' => false],
    ]);
    $permissions = $user->teamPermissions($team);
    expect($permissions)->toBe(['admin']);
    expect($user->hasTeamPermission($team, 'admin'))->toBeTrue();
});

test('it provides utility methods', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = hasTeamsTraitTestFixture();

    // Test: hasTeams() alias
    expect($user->hasTeams())->toBeTrue();

    // Test: isOwnerOrMember()
    expect($user->isOwnerOrMember($personalTeam))->toBeTrue();

    $user->membershipTeams()->attach($team->id, ['role' => 'member']);
    expect($user->isOwnerOrMember($team))->toBeTrue();

    $otherTeam = Team::factory()->create();
    expect($user->isOwnerOrMember($otherTeam))->toBeFalse();
});

test('it handles edge cases correctly', function (): void {
    ['user' => $user] = hasTeamsTraitTestFixture();

    // Test: User senza ID
    $newUser = new User;
    expect($newUser->belongsToTeams())->toBeFalse();

    // Test: Team senza user_id
    $teamWithoutOwner = Team::factory()->create(['user_id' => null]);
    expect($user->ownsTeam($teamWithoutOwner))->toBeFalse();
});

test('it validates assertions correctly', function (): void {
    ['user' => $user] = hasTeamsTraitTestFixture();

    // ownsTeam() accetta ?TeamContract: un team assente non e' posseduto, nessuna eccezione.
    expect($user->ownsTeam(null))->toBeFalse();
});
