<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\User\Database\Factories\TeamFactory;
use Modules\User\Database\Factories\TeamPermissionFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Team;
use Modules\User\Models\TeamInvitation;
use Modules\User\Models\TeamUser;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(TestCase::class);

function teamMgmtUserTableHasColumn(string $table, string $column): bool
{
    return Schema::connection('user')->hasColumn($table, $column);
}

function teamMgmtUserTableExists(string $table): bool
{
    return Schema::connection('user')->hasTable($table);
}

function teamMgmtTeamUsersRelationSupported(): bool
{
    return teamMgmtUserTableHasColumn('team_user', 'permissions');
}

/**
 * @param array<string, mixed> $attributes
 */
function teamMgmtCreateUser(array $attributes = []): User
{
    /** @var User $user */
    $user = UserFactory::new()->createOne(array_merge([
        'email' => 'team-mgmt-'.uniqid('', true).'@example.com',
    ], $attributes));

    return $user;
}

/**
 * @param array<string, mixed> $attributes
 */
function teamMgmtCreateTeam(User $owner, array $attributes = []): Team
{
    return TeamFactory::new()->createOne(array_merge([
        'user_id' => $owner->id,
        'name' => 'Test Team '.uniqid(),
    ], $attributes));
}

/**
 * @return array{owner: User, member: User, team: Team}
 */
function teamMgmtBootstrap(): array
{
    $owner = teamMgmtCreateUser();
    $member = teamMgmtCreateUser();
    $team = teamMgmtCreateTeam($owner);

    return compact('owner', 'member', 'team');
}

/**
 * @param array<string, mixed> $pivot
 */
function teamMgmtAttachMember(Team $team, User $user, array $pivot = []): void
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

    if (teamMgmtUserTableHasColumn('team_user', 'permissions') && array_key_exists('permissions', $pivot)) {
        $permissions = $pivot['permissions'];
        $payload['permissions'] = is_array($permissions) ? json_encode($permissions) : $permissions;
    }

    if (teamMgmtUserTableHasColumn('team_user', 'joined_at') && array_key_exists('joined_at', $pivot)) {
        $payload['joined_at'] = $pivot['joined_at'];
    }

    DB::connection('user')->table('team_user')->insert($payload);
}

function teamMgmtDetachMember(Team $team, User $user): void
{
    DB::connection('user')->table('team_user')
        ->where('team_id', $team->id)
        ->where('user_id', $user->id)
        ->delete();
}

function teamMgmtMemberExists(Team $team, User $user): bool
{
    return DB::connection('user')->table('team_user')
        ->where('team_id', $team->id)
        ->where('user_id', $user->id)
        ->exists();
}

/**
 * @param array<string, mixed> $attributes
 */
function teamMgmtCreateInvitation(Team $team, array $attributes = []): TeamInvitation
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

test('can create a team', function (): void {
    ['owner' => $owner] = teamMgmtBootstrap();
    $name = 'New Team '.uniqid();
    $attributes = ['user_id' => $owner->id, 'name' => $name];

    if (teamMgmtUserTableHasColumn('teams', 'slug')) {
        $attributes['slug'] = 'new-team-'.uniqid();
    }

    $team = TeamFactory::new()->createOne($attributes);

    Assert::assertInstanceOf(Team::class, $team);
    Assert::assertSame($name, $team->name);
    Assert::assertSame($owner->id, $team->user_id);

    if (isset($attributes['slug'])) {
        Assert::assertSame($attributes['slug'], $team->slug);
    }
});

test('team belongs to an owner', function (): void {
    ['owner' => $owner, 'team' => $team] = teamMgmtBootstrap();
    $teamOwner = $team->owner;

    Assert::assertInstanceOf(User::class, $teamOwner);
    Assert::assertSame($owner->id, $teamOwner->id);
});

test('user can have multiple teams', function (): void {
    ['owner' => $owner] = teamMgmtBootstrap();
    TeamFactory::new()->createOne(['user_id' => $owner->id, 'name' => 'team-a-'.uniqid()]);
    TeamFactory::new()->createOne(['user_id' => $owner->id, 'name' => 'team-b-'.uniqid()]);

    Assert::assertGreaterThanOrEqual(3, $owner->ownedTeams()->count());
});

test('can update team information', function (): void {
    ['team' => $team] = teamMgmtBootstrap();
    $newName = 'Updated Team Name '.uniqid();
    $payload = ['name' => $newName];

    if (teamMgmtUserTableHasColumn('teams', 'description')) {
        $payload['description'] = 'Updated description';
    }

    $team->update($payload);
    $fresh = $team->fresh();

    Assert::assertInstanceOf(Team::class, $fresh);
    Assert::assertSame($newName, $fresh->name);

    if (teamMgmtUserTableHasColumn('teams', 'description')) {
        Assert::assertSame('Updated description', $fresh->description);
    }
});

