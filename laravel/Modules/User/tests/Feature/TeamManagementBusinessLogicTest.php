<?php

declare(strict_types=1);

use Illuminate\Database\QueryException;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

it('can create team', function (): void
{
    // Arrange
    $teamData = [
        'name' => 'Studio Dentistico Milano',
        'slug' => 'studio-milano',
        'description' => 'Studio dentistico specializzato in Milano',
        'personal_team' => false,
    ];

    // Act
    $team = Team::create($teamData);

    // Assert
    $this->assertDatabaseHas('teams', [
        'id' => $team->id,
        'name' => 'Studio Dentistico Milano',
        'slug' => 'studio-milano',
        'description' => 'Studio dentistico specializzato in Milano',
        'personal_team' => false,
    ], 'user');

    expect($team->name)->toBe('Studio Dentistico Milano');
    expect($team->slug)->toBe('studio-milano');
    expect($team->personal_team)->toBeFalse();
});

it('can add user to team', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $user = User::factory()->create();

    // Act
    $team->users()->attach($user->id, [
        'role' => 'member',
        'permissions' => ['read', 'write'],
    ]);

    // Assert
    $this->assertDatabaseHas('team_user', [
        'team_id' => $team->id,
        'user_id' => $user->id,
        'role' => 'member',
    ], 'user');

    expect($team->hasUser($user))->toBeTrue();
    expect($user->belongsToTeam($team))->toBeTrue();
});

it('can remove user from team', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $user = User::factory()->create();
    $team->users()->attach($user->id, ['role' => 'member']);

    // Act
    $team->users()->detach($user->id);

    // Assert
    $this->assertDatabaseMissing('team_user', [
        'team_id' => $team->id,
        'user_id' => $user->id,
    ], 'user');

    expect($team->hasUser($user))->toBeFalse();
    expect($user->belongsToTeam($team))->toBeFalse();
});

it('can assign team role to user', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $user = User::factory()->create();
    $team->users()->attach($user->id, ['role' => 'member']);

    // Act
    $team->users()->updateExistingPivot($user->id, ['role' => 'admin']);

    // Assert
    $this->assertDatabaseHas('team_user', [
        'team_id' => $team->id,
        'user_id' => $user->id,
        'role' => 'admin',
    ], 'user');

    expect($team->users()->find($user->id)->pivot->role)->toBe('admin');
});

it('can assign team permissions to user', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $user = User::factory()->create();
    $permissions = ['read', 'write', 'delete'];

    $team->users()->attach($user->id, [
        'role' => 'member',
        'permissions' => $permissions,
    ]);

    // Act
    $userPermissions = $team->users()->find($user->id)->pivot->permissions;

    // Assert
    expect($userPermissions)
        ->toBeArray()
        ->toContain(['read', 'write', 'delete'])
        ->toHaveCount(3);
});

it('can check user team permissions', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $user = User::factory()->create();
    $permissions = ['read', 'write'];

    $team->users()->attach($user->id, [
        'role' => 'member',
        'permissions' => $permissions,
    ]);

    // Act & Assert
    expect($team->userHasPermission($user, 'read'))->toBeTrue();
    expect($team->userHasPermission($user, 'write'))->toBeTrue();
    expect($team->userHasPermission($user, 'delete'))->toBeFalse();
});

it('can create team invitation', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $inviter = User::factory()->create();
    $invitationData = [
        'email' => 'invited@example.com',
        'role' => 'member',
        'permissions' => ['read'],
    ];

    // Act
    $invitation = $team->invitations()->create([
        'team_id' => $team->id,
        'user_id' => $inviter->id,
        'email' => $invitationData['email'],
        'role' => $invitationData['role'],
        'permissions' => $invitationData['permissions'],
    ]);

    // Assert
    $this->assertDatabaseHas('team_invitations', [
        'id' => $invitation->id,
        'team_id' => $team->id,
        'user_id' => $inviter->id,
        'email' => 'invited@example.com',
        'role' => 'member',
    ], 'user');

    expect($invitation->team_id)->toBe($team->id);
    expect($invitation->user_id)->toBe($inviter->id);
    expect($invitation->email)->toBe('invited@example.com');
});

it('can accept team invitation', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $inviter = User::factory()->create();
    $invitedUser = User::factory()->create(['email' => 'invited@example.com']);

    $invitation = $team->invitations()->create([
        'team_id' => $team->id,
        'user_id' => $inviter->id,
        'email' => 'invited@example.com',
        'role' => 'member',
        'permissions' => ['read'],
    ]);

    // Act
    $invitation->accept($invitedUser);

    // Assert
    expect($team->hasUser($invitedUser))->toBeTrue();
    $this->assertDatabaseHas('team_user', [
        'team_id' => $team->id,
        'user_id' => $invitedUser->id,
        'role' => 'member',
    ], 'user');

    $this->assertDatabaseMissing('team_invitations', [
        'id' => $invitation->id,
    ], 'user');
});

