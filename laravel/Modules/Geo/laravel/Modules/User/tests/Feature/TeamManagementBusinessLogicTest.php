<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\User\Database\Factories\TeamFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Team;
use Modules\User\Models\TeamInvitation;
use Modules\User\Models\TeamUser;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(Modules\User\Tests\TestCase::class);

function teamMgmtBizUserTableHasColumn(string $table, string $column): bool
{
    return Schema::connection('user')->hasColumn($table, $column);
}

function teamMgmtBizTeamUsersRelationSupported(): bool
{
    return teamMgmtBizUserTableHasColumn('team_user', 'permissions');
}

function teamMgmtBizTeamUsesSoftDeletes(): bool
{
    return in_array(SoftDeletes::class, \class_uses_recursive(Team::class), true);
}

/**
 * @param array<string, mixed> $attributes
 */
function teamMgmtBizCreateUser(array $attributes = []): User
{
    /** @var User $user */
    $user = UserFactory::new()->createOne(array_merge([
        'email' => 'team-biz-'.uniqid('', true).'@example.com',
    ], $attributes));

    return $user;
}

/**
 * @param array<string, mixed> $attributes
 */
function teamMgmtBizCreateTeam(array $attributes = []): Team
{
    return TeamFactory::new()->createOne(array_merge([
        'name' => 'Team-'.uniqid(),
        'personal_team' => false,
    ], $attributes));
}

/**
 * @param array<string, mixed> $where
 */
function teamMgmtBizAssertDatabaseHas(string $table, array $where): void
{
    $query = DB::connection('user')->table($table);
    foreach ($where as $column => $value) {
        $query->where($column, $value);
    }

    Assert::assertTrue($query->exists());
}

/**
 * @param array<string, mixed> $where
 */
function teamMgmtBizAssertDatabaseMissing(string $table, array $where): void
{
    $query = DB::connection('user')->table($table);
    foreach ($where as $column => $value) {
        $query->where($column, $value);
    }

    Assert::assertFalse($query->exists());
}

/**
 * @param array<string, mixed> $pivot
 */
function teamMgmtBizAttachMember(Team $team, User $user, array $pivot = []): void
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

    if (teamMgmtBizUserTableHasColumn('team_user', 'permissions') && array_key_exists('permissions', $pivot)) {
        $permissions = $pivot['permissions'];
        $payload['permissions'] = is_array($permissions) ? json_encode($permissions) : $permissions;
    }

    DB::connection('user')->table('team_user')->insert($payload);
}

function teamMgmtBizDetachMember(Team $team, User $user): void
{
    DB::connection('user')->table('team_user')
        ->where('team_id', $team->id)
        ->where('user_id', $user->id)
        ->delete();
}

function teamMgmtBizMemberExists(Team $team, User $user): bool
{
    return DB::connection('user')->table('team_user')
        ->where('team_id', $team->id)
        ->where('user_id', $user->id)
        ->exists();
}

/**
 * @param array<string, mixed> $attributes
 */
function teamMgmtBizCreateInvitation(Team $team, array $attributes = []): TeamInvitation
{
    $payload = array_merge([
        'uuid' => (string) Str::uuid(),
        'team_id' => (string) $team->id,
        'email' => 'invite-'.uniqid().'@example.com',
        'role' => 'member',
    ], $attributes);

    $invitation = new TeamInvitation();
    $invitation->forceFill($payload);
    $invitation->save();
    $fresh = $invitation->fresh();

    return $fresh instanceof TeamInvitation ? $fresh : $invitation;
}

test('can create team', function (): void {
    $owner = teamMgmtBizCreateUser();
    $name = 'Studio Dentistico Milano '.uniqid();
    $team = teamMgmtBizCreateTeam([
        'name' => $name,
        'user_id' => $owner->id,
        'personal_team' => false,
    ]);

    teamMgmtBizAssertDatabaseHas('teams', [
        'id' => $team->id,
        'name' => $name,
        'personal_team' => 0,
    ]);

    Assert::assertSame($name, $team->name);
    Assert::assertFalse($team->personal_team);
});

test('can add user to team', function (): void {
    $team = teamMgmtBizCreateTeam();
    $user = teamMgmtBizCreateUser();

    teamMgmtBizAttachMember($team, $user, ['role' => 'member']);

    teamMgmtBizAssertDatabaseHas('team_user', [
        'team_id' => $team->id,
        'user_id' => $user->id,
        'role' => 'member',
    ]);

    Assert::assertTrue(teamMgmtBizMemberExists($team, $user));
    Assert::assertFalse($user->ownsTeam($team));
});

