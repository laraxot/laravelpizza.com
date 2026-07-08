<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\User\Contracts\TeamContract;
use Modules\User\Database\Factories\TeamFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Role;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(Modules\User\Tests\TestCase::class);

/**
 * @param array<string, mixed> $attributes
 */
function pestHasTeamsCreateTestUser(array $attributes = []): User
{
    return UserFactory::new()->createOne(array_merge([
        'email' => 'test-'.uniqid('', true).'@example.com',
    ], $attributes));
}

/**
 * @return array{user: User, team: Team, personalTeam: Team}
 */
function pestHasTeamsBootstrapFixture(): array
{
    $user = pestHasTeamsCreateTestUser();
    $team = TeamFactory::new()->createOne(['name' => 'shared-'.uniqid()]);
    $personalTeam = TeamFactory::new()->createOne([
        'user_id' => $user->id,
        'name' => 'personal-'.uniqid(),
        'personal_team' => true,
    ]);

    return [
        'user' => $user,
        'team' => $team,
        'personalTeam' => $personalTeam,
    ];
}

/**
 * @param array<string, mixed> $pivot
 */
function pestHasTeamsAttachMember(Team $team, User $user, array $pivot = []): void
{
    $payload = [
        'team_id' => $team->id,
        'user_id' => $user->id,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    if (isset($pivot['role'])) {
        $payload['role'] = $pivot['role'];
    }

    if (Schema::connection('user')->hasColumn('team_user', 'permissions') && array_key_exists('permissions', $pivot)) {
        $permissions = $pivot['permissions'];
        $payload['permissions'] = is_array($permissions) ? json_encode($permissions) : $permissions;
    }

    DB::connection('user')->table('team_user')->insert($payload);
}

test('it correctly checks if user belongs to teams', function (): void {
    ['user' => $user, 'team' => $team] = pestHasTeamsBootstrapFixture();
    $userWithoutTeams = pestHasTeamsCreateTestUser();

    Assert::assertFalse($userWithoutTeams->belongsToTeams());
    Assert::assertTrue($user->belongsToTeams());

    $memberUser = pestHasTeamsCreateTestUser();
    pestHasTeamsAttachMember($team, $memberUser, ['role' => 'member']);
    Assert::assertTrue($memberUser->teamUsers()->exists());
});

test('it correctly checks if user belongs to specific team', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = pestHasTeamsBootstrapFixture();

    Assert::assertFalse($user->belongsToTeam(null));
    Assert::assertTrue($user->belongsToTeam($personalTeam));

    pestHasTeamsAttachMember($team, $user, ['role' => 'member']);
    Assert::assertTrue($user->teamUsers()->where('team_id', $team->id)->exists());

    $otherTeam = TeamFactory::new()->createOne(['name' => 'other-'.uniqid()]);
    Assert::assertFalse($user->belongsToTeam($otherTeam));
});

test('it correctly checks team ownership', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = pestHasTeamsBootstrapFixture();

    Assert::assertTrue($user->ownsTeam($personalTeam));
    Assert::assertFalse($user->ownsTeam($team));

    pestHasTeamsAttachMember($team, $user, ['role' => 'member']);
    Assert::assertFalse($user->ownsTeam($team));
});

test('it uses belongs to many x for teams relationship', function (): void {
    ['user' => $user] = pestHasTeamsBootstrapFixture();

    Assert::assertInstanceOf(BelongsToMany::class, $user->membershipTeams());
});

test('it correctly manages current team', function (): void {
    ['user' => $user, 'personalTeam' => $personalTeam] = pestHasTeamsBootstrapFixture();

    Assert::assertTrue($user->switchTeam($personalTeam));

    $refreshed = $user->fresh();
    Assert::assertInstanceOf(User::class, $refreshed);
    Assert::assertSame((string) $refreshed->current_team_id, (string) $personalTeam->id);

    $otherTeam = TeamFactory::new()->createOne(['name' => 'switch-other-'.uniqid()]);
    Assert::assertFalse($user->switchTeam($otherTeam));
});

test('it correctly identifies current team', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = pestHasTeamsBootstrapFixture();

    $user->switchTeam($personalTeam);

    Assert::assertTrue($user->isCurrentTeam($personalTeam));
    Assert::assertFalse($user->isCurrentTeam($team));
});