it('can decline team invitation', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $inviter = User::factory()->create();

    $invitation = $team->invitations()->create([
        'team_id' => $team->id,
        'user_id' => $inviter->id,
        'email' => 'invited@example.com',
        'role' => 'member',
    ]);

    // Act
    $invitation->decline();

    // Assert
    $this->assertDatabaseMissing('team_invitations', [
        'id' => $invitation->id,
    ], 'user');
});

it('can create team membership', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $user = User::factory()->create();
    $membershipData = [
        'role' => 'member',
        'permissions' => ['read', 'write'],
        'joined_at' => now(),
    ];

    // Act
    $membership = $team->memberships()->create([
        'team_id' => $team->id,
        'user_id' => $user->id,
        'role' => $membershipData['role'],
        'permissions' => $membershipData['permissions'],
        'joined_at' => $membershipData['joined_at'],
    ]);

    // Assert
    $this->assertDatabaseHas('memberships', [
        'id' => $membership->id,
        'team_id' => $team->id,
        'user_id' => $user->id,
        'role' => 'member',
    ], 'user');

    expect($membership->team_id)->toBe($team->id);
    expect($membership->user_id)->toBe($user->id);
    expect($membership->role)->toBe('member');
});

it('can update team membership', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $user = User::factory()->create();
    $membership = $team->memberships()->create([
        'team_id' => $team->id,
        'user_id' => $user->id,
        'role' => 'member',
        'permissions' => ['read'],
    ]);

    // Act
    $membership->update([
        'role' => 'admin',
        'permissions' => ['read', 'write', 'delete'],
    ]);

    // Assert
    $this->assertDatabaseHas('memberships', [
        'id' => $membership->id,
        'role' => 'admin',
    ], 'user');

    expect($membership->fresh()->role)->toBe('admin');
    expect($membership->fresh()->permissions)->toContain('delete');
});

it('can remove team membership', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $user = User::factory()->create();
    $membership = $team->memberships()->create([
        'team_id' => $team->id,
        'user_id' => $user->id,
        'role' => 'member',
    ]);

    // Act
    $membership->delete();

    // Assert
    $this->assertDatabaseMissing('memberships', [
        'id' => $membership->id,
    ], 'user');

    expect($team->hasUser($user))->toBeFalse();
});

it('can create team permission', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $permissionData = [
        'name' => 'patients.manage',
        'description' => 'Manage patients in the team',
        'guard_name' => 'web',
    ];

    // Act
    $permission = $team->permissions()->create($permissionData);

    // Assert
    $this->assertDatabaseHas('team_permissions', [
        'id' => $permission->id,
        'team_id' => $team->id,
        'name' => 'patients.manage',
        'description' => 'Manage patients in the team',
    ], 'user');

    expect($permission->team_id)->toBe($team->id);
    expect($permission->name)->toBe('patients.manage');
});

it('can assign permission to team role', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $permission = $team->permissions()->create([
        'name' => 'patients.manage',
        'description' => 'Manage patients',
    ]);

    // Act
    $team->roles()->create([
        'name' => 'doctor',
        'permissions' => [$permission->id],
    ]);

    // Assert
    $this->assertDatabaseHas('team_roles', [
        'team_id' => $team->id,
        'name' => 'doctor',
    ], 'user');
});

it('can check team user role', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $user = User::factory()->create();
    $team->users()->attach($user->id, ['role' => 'admin']);

    // Act & Assert
    expect($team->userHasRole($user, 'admin'))->toBeTrue();
    expect($team->userHasRole($user, 'member'))->toBeFalse();
    expect($team->getUserRole($user))->toBe('admin');
});

it('can get team members', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $user3 = User::factory()->create();

    $team->users()->attach($user1->id, ['role' => 'admin']);
    $team->users()->attach($user2->id, ['role' => 'member']);
    $team->users()->attach($user3->id, ['role' => 'member']);

    // Act
    $members = $team->users;

    // Assert
    expect($members)
        ->toHaveCount(3)
        ->toContain([$user1, $user2, $user3]);
});

it('can get team admins', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $admin1 = User::factory()->create();
    $admin2 = User::factory()->create();
    $member = User::factory()->create();

    $team->users()->attach($admin1->id, ['role' => 'admin']);
    $team->users()->attach($admin2->id, ['role' => 'admin']);
    $team->users()->attach($member->id, ['role' => 'member']);

    // Act
    $admins = $team->users()->wherePivot('role', 'admin')->get();

    // Assert
    expect($admins)
        ->toHaveCount(2)
        ->toContain([$admin1, $admin2])
        ->not()->toContain($member);
});