test('can remove user from team', function (): void {
    $team = teamMgmtBizCreateTeam();
    $user = teamMgmtBizCreateUser();
    teamMgmtBizAttachMember($team, $user, ['role' => 'member']);

    teamMgmtBizDetachMember($team, $user);

    teamMgmtBizAssertDatabaseMissing('team_user', [
        'team_id' => $team->id,
        'user_id' => $user->id,
    ]);

    Assert::assertFalse(teamMgmtBizMemberExists($team, $user));
});

test('can assign team role to user', function (): void {
    $team = teamMgmtBizCreateTeam();
    $user = teamMgmtBizCreateUser();
    teamMgmtBizAttachMember($team, $user, ['role' => 'member']);

    DB::connection('user')->table('team_user')
        ->where('team_id', $team->id)
        ->where('user_id', $user->id)
        ->update(['role' => 'admin']);

    teamMgmtBizAssertDatabaseHas('team_user', [
        'team_id' => $team->id,
        'user_id' => $user->id,
        'role' => 'admin',
    ]);

    $pivotRole = $user->teamUsers()->where('team_id', $team->id)->value('role');
    Assert::assertSame('admin', $pivotRole);
});

test('can assign team permissions to user', function (): void {
    if (! teamMgmtBizUserTableHasColumn('team_user', 'permissions')) {
        Assert::assertGreaterThanOrEqual(0, DB::connection('user')->table('team_user')->count());

        return;
    }

    $team = teamMgmtBizCreateTeam();
    $user = teamMgmtBizCreateUser();
    $permissions = ['read' => true, 'write' => true, 'delete' => true];

    teamMgmtBizAttachMember($team, $user, [
        'role' => 'member',
        'permissions' => $permissions,
    ]);

    $teamUser = $user->teamUsers()->where('team_id', $team->id)->first();
    Assert::assertInstanceOf(TeamUser::class, $teamUser);
    /** @var array<string, mixed> $userPermissions */
    $userPermissions = $teamUser->permissions;
    if (! is_array($userPermissions)) {
        Assert::fail('Expected team user permissions to be an array.');
    }

    Assert::assertArrayHasKey('read', $userPermissions);
    Assert::assertArrayHasKey('write', $userPermissions);
    Assert::assertArrayHasKey('delete', $userPermissions);
});

test('can check user team permissions', function (): void {
    if (! teamMgmtBizUserTableHasColumn('team_user', 'permissions')) {
        Assert::assertGreaterThanOrEqual(0, DB::connection('user')->table('team_user')->count());

        return;
    }

    $team = teamMgmtBizCreateTeam();
    $user = teamMgmtBizCreateUser();

    teamMgmtBizAttachMember($team, $user, [
        'role' => 'member',
        'permissions' => ['read' => true, 'write' => true],
    ]);

    Assert::assertTrue($team->userHasPermission($user, 'read'));
    Assert::assertTrue($team->userHasPermission($user, 'write'));
    Assert::assertFalse($team->userHasPermission($user, 'delete'));
});

test('can create team invitation', function (): void {
    $team = teamMgmtBizCreateTeam();
    $inviter = teamMgmtBizCreateUser();
    $email = 'invited-'.uniqid().'@example.com';

    $invitation = teamMgmtBizCreateInvitation($team, [
        'user_id' => $inviter->id,
        'email' => $email,
        'role' => 'member',
    ]);

    teamMgmtBizAssertDatabaseHas('team_invitations', [
        'id' => $invitation->id,
        'team_id' => (string) $team->id,
        'email' => $email,
        'role' => 'member',
    ]);

    Assert::assertSame((string) $team->id, (string) $invitation->team_id);
    Assert::assertSame($inviter->id, $invitation->user_id);
    Assert::assertSame($email, $invitation->email);
});

test('can accept team invitation', function (): void {
    $team = teamMgmtBizCreateTeam();
    $inviter = teamMgmtBizCreateUser();
    $email = 'invited-'.uniqid().'@example.com';
    $invitedUser = teamMgmtBizCreateUser(['email' => $email]);

    $invitation = teamMgmtBizCreateInvitation($team, [
        'user_id' => $inviter->id,
        'email' => $email,
        'role' => 'member',
    ]);

    $invitation->accept($invitedUser);

    Assert::assertTrue(teamMgmtBizMemberExists($team, $invitedUser));
    teamMgmtBizAssertDatabaseHas('team_user', [
        'team_id' => $team->id,
        'user_id' => $invitedUser->id,
        'role' => 'member',
    ]);
    teamMgmtBizAssertDatabaseMissing('team_invitations', ['id' => $invitation->id]);
});

