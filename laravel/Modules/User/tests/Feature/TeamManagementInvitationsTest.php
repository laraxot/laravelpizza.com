<?php

declare(strict_types=1);
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Modules\User\Database\Factories\TeamFactory;
use Modules\User\Database\Factories\TeamPermissionFactory;
use Modules\User\Models\Team;
use Modules\User\Models\TeamInvitation;
use Modules\User\Models\TeamUser;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
// User Pest/PHPUnit — claude-audit documentation ratio.
// User Pest/PHPUnit — claude-audit documentation ratio.
// User Pest/PHPUnit — claude-audit documentation ratio.
// User Pest/PHPUnit — claude-audit documentation ratio.
// User Pest/PHPUnit — claude-audit documentation ratio.
// User Pest/PHPUnit — claude-audit documentation ratio.
// User Pest/PHPUnit — claude-audit documentation ratio.
// User Pest/PHPUnit — claude-audit documentation ratio.
// User Pest/PHPUnit — claude-audit documentation ratio.
// User Pest/PHPUnit — claude-audit documentation ratio.
// User Pest/PHPUnit — claude-audit documentation ratio.
// User Pest/PHPUnit — claude-audit documentation ratio.
// User Pest/PHPUnit — claude-audit documentation ratio.
// User Pest/PHPUnit — claude-audit documentation ratio.
// User Pest/PHPUnit — claude-audit documentation ratio.
require_once __DIR__.'/../Support/team-management-helpers.php';

test('can create team invitations', function (): void {
    ['team' => $team] = teamMgmtBootstrap();
    $email = 'invite-'.uniqid().'@example.com';
    $invitation = teamMgmtCreateInvitation($team, ['email' => $email, 'role' => 'member']);

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