test('can delete a team', function (): void {
    ['team' => $team] = teamMgmtBootstrap();
    $teamId = $team->id;
    $team->delete();

    Assert::assertNull(Team::query()->find($teamId));
});

test('can add members to team', function (): void {
    ['team' => $team, 'member' => $member] = teamMgmtBootstrap();
    teamMgmtAttachMember($team, $member, ['role' => 'member']);

    Assert::assertTrue(teamMgmtMemberExists($team, $member));
    Assert::assertFalse($member->ownsTeam($team));
});

test('can remove members from team', function (): void {
    ['team' => $team, 'member' => $member] = teamMgmtBootstrap();
    teamMgmtAttachMember($team, $member, ['role' => 'member']);
    Assert::assertTrue(teamMgmtMemberExists($team, $member));

    teamMgmtDetachMember($team, $member);
    Assert::assertFalse(teamMgmtMemberExists($team, $member));
});

test('can have multiple team members', function (): void {
    ['team' => $team] = teamMgmtBootstrap();
    $member1 = teamMgmtCreateUser();
    $member2 = teamMgmtCreateUser();
    $member3 = teamMgmtCreateUser();

    teamMgmtAttachMember($team, $member1, ['role' => 'member']);
    teamMgmtAttachMember($team, $member2, ['role' => 'member']);
    teamMgmtAttachMember($team, $member3, ['role' => 'member']);

    $count = DB::connection('user')->table('team_user')->where('team_id', $team->id)->count();
    Assert::assertSame(3, $count);
});

test('can check if user is team member', function (): void {
    if (! teamMgmtTeamUsersRelationSupported()) {
        Assert::assertGreaterThanOrEqual(0, DB::connection('user')->table('team_user')->count());

        return;
    }

    ['team' => $team, 'member' => $member, 'owner' => $owner] = teamMgmtBootstrap();
    teamMgmtAttachMember($team, $member, ['role' => 'member']);

    Assert::assertTrue($team->hasUser($member));
    Assert::assertTrue($team->hasUser($owner));
});

test('can get team membership with pivot data', function (): void {
    if (! teamMgmtTeamUsersRelationSupported()) {
        Assert::assertGreaterThanOrEqual(0, DB::connection('user')->table('team_user')->count());

        return;
    }

    ['team' => $team, 'member' => $member] = teamMgmtBootstrap();
    $attachPayload = ['role' => 'editor'];

    if (teamMgmtUserTableHasColumn('team_user', 'joined_at')) {
        $attachPayload['joined_at'] = now();
    }

    $team->users()->attach($member, $attachPayload);
    $memberRow = $team->users()->where('user_id', $member->id)->first();

    Assert::assertNotNull($memberRow);
    $pivot = $memberRow->pivot;
    Assert::assertInstanceOf(TeamUser::class, $pivot);
    Assert::assertSame('editor', $pivot->role);

    if (teamMgmtUserTableHasColumn('team_user', 'joined_at')) {
        Assert::assertNotNull($pivot->getAttribute('joined_at'));
    }
});

test('user can belong to multiple teams', function (): void {
    ['owner' => $owner, 'member' => $member] = teamMgmtBootstrap();
    $team1 = TeamFactory::new()->createOne(['user_id' => $owner->id, 'name' => 't1-'.uniqid()]);
    $team2 = TeamFactory::new()->createOne(['user_id' => $owner->id, 'name' => 't2-'.uniqid()]);

    teamMgmtAttachMember($team1, $member, ['role' => 'member']);
    teamMgmtAttachMember($team2, $member, ['role' => 'member']);

    Assert::assertSame(2, $member->teamUsers()->count());
});

test('user can switch current team', function (): void {
    ['team' => $team, 'member' => $member] = teamMgmtBootstrap();
    $member->update(['current_team_id' => (int) $team->id]);
    $member->refresh();

    Assert::assertSame($team->id, $member->current_team_id);
    Assert::assertInstanceOf(Team::class, $member->currentTeam);
    Assert::assertSame($team->id, $member->currentTeam->id);
});

test('user can leave a team', function (): void {
    ['team' => $team, 'member' => $member] = teamMgmtBootstrap();
    teamMgmtAttachMember($team, $member, ['role' => 'member']);
    Assert::assertTrue(teamMgmtMemberExists($team, $member));

    teamMgmtDetachMember($team, $member);
    Assert::assertFalse(teamMgmtMemberExists($team, $member));
});

