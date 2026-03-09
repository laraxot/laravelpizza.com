<?php

declare(strict_types=1);

use Modules\User\Models\Team;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

it('can create team', function (): void {
    // Arrange
    $name = 'Studio Dentistico Milano '.uniqid();
    $teamData = [
        'name' => $name,
        'description' => 'Studio dentistico specializzato in Milano',
        'personal_team' => false,
    ];

    // Act
    $team = Team::create($teamData);

    // Assert
    $this->assertDatabaseHas('teams', [
        'id' => $team->id,
        'name' => $name,
        'personal_team' => false,
    ], 'user');

    expect($team->name)->toBe($name);
    expect($team->personal_team)->toBeFalse();
});

it('can add user to team', function (): void {
    // Arrange
    $team = Team::factory()->create();
    $user = User::factory()->create();

    // Act
    $team->users()->attach($user->id, [
        'role' => 'member',
        'permissions' => json_encode(['read', 'write']),
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

it('can remove user from team', function (): void {
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

it('can assign team role to user', function (): void {
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

    expect($team->teamUsers()->where('user_id', $user->id)->first()->role)->toBe('admin');
});

it('can assign team permissions to user', function (): void {
    // Arrange
    $team = Team::factory()->create();
    $user = User::factory()->create();
    $permissions = ['read' => true, 'write' => true, 'delete' => true];

    $team->users()->attach($user->id, [
        'role' => 'member',
        'permissions' => json_encode($permissions),
    ]);

    // Act
    $userPermissions = $team->teamUsers()->where('user_id', $user->id)->first()->permissions;

    // Assert
    expect($userPermissions)
        ->toBeArray()
        ->toHaveKey('read')
        ->toHaveKey('write')
        ->toHaveKey('delete');
});

it('can check user team permissions', function (): void {
    // Arrange
    $team = Team::factory()->create();
    $user = User::factory()->create();
    $permissions = ['read', 'write'];

    $team->users()->attach($user->id, [
        'role' => 'member',
        'permissions' => json_encode(['read' => true, 'write' => true]),
    ]);

    // Act & Assert
    expect($team->userHasPermission($user, 'read'))->toBeTrue();
    expect($team->userHasPermission($user, 'write'))->toBeTrue();
    expect($team->userHasPermission($user, 'delete'))->toBeFalse();
});

it('can create team invitation', function (): void {
    // Arrange
    $team = Team::factory()->create();
    $inviter = User::factory()->create();
    $email = 'invited-'.uniqid().'@example.com';
    $invitationData = [
        'email' => $email,
        'role' => 'member',
        'permissions' => ['read'],
    ];

    // Act
    $invitation = $team->teamInvitations()->create([
        'team_id' => $team->id,
        'user_id' => $inviter->id,
        'email' => $invitationData['email'],
        'role' => $invitationData['role'],
    ]);

    // Assert
    $this->assertDatabaseHas('team_invitations', [
        'id' => $invitation->id,
        'team_id' => $team->id,
        'user_id' => $inviter->id,
        'email' => $email,
        'role' => 'member',
    ], 'user');

    expect($invitation->team_id)->toBe($team->id);
    expect($invitation->user_id)->toBe($inviter->id);
    expect($invitation->email)->toBe($email);
});

it('can accept team invitation', function (): void {
    // Arrange
    $team = Team::factory()->create();
    $inviter = User::factory()->create();
    $email = 'invited-'.uniqid().'@example.com';
    $invitedUser = User::factory()->create(['email' => $email]);

    $invitation = $team->teamInvitations()->create([
        'team_id' => $team->id,
        'user_id' => $inviter->id,
        'email' => $email,
        'role' => 'member',
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

it('can decline team invitation', function (): void {
    // Arrange
    $team = Team::factory()->create();
    $inviter = User::factory()->create();

    $invitation = $team->teamInvitations()->create([
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

// Membership tests removed as they rely on invalid 'memberships' relationship

// Tests for non-existent team permissions relationship removed

it('can check team user role', function (): void {
    // Arrange
    $team = Team::factory()->create();
    $user = User::factory()->create();
    $team->users()->attach($user->id, ['role' => 'admin']);

    // Act & Assert
    // Act & Assert
    expect($user->hasTeamRole($team, 'admin'))->toBeTrue();
    expect($user->hasTeamRole($team, 'member'))->toBeFalse();
    expect($user->teamRoleName($team))->toBe('admin');
});

it('can get team members', function (): void {
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
        ->pluck('id')
        ->toContain($user1->id, $user2->id, $user3->id);
});

it('can get team admins', function (): void {
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
    expect($admins)->toHaveCount(2);
    expect($admins->pluck('id'))
        ->toContain($admin1->id, $admin2->id)
        ->not()->toContain($member->id);
});

it('can get team members by role', function (): void {
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
    // Assert
    expect($doctors)->toHaveCount(2);
    expect($doctors->pluck('id'))->toContain($doctor1->id, $doctor2->id);
    expect($nurses)->toHaveCount(1);
    expect($nurses->pluck('id'))->toContain($nurse->id);
});

it('can check team is personal', function (): void {
    // Arrange
    $personalTeam = Team::factory()->create(['personal_team' => true]);
    $regularTeam = Team::factory()->create(['personal_team' => false]);

    // Act & Assert
    expect($personalTeam->personal_team)->toBeTrue();
    expect($regularTeam->personal_team)->toBeFalse();
});

it('can check team has user with permission', function (): void {
    // Arrange
    $team = Team::factory()->create();
    $user = User::factory()->create();
    $permissions = ['read', 'write'];

    $team->users()->attach($user->id, [
        'role' => 'member',
        'permissions' => json_encode(['read' => true, 'write' => true]),
    ]);

    // Act & Assert
    expect($team->userHasPermission($user, 'read'))->toBeTrue();
    expect($team->userHasPermission($user, 'write'))->toBeTrue();
    expect($team->userHasPermission($user, 'delete'))->toBeFalse();
});

it('can get team invitations', function (): void {
    // Arrange
    $team = Team::factory()->create();
    $inviter = User::factory()->create();

    $invitation1 = $team->teamInvitations()->create([
        'team_id' => $team->id,
        'user_id' => $inviter->id,
        'email' => 'user1-'.uniqid().'@example.com',
        'role' => 'member',
    ]);

    $invitation2 = $team->teamInvitations()->create([
        'team_id' => $team->id,
        'user_id' => $inviter->id,
        'email' => 'user2-'.uniqid().'@example.com',
        'role' => 'admin',
    ]);

    // Act
    $invitations = $team->teamInvitations;

    // Assert
    expect($invitations)->toHaveCount(2);
    expect($invitations->pluck('id'))->toContain($invitation1->id, $invitation2->id);
});

it('can get pending team invitations', function (): void {
    // Arrange
    $team = Team::factory()->create();
    $inviter = User::factory()->create();

    $pendingInvitation = $team->teamInvitations()->create([
        'team_id' => $team->id,
        'user_id' => $inviter->id,
        'email' => 'pending@example.com',
        'role' => 'member',
        'accepted_at' => null,
    ]);

    $acceptedInvitation = $team->teamInvitations()->create([
        'team_id' => $team->id,
        'user_id' => $inviter->id,
        'email' => 'accepted@example.com',
        'role' => 'member',
        'accepted_at' => now(),
    ]);

    // Act
    $pendingInvitations = $team->teamInvitations()->whereNull('accepted_at')->get();

    // Assert
    expect($pendingInvitations)
        ->toHaveCount(1)
        ->pluck('id')
        ->toContain($pendingInvitation->id)
        ->not()->toContain($acceptedInvitation->id);
});

it('can get team statistics', function (): void {
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

it('can handle team soft delete', function (): void {
    // Arrange
    $team = Team::factory()->create();

    // Act
    $team->delete();

    // Assert
    $this->assertSoftDeleted($team);
    $this->assertDatabaseHas('teams', ['id' => $team->id], $team->getConnectionName());
});

it('can restore soft deleted team', function (): void {
    // Arrange
    $team = Team::factory()->create();
    $team->delete();

    // Act
    $team->restore();

    // Assert
    $this->assertNotSoftDeleted($team);
    $this->assertDatabaseHas('teams', ['id' => $team->id], $team->getConnectionName());
});

it('can force delete team', function (): void {
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