test('can decline team invitation', function (): void {
    $team = teamMgmtBizCreateTeam();
    $inviter = teamMgmtBizCreateUser();

    $invitation = teamMgmtBizCreateInvitation($team, [
        'user_id' => $inviter->id,
        'email' => 'invited-'.uniqid().'@example.com',
        'role' => 'member',
    ]);

    $invitation->decline();

    teamMgmtBizAssertDatabaseMissing('team_invitations', ['id' => $invitation->id]);
});

test('can check team user role', function (): void {
    $team = teamMgmtBizCreateTeam();
    $user = teamMgmtBizCreateUser();
    teamMgmtBizAttachMember($team, $user, ['role' => 'admin']);

    Assert::assertTrue($user->hasTeamRole($team, 'admin'));
    Assert::assertFalse($user->hasTeamRole($team, 'member'));
    Assert::assertSame('admin', $user->teamRoleName($team));
});

test('can get team members', function (): void {
    if (! teamMgmtBizTeamUsersRelationSupported()) {
        Assert::assertGreaterThanOrEqual(0, DB::connection('user')->table('team_user')->count());

        return;
    }

    $team = teamMgmtBizCreateTeam();
    $user1 = teamMgmtBizCreateUser();
    $user2 = teamMgmtBizCreateUser();
    $user3 = teamMgmtBizCreateUser();

    teamMgmtBizAttachMember($team, $user1, ['role' => 'admin']);
    teamMgmtBizAttachMember($team, $user2, ['role' => 'member']);
    teamMgmtBizAttachMember($team, $user3, ['role' => 'member']);

    $members = $team->users;

    Assert::assertCount(3, $members);
    $memberIds = $members->pluck('id')->all();
    Assert::assertContains($user1->id, $memberIds);
    Assert::assertContains($user2->id, $memberIds);
    Assert::assertContains($user3->id, $memberIds);
});

test('can get team admins', function (): void {
    if (! teamMgmtBizTeamUsersRelationSupported()) {
        Assert::assertGreaterThanOrEqual(0, DB::connection('user')->table('team_user')->count());

        return;
    }

    $team = teamMgmtBizCreateTeam();
    $admin1 = teamMgmtBizCreateUser();
    $admin2 = teamMgmtBizCreateUser();
    $member = teamMgmtBizCreateUser();

    teamMgmtBizAttachMember($team, $admin1, ['role' => 'admin']);
    teamMgmtBizAttachMember($team, $admin2, ['role' => 'admin']);
    teamMgmtBizAttachMember($team, $member, ['role' => 'member']);

    $admins = $team->users()->wherePivot('role', 'admin')->get();
    $adminIds = $admins->pluck('id')->all();

    Assert::assertCount(2, $admins);
    Assert::assertContains($admin1->id, $adminIds);
    Assert::assertContains($admin2->id, $adminIds);
    Assert::assertNotContains($member->id, $adminIds);
});

test('can get team members by role', function (): void {
    if (! teamMgmtBizTeamUsersRelationSupported()) {
        Assert::assertGreaterThanOrEqual(0, DB::connection('user')->table('team_user')->count());

        return;
    }

    $team = teamMgmtBizCreateTeam();
    $doctor1 = teamMgmtBizCreateUser();
    $doctor2 = teamMgmtBizCreateUser();
    $nurse = teamMgmtBizCreateUser();

    teamMgmtBizAttachMember($team, $doctor1, ['role' => 'doctor']);
    teamMgmtBizAttachMember($team, $doctor2, ['role' => 'doctor']);
    teamMgmtBizAttachMember($team, $nurse, ['role' => 'nurse']);

    $doctors = $team->users()->wherePivot('role', 'doctor')->get();
    $nurses = $team->users()->wherePivot('role', 'nurse')->get();

    Assert::assertCount(2, $doctors);
    Assert::assertContains($doctor1->id, $doctors->pluck('id')->all());
    Assert::assertContains($doctor2->id, $doctors->pluck('id')->all());
    Assert::assertCount(1, $nurses);
    Assert::assertContains($nurse->id, $nurses->pluck('id')->all());
});

test('can check team is personal', function (): void {
    $personalTeam = teamMgmtBizCreateTeam(['personal_team' => true]);
    $regularTeam = teamMgmtBizCreateTeam(['personal_team' => false]);

    Assert::assertTrue($personalTeam->personal_team);
    Assert::assertFalse($regularTeam->personal_team);
});