test('it returns all teams user owns or belongs to', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = pestHasTeamsBootstrapFixture();

    pestHasTeamsAttachMember($team, $user, ['role' => 'member']);

    $allTeams = $user->allTeams();

    Assert::assertInstanceOf(Collection::class, $allTeams);
    Assert::assertCount(1, $allTeams);
    Assert::assertContains($personalTeam->id, $allTeams->pluck('id')->toArray());
    Assert::assertTrue($user->teamUsers()->where('team_id', $team->id)->exists());
});

test('it returns owned teams', function (): void {
    ['user' => $user, 'personalTeam' => $personalTeam] = pestHasTeamsBootstrapFixture();

    $ownedTeams = $user->ownedTeams;

    Assert::assertInstanceOf(Collection::class, $ownedTeams);
    Assert::assertCount(1, $ownedTeams);
    Assert::assertContains($personalTeam->id, $ownedTeams->pluck('id')->toArray());
});

test('it returns personal team', function (): void {
    ['user' => $user, 'personalTeam' => $personalTeam] = pestHasTeamsBootstrapFixture();

    $resolvedPersonalTeam = $user->personalTeam();

    Assert::assertInstanceOf(TeamContract::class, $resolvedPersonalTeam);
    Assert::assertSame($personalTeam->id, $resolvedPersonalTeam->id);
    Assert::assertTrue($resolvedPersonalTeam->personal_team);
});

test('it correctly determines team role', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = pestHasTeamsBootstrapFixture();

    $role = $user->teamRole($personalTeam);
    Assert::assertInstanceOf(Role::class, $role);
    Assert::assertSame('owner', $role->name);

    pestHasTeamsAttachMember($team, $user, ['role' => 'admin']);
    $user->unsetRelation('teamUsers');
    $role = $user->teamRole($team);
    Assert::assertInstanceOf(Role::class, $role);
    Assert::assertSame('admin', $role->name);

    $otherUser = pestHasTeamsCreateTestUser();
    Assert::assertNull($otherUser->teamRole($team));
});

test('it provides team role name helper', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = pestHasTeamsBootstrapFixture();

    Assert::assertSame('owner', $user->teamRoleName($personalTeam));

    pestHasTeamsAttachMember($team, $user, ['role' => 'admin']);
    $user->unsetRelation('teamUsers');
    Assert::assertSame('admin', $user->teamRoleName($team));

    $otherTeam = TeamFactory::new()->createOne(['name' => 'name-other-'.uniqid()]);
    Assert::assertSame('Unknown', $user->teamRoleName($otherTeam));
});

test('it correctly checks team role', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = pestHasTeamsBootstrapFixture();

    pestHasTeamsAttachMember($team, $user, ['role' => 'admin']);
    $user->unsetRelation('teamUsers');
    Assert::assertTrue($user->hasTeamRole($team, 'admin'));
    Assert::assertFalse($user->hasTeamRole($team, 'editor'));

    Assert::assertTrue($user->hasTeamRole($personalTeam, 'admin'));
    Assert::assertTrue($user->hasTeamRole($personalTeam, 'editor'));

    $otherTeam = TeamFactory::new()->createOne(['name' => 'role-other-'.uniqid()]);
    Assert::assertFalse($user->hasTeamRole($otherTeam, 'admin'));
});

test('it correctly manages team permissions', function (): void {
    ['user' => $user, 'team' => $team, 'personalTeam' => $personalTeam] = pestHasTeamsBootstrapFixture();

    Assert::assertTrue($user->hasTeamPermission($personalTeam, 'edit-team'));

    if (Schema::connection('user')->hasColumn('team_user', 'permissions')) {
        pestHasTeamsAttachMember($team, $user, [
            'role' => 'editor',
            'permissions' => ['edit-content' => true],
        ]);
        $user->unsetRelation('teamUsers');

        Assert::assertTrue($user->hasTeamPermission($team, 'edit-content'));
        Assert::assertFalse($user->hasTeamPermission($team, 'delete-content'));
    }
});

test('it handles edge cases', function (): void {
    ['user' => $user] = pestHasTeamsBootstrapFixture();
    $newUser = new User();

    Assert::assertFalse($newUser->belongsToTeams());

    $teamWithoutOwner = TeamFactory::new()->createOne(['user_id' => null, 'name' => 'no-owner-'.uniqid()]);
    Assert::assertFalse($user->ownsTeam($teamWithoutOwner));

    $nonExistentTeam = new Team(['id' => 9999]);
    Assert::assertFalse($user->belongsToTeam($nonExistentTeam));
});