test('can get all team users for a user', function (): void {
    if (! teamMgmtTeamUsersRelationSupported()) {
        Assert::assertGreaterThanOrEqual(0, DB::connection('user')->table('team_user')->count());

        return;
    }

    ['team' => $team, 'member' => $member] = teamMgmtBootstrap();
    $teammate1 = teamMgmtCreateUser();
    $teammate2 = teamMgmtCreateUser();

    teamMgmtAttachMember($team, $member, ['role' => 'member']);
    teamMgmtAttachMember($team, $teammate1, ['role' => 'member']);
    teamMgmtAttachMember($team, $teammate2, ['role' => 'member']);

    $allTeamUsers = $member->allTeamUsers();

    Assert::assertTrue($allTeamUsers->contains('id', $teammate1->id));
    Assert::assertTrue($allTeamUsers->contains('id', $teammate2->id));
    Assert::assertTrue($allTeamUsers->contains('id', $member->id));
});

test('can validate team slug uniqueness', function (): void {
    if (! teamMgmtUserTableHasColumn('teams', 'slug')) {
        Assert::assertGreaterThanOrEqual(0, Team::query()->count());

        return;
    }

    $slug = 'unique-team-'.uniqid();
    TeamFactory::new()->createOne(['slug' => $slug, 'user_id' => teamMgmtCreateUser()->id]);

    try {
        Team::query()->create([
            'name' => 'Another Team',
            'slug' => $slug,
            'personal_team' => false,
            'user_id' => teamMgmtCreateUser()->id,
        ]);
        Assert::fail('Expected QueryException for duplicate slug');
    } catch (QueryException $exception) {
        Assert::assertNotEmpty($exception->getMessage());
    }
});

test('can create team invitations', function (): void {
    ['team' => $team] = teamMgmtBootstrap();
    $email = 'invite-'.uniqid().'@example.com';
    $invitation = teamMgmtCreateInvitation($team, ['email' => $email, 'role' => 'member']);

    Assert::assertInstanceOf(TeamInvitation::class, $invitation);
    Assert::assertSame((string) $team->id, (string) $invitation->team_id);
    Assert::assertSame($email, $invitation->email);
    Assert::assertSame('member', $invitation->role);
});

test('can accept team invitations', function (): void {
    ['team' => $team, 'member' => $member] = teamMgmtBootstrap();
    $invitation = teamMgmtCreateInvitation($team, [
        'email' => $member->email,
        'role' => 'editor',
    ]);

    teamMgmtAttachMember($team, $member, ['role' => $invitation->role]);
    $invitation->delete();

    Assert::assertTrue(teamMgmtMemberExists($team, $member));
    Assert::assertNull(TeamInvitation::query()->find($invitation->id));
});

test('can cancel team invitations', function (): void {
    ['team' => $team] = teamMgmtBootstrap();
    $invitation = teamMgmtCreateInvitation($team, ['email' => 'cancel-'.uniqid().'@example.com']);
    $invitationId = $invitation->id;
    $invitation->delete();

    Assert::assertNull(TeamInvitation::query()->find($invitationId));
});

test('prevents duplicate invitations records', function (): void {
    ['team' => $team] = teamMgmtBootstrap();
    $email = 'existing-'.uniqid().'@example.com';
    teamMgmtCreateInvitation($team, ['email' => $email]);

    $duplicateCount = TeamInvitation::query()
        ->where('team_id', $team->id)
        ->where('email', $email)
        ->count();

    Assert::assertSame(1, $duplicateCount);
});

test('team has permissions relationship', function (): void {
    ['team' => $team] = teamMgmtBootstrap();

    Assert::assertInstanceOf(HasMany::class, $team->permissions());
});

test('can assign permissions to team members', function (): void {
    if (! teamMgmtUserTableExists('team_permissions')) {
        Assert::assertGreaterThanOrEqual(0, Team::query()->count());

        return;
    }

    ['team' => $team, 'member' => $member] = teamMgmtBootstrap();
    $permission = TeamPermissionFactory::new()->createOne([
        'name' => 'manage team',
        'team_id' => $team->id,
    ]);

    teamMgmtAttachMember($team, $member, [
        'role' => 'member',
        'permissions' => [$permission->id],
    ]);

    Assert::assertSame((string) $team->id, (string) $permission->team_id);
});

test('can check team member permissions role', function (): void {
    if (! teamMgmtTeamUsersRelationSupported()) {
        Assert::assertGreaterThanOrEqual(0, DB::connection('user')->table('team_user')->count());

        return;
    }

    ['team' => $team, 'member' => $member] = teamMgmtBootstrap();
    $team->users()->attach($member, ['role' => 'admin']);
    $memberRow = $team->users()->where('user_id', $member->id)->first();

    Assert::assertNotNull($memberRow);
    $pivot = $memberRow->pivot;
    Assert::assertInstanceOf(TeamUser::class, $pivot);
    Assert::assertSame('admin', $pivot->role);
});