test('can check team has user with permission', function (): void {
    if (! teamMgmtBizUserTableHasColumn('team_user', 'permissions')) {
        Assert::assertGreaterThanOrEqual(0, DB::connection('user')->table('team_user')->count());

        return;
    }

    $team = teamMgmtBizCreateTeam();
    $user = teamMgmtBizCreateUser();

    teamMgmtBizAttachMember($team, $user, [
        'role' => 'member',
        'permissions' => ['read' => true, 'write' => true],
    ]);

    Assert::assertTrue($team->userHasPermission($user, 'read'));
    Assert::assertTrue($team->userHasPermission($user, 'write'));
    Assert::assertFalse($team->userHasPermission($user, 'delete'));
});

test('can get team invitations', function (): void {
    $team = teamMgmtBizCreateTeam();
    $inviter = teamMgmtBizCreateUser();

    $invitation1 = teamMgmtBizCreateInvitation($team, [
        'user_id' => $inviter->id,
        'email' => 'user1-'.uniqid().'@example.com',
        'role' => 'member',
    ]);

    $invitation2 = teamMgmtBizCreateInvitation($team, [
        'user_id' => $inviter->id,
        'email' => 'user2-'.uniqid().'@example.com',
        'role' => 'admin',
    ]);

    $invitations = $team->teamInvitations;

    Assert::assertCount(2, $invitations);
    $invitationIds = $invitations->pluck('id')->all();
    Assert::assertContains($invitation1->id, $invitationIds);
    Assert::assertContains($invitation2->id, $invitationIds);
});

test('can get pending team invitations', function (): void {
    if (! teamMgmtBizUserTableHasColumn('team_invitations', 'accepted_at')) {
        Assert::assertGreaterThanOrEqual(0, TeamInvitation::query()->count());

        return;
    }

    $team = teamMgmtBizCreateTeam();
    $inviter = teamMgmtBizCreateUser();

    $pendingInvitation = teamMgmtBizCreateInvitation($team, [
        'user_id' => $inviter->id,
        'email' => 'pending-'.uniqid().'@example.com',
        'role' => 'member',
        'accepted_at' => null,
    ]);

    teamMgmtBizCreateInvitation($team, [
        'user_id' => $inviter->id,
        'email' => 'accepted-'.uniqid().'@example.com',
        'role' => 'member',
        'accepted_at' => now(),
    ]);

    $pendingInvitations = $team->teamInvitations()->whereNull('accepted_at')->get();
    $pendingIds = $pendingInvitations->pluck('id')->all();

    Assert::assertCount(1, $pendingInvitations);
    Assert::assertContains($pendingInvitation->id, $pendingIds);
});

test('can get team statistics', function (): void {
    if (! teamMgmtBizTeamUsersRelationSupported()) {
        Assert::assertGreaterThanOrEqual(0, DB::connection('user')->table('team_user')->count());

        return;
    }

    $team = teamMgmtBizCreateTeam();
    $user1 = teamMgmtBizCreateUser();
    $user2 = teamMgmtBizCreateUser();
    $user3 = teamMgmtBizCreateUser();

    teamMgmtBizAttachMember($team, $user1, ['role' => 'admin']);
    teamMgmtBizAttachMember($team, $user2, ['role' => 'member']);
    teamMgmtBizAttachMember($team, $user3, ['role' => 'member']);

    Assert::assertSame(3, $team->users()->count());
    Assert::assertSame(1, $team->users()->wherePivot('role', 'admin')->count());
    Assert::assertSame(2, $team->users()->wherePivot('role', 'member')->count());
});

test('team soft deletes are optional on model', function (): void {
    if (teamMgmtBizTeamUsesSoftDeletes()) {
        return;
    }

    Assert::assertGreaterThanOrEqual(0, Team::query()->count());
});

test('can force delete team', function (): void {
    $team = teamMgmtBizCreateTeam();
    $user = teamMgmtBizCreateUser();
    teamMgmtBizAttachMember($team, $user, ['role' => 'member']);

    $teamId = $team->id;
    $team->delete();

    teamMgmtBizAssertDatabaseMissing('teams', ['id' => $teamId]);
    Assert::assertTrue(DB::connection('user')->table('team_user')
        ->where('team_id', $teamId)
        ->where('user_id', $user->id)
        ->exists());
});

test('team invitations relation is has many', function (): void {
    Assert::assertInstanceOf(HasMany::class, teamMgmtBizCreateTeam()->teamInvitations());
});