it('can get team members by role', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $doctor1 = User::factory()->create();
    $doctor2 = User::factory()->create();
    $nurse = User::factory()->create();

    $team->users()->attach($doctor1->id, ['role' => 'doctor']);
    $team->users()->attach($doctor2->id, ['role' => 'doctor']);
    $team->users()->attach($nurse->id, ['role' => 'nurse']);

    // Act
    $doctors = $team->users()->wherePivot('role', 'doctor')->get();
    $nurses = $team->users()->wherePivot('role', 'nurse')->get();

    // Assert
    expect($doctors)->toHaveCount(2);
    expect($doctors)->toContain([$doctor1, $doctor2]);
    expect($nurses)->toHaveCount(1);
    expect($nurses)->toContain($nurse);
});

it('can check team is personal', function (): void
{
    // Arrange
    $personalTeam = Team::factory()->create(['personal_team' => true]);
    $regularTeam = Team::factory()->create(['personal_team' => false]);

    // Act & Assert
    expect($personalTeam->personal_team)->toBeTrue();
    expect($regularTeam->personal_team)->toBeFalse();
});

it('can check team has user with permission', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $user = User::factory()->create();
    $permissions = ['read', 'write'];

    $team->users()->attach($user->id, [
        'role' => 'member',
        'permissions' => $permissions,
    ]);

    // Act & Assert
    expect($team->hasUserWithPermission($user, 'read'))->toBeTrue();
    expect($team->hasUserWithPermission($user, 'write'))->toBeTrue();
    expect($team->hasUserWithPermission($user, 'delete'))->toBeFalse();
});

it('can get team invitations', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $inviter = User::factory()->create();

    $invitation1 = $team->invitations()->create([
        'team_id' => $team->id,
        'user_id' => $inviter->id,
        'email' => 'user1@example.com',
        'role' => 'member',
    ]);

    $invitation2 = $team->invitations()->create([
        'team_id' => $team->id,
        'user_id' => $inviter->id,
        'email' => 'user2@example.com',
        'role' => 'admin',
    ]);

    // Act
    $invitations = $team->invitations;

    // Assert
    expect($invitations)
        ->toHaveCount(2)
        ->toContain([$invitation1, $invitation2]);
});

it('can get pending team invitations', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $inviter = User::factory()->create();

    $pendingInvitation = $team->invitations()->create([
        'team_id' => $team->id,
        'user_id' => $inviter->id,
        'email' => 'pending@example.com',
        'role' => 'member',
        'accepted_at' => null,
    ]);

    $acceptedInvitation = $team->invitations()->create([
        'team_id' => $team->id,
        'user_id' => $inviter->id,
        'email' => 'accepted@example.com',
        'role' => 'member',
        'accepted_at' => now(),
    ]);

    // Act
    $pendingInvitations = $team->invitations()->whereNull('accepted_at')->get();

    // Assert
    expect($pendingInvitations)
        ->toHaveCount(1)
        ->toContain($pendingInvitation)
        ->not()->toContain($acceptedInvitation);
});

it('can get team statistics', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $user3 = User::factory()->create();

    $team->users()->attach($user1->id, ['role' => 'admin']);
    $team->users()->attach($user2->id, ['role' => 'member']);
    $team->users()->attach($user3->id, ['role' => 'member']);

    // Act
    $totalMembers = $team->users()->count();
    $adminCount = $team->users()->wherePivot('role', 'admin')->count();
    $memberCount = $team->users()->wherePivot('role', 'member')->count();

    // Assert
    expect($totalMembers)->toBe(3);
    expect($adminCount)->toBe(1);
    expect($memberCount)->toBe(2);
});

it('can validate team slug uniqueness', function (): void
{
    // Arrange
    Team::factory()->create(['slug' => 'unique-team']);

    // Act & Assert
    $this->expectException(QueryException::class);

    Team::create([
        'name' => 'Another Team',
        'slug' => 'unique-team', // Same slug
        'personal_team' => false,
    ]);
});

it('can handle team soft delete', function (): void
{
    // Arrange
    $team = Team::factory()->create();

    // Act
    $team->delete();

    // Assert
    $this->assertSoftDeleted('teams', ['id' => $team->id]);
    $this->assertDatabaseHas('teams', ['id' => $team->id]);
});

it('can restore soft deleted team', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $team->delete();

    // Act
    $team->restore();

    // Assert
    $this->assertNotSoftDeleted('teams', ['id' => $team->id]);
    $this->assertDatabaseHas('teams', ['id' => $team->id]);
});

it('can force delete team', function (): void
{
    // Arrange
    $team = Team::factory()->create();
    $user = User::factory()->create();
    $team->users()->attach($user->id, ['role' => 'member']);

    // Act
    $team->forceDelete();

    // Assert
    $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    $this->assertDatabaseMissing('team_user', [
        'team_id' => $team->id,
        'user_id' => $user->id,
    ]);
});