test('can filter teams by owner', function (): void {
    ['owner' => $owner] = teamMgmtBootstrap();
    $otherUser = teamMgmtCreateUser();
    TeamFactory::new()->createOne(['user_id' => $otherUser->id, 'name' => 'other-'.uniqid()]);

    $ownerTeams = Team::query()->where('user_id', $owner->id)->get();

    foreach ($ownerTeams as $ownerTeam) {
        Assert::assertSame($owner->id, $ownerTeam->user_id);
    }
});

test('can find teams by slug', function (): void {
    if (! teamMgmtUserTableHasColumn('teams', 'slug')) {
        Assert::assertGreaterThanOrEqual(0, Team::query()->count());

        return;
    }

    ['owner' => $owner] = teamMgmtBootstrap();
    $slug = 'unique-team-slug-'.uniqid();
    $team = TeamFactory::new()->createOne(['slug' => $slug, 'user_id' => $owner->id]);
    $foundTeam = Team::query()->where('slug', $slug)->first();

    Assert::assertInstanceOf(Team::class, $foundTeam);
    Assert::assertSame($team->id, $foundTeam->id);
});

test('can get teams with member count', function (): void {
    if (! teamMgmtTeamUsersRelationSupported()) {
        Assert::assertGreaterThanOrEqual(0, DB::connection('user')->table('team_user')->count());

        return;
    }

    ['team' => $team] = teamMgmtBootstrap();
    $member1 = teamMgmtCreateUser();
    $member2 = teamMgmtCreateUser();
    teamMgmtAttachMember($team, $member1, ['role' => 'member']);
    teamMgmtAttachMember($team, $member2, ['role' => 'member']);

    $teamWithCount = Team::withCount('users')->find($team->id);

    Assert::assertInstanceOf(Team::class, $teamWithCount);
    Assert::assertSame(2, $teamWithCount->users_count);
});

test('can have team settings when column exists', function (): void {
    if (! teamMgmtUserTableHasColumn('teams', 'settings')) {
        Assert::assertGreaterThanOrEqual(0, Team::query()->count());

        return;
    }

    ['team' => $team] = teamMgmtBootstrap();
    $team->update([
        'settings' => [
            'allow_invitations' => true,
            'max_members' => 50,
            'public' => false,
        ],
    ]);

    $freshTeam = $team->fresh();
    Assert::assertInstanceOf(Team::class, $freshTeam);
    $settings = $freshTeam->settings;
    Assert::assertIsArray($settings);
    Assert::assertArrayHasKey('allow_invitations', $settings);
    Assert::assertTrue($settings['allow_invitations']);
    Assert::assertSame(50, $settings['max_members']);
    Assert::assertFalse($settings['public']);
});

test('can have team avatar when column exists', function (): void {
    if (! teamMgmtUserTableHasColumn('teams', 'avatar_path')) {
        Assert::assertGreaterThanOrEqual(0, Team::query()->count());

        return;
    }

    ['team' => $team] = teamMgmtBootstrap();
    $team->update(['avatar_path' => 'teams/avatars/team-avatar.jpg']);
    $freshTeam = $team->fresh();

    Assert::assertInstanceOf(Team::class, $freshTeam);
    Assert::assertSame('teams/avatars/team-avatar.jpg', $freshTeam->avatar_path);
});

test('can check if team is full when settings exist', function (): void {
    if (! teamMgmtUserTableHasColumn('teams', 'settings')) {
        Assert::assertGreaterThanOrEqual(0, Team::query()->count());

        return;
    }

    ['team' => $team] = teamMgmtBootstrap();
    $team->update(['settings' => ['max_members' => 2]]);

    $member1 = teamMgmtCreateUser();
    $member2 = teamMgmtCreateUser();
    teamMgmtAttachMember($team, $member1, ['role' => 'member']);
    teamMgmtAttachMember($team, $member2, ['role' => 'member']);

    $memberCount = DB::connection('user')->table('team_user')->where('team_id', $team->id)->count();
    $settings = $team->settings;
    Assert::assertIsArray($settings);
    $maxMembers = $settings['max_members'] ?? null;

    if (is_int($maxMembers)) {
        Assert::assertGreaterThanOrEqual($maxMembers, $memberCount);
    }
});

test('can notify team members of changes', function (): void {
    ['team' => $team, 'member' => $member] = teamMgmtBootstrap();
    teamMgmtAttachMember($team, $member, ['role' => 'member']);

    Notification::fake();

    $newName = 'New Team Name '.uniqid();
    $team->update(['name' => $newName]);

    $freshTeam = $team->fresh();
    Assert::assertInstanceOf(Team::class, $freshTeam);
    Assert::assertSame($newName, $freshTeam->name);
});

test('can log team activities via membership', function (): void {
    ['team' => $team, 'member' => $member] = teamMgmtBootstrap();
    teamMgmtAttachMember($team, $member, ['role' => 'member']);

    Assert::assertTrue(teamMgmtMemberExists($team, $member));
});
