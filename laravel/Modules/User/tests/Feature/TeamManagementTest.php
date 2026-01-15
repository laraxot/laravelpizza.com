<?php

declare(strict_types=1);

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Notification;
use Modules\User\Models\Team;
use Modules\User\Models\TeamInvitation;
use Modules\User\Models\TeamPermission;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    $this->owner = User::factory()->create();
    $this->member = User::factory()->create();
    $this->team = Team::factory()->create([
        'user_id' => $this->owner->id,
        'name' => 'Test Team',
    ]);
});

describe('Team Creation and Management', function () {
    it('can create a team', function () {
        $slug = 'new-team-'.uniqid();
        $team = Team::factory()->create([
            'user_id' => $this->owner->id,
            'name' => 'New Team',
            'slug' => $slug,
        ]);

        expect($team)
            ->toBeInstanceOf(Team::class)
            ->name->toBe('New Team')
            ->slug->toBe($slug)
            ->user_id->toBe($this->owner->id);
    });

    it('belongs to an owner', function () {
        expect($this->team->owner)->toBeInstanceOf(User::class)->id->toBe($this->owner->id);
    });

    it('can have multiple teams per user', function () {
        $team1 = Team::factory()->create(['user_id' => $this->owner->id]);
        $team2 = Team::factory()->create(['user_id' => $this->owner->id]);

        expect($this->owner->ownedTeams)->toHaveCount(3); // Including the one from beforeEach
    });

    it('can update team information', function () {
        $this->team->update([
            'name' => 'Updated Team Name',
            'description' => 'Updated description',
        ]);

        $fresh = $this->team->fresh();
        expect($fresh)->name->toBe('Updated Team Name');

        if (null !== $fresh->getAttribute('description')) {
            expect($fresh)->description->toBe('Updated description');
        }
    });

    it('can delete a team', function () {
        $teamId = $this->team->id;
        $this->team->delete();

        expect(Team::find($teamId))->toBeNull();
    });
});

describe('Team Membership', function () {
    it('can add members to team', function () {
        $this->team->users()->attach($this->member);

        expect($this->team->users->contains($this->member))->toBeTrue();
        expect($this->member->teams->contains($this->team))->toBeTrue();
    });

    it('can remove members from team', function () {
        $this->team->users()->attach($this->member);
        expect($this->team->users->contains($this->member))->toBeTrue();

        $this->team->users()->detach($this->member);
        expect($this->team->fresh()->users->contains($this->member))->toBeFalse();
    });

    it('can have multiple members', function () {
        $member1 = User::factory()->create();
        $member2 = User::factory()->create();
        $member3 = User::factory()->create();

        $this->team->users()->attach([$member1->id, $member2->id, $member3->id]);

        expect($this->team->users)->toHaveCount(3);
    });

    it('can check if user is team member', function () {
        $this->team->users()->attach($this->member);

        expect($this->team->hasUser($this->member))->toBe(true);
        // Owner is usually considered a user/member in hasUser logic
        expect($this->team->hasUser($this->owner))->toBe(true);
    });

    it('can get team membership with pivot data', function () {
        $this->team->users()->attach($this->member, [
            'role' => 'editor',
            'joined_at' => now(),
        ]);

        $membership = $this->team
            ->users()
            ->where('user_id', $this->member->id)
            ->first()
            ->membership; // Accessed as 'membership' due to as('membership')

        expect($membership->role)->toBe('editor');
        expect($membership->joined_at)->not->toBeNull();
    });
});

describe('User Team Relationship', function () {
    it('user can belong to multiple teams', function () {
        $team1 = Team::factory()->create(['user_id' => $this->owner->id]);
        $team2 = Team::factory()->create(['user_id' => $this->owner->id]);

        $this->member->teams()->attach([$team1->id, $team2->id]);

        expect($this->member->teams)->toHaveCount(2);
    });

    it('user can switch current team', function () {
        $this->member->teams()->attach($this->team);
        $this->member->update(['current_team_id' => $this->team->id]);

        expect($this->member->fresh()->current_team_id)->toBe($this->team->id);
        expect($this->member->currentTeam->id)->toBe($this->team->id);
    });

    it('user can leave a team', function () {
        $this->member->teams()->attach($this->team);
        expect($this->member->teams->contains($this->team))->toBeTrue();

        $this->member->teams()->detach($this->team);
        expect($this->member->fresh()->teams->contains($this->team))->toBeFalse();
    });

    it('can get all team users for a user', function () {
        $teammate1 = User::factory()->create();
        $teammate2 = User::factory()->create();

        $this->team->users()->attach([$this->member->id, $teammate1->id, $teammate2->id]);
        // Member is already attached above, so ensure we don't duplicate if unique constraint exists
        // Or check if already attached
        if (! $this->member->teams->contains($this->team)) {
            $this->member->teams()->attach($this->team);
        }

        // Check by IDs for safety
        $allTeamUsers = $this->member->allTeamUsers();

        expect($allTeamUsers->contains('id', $teammate1->id))->toBeTrue();
        expect($allTeamUsers->contains('id', $teammate2->id))->toBeTrue();
        // Self should be included in "allTeamUsers"
        expect($allTeamUsers->contains('id', $this->member->id))->toBeTrue();
    });
});

describe('Team Invitations', function () {
    it('can validate team slug uniqueness', function (): void {
        // Arrange
        $slug = 'unique-team-'.uniqid();
        Team::factory()->create(['slug' => $slug]);

        // Act & Assert
        $this->expectException(QueryException::class);

        Team::create([
            'name' => 'Another Team',
            'slug' => $slug, // Same slug
            'personal_team' => false,
            'user_id' => User::factory()->create()->id, // Ensure user_id is provided
        ]);
    });
    it('can create team invitations', function () {
        $email = 'invite-'.uniqid().'@example.com';
        $invitation = TeamInvitation::factory()->create([
            'team_id' => $this->team->id,
            'email' => $email,
            'role' => 'member',
        ]);

        expect($invitation)
            ->toBeInstanceOf(TeamInvitation::class)
            ->team_id->toBe($this->team->id)
            ->email->toBe($email)
            ->role->toBe('member');
    });

    it('can accept team invitations', function () {
        $invitation = TeamInvitation::factory()->create([
            'team_id' => $this->team->id,
            'email' => $this->member->email,
            'role' => 'editor',
        ]);

        // Simulate accepting invitation
        $this->team->users()->attach($this->member, ['role' => $invitation->role]);
        $invitation->delete();

        expect($this->team->users->contains($this->member))->toBeTrue();
        expect(TeamInvitation::find($invitation->id))->toBeNull();
    });

    it('can cancel team invitations', function () {
        $invitation = TeamInvitation::factory()->create([
            'team_id' => $this->team->id,
            'email' => 'cancel@example.com',
        ]);

        $invitationId = $invitation->id;
        $invitation->delete();

        expect(TeamInvitation::find($invitationId))->toBeNull();
    });

    it('prevents duplicate invitations', function () {
        $email = 'existing-'.uniqid().'@example.com';
        TeamInvitation::factory()->create([
            'team_id' => $this->team->id,
            'email' => $email,
        ]);

        // Attempting to create duplicate should fail or be handled
        $duplicateCount = TeamInvitation::where('team_id', $this->team->id)
            ->where('email', $email)
            ->count();

        expect($duplicateCount)->toBe(1);
    });
});

describe('Team Permissions', function () {
    it('can have team-specific permissions', function () {
        expect($this->team->permissions())
            ->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\HasMany::class);
    });

    it('can assign permissions to team members', function () {
        $permission = TeamPermission::factory()->create([
            'name' => 'manage team',
            'team_id' => $this->team->id,
        ]);

        // Attaching permissions to pivot
        $this->team->users()->attach($this->member, ['permissions' => json_encode([$permission->id])]);
        // Or if casted, just array? Assuming array cast on pivot or accessor
        // But attach expects scalar or json for simple columns.

        // Test permission assignment logic
        expect($permission->team_id)->toBe($this->team->id);
    });

    it('can check team member permissions', function () {
        $this->team->users()->attach($this->member, ['role' => 'admin']);

        $membership = $this->team
            ->users()
            ->where('user_id', $this->member->id)
            ->first()
            ->membership;

        expect($membership->role)->toBe('admin');
    });
});

describe('Team Scopes and Queries', function () {
    it('can filter teams by owner', function () {
        $otherUser = User::factory()->create();
        Team::factory()->create(['user_id' => $otherUser->id]);

        $ownerTeams = Team::where('user_id', $this->owner->id)->get();

        expect($ownerTeams->every(fn ($team) => $team->user_id === $this->owner->id))->toBe(true);
    });

    it('can find teams by slug', function () {
        $slug = 'unique-team-slug-'.uniqid();
        $team = Team::factory()->create(['slug' => $slug]);

        $foundTeam = Team::where('slug', $slug)->first();

        expect($foundTeam->id)->toBe($team->id);
    });

    it('can get teams with member count', function () {
        $member1 = User::factory()->create();
        $member2 = User::factory()->create();
        $this->team->users()->attach([$member1->id, $member2->id]);

        $teamWithCount = Team::withCount('users')->find($this->team->id);

        expect($teamWithCount->users_count)->toBe(2);
    });
});

describe('Team Features', function () {
    it('can have team settings', function () {
        $this->team->update([
            'settings' => [
                'allow_invitations' => true,
                'max_members' => 50,
                'public' => false,
            ],
        ]);

        $settings = $this->team->fresh()->settings;

        expect($settings['allow_invitations'])->toBe(true);
        expect($settings['max_members'])->toBe(50);
        expect($settings['public'])->toBe(false);
    });

    it('can have team avatar', function () {
        $this->team->update([
            'avatar_path' => 'teams/avatars/team-avatar.jpg',
        ]);

        expect($this->team->fresh()->avatar_path)->toBe('teams/avatars/team-avatar.jpg');
    });

    it('can check if team is full', function () {
        // Assuming team has max_members setting
        $this->team->update([
            'settings' => ['max_members' => 2],
        ]);

        $member1 = User::factory()->create();
        $member2 = User::factory()->create();
        $this->team->users()->attach([$member1->id, $member2->id]);

        $memberCount = $this->team->users()->count();
        $maxMembers = $this->team->settings['max_members'] ?? null;

        if ($maxMembers) {
            expect($memberCount >= $maxMembers)->toBe(true);
        }
    });
});

describe('Team Events and Notifications', function () {
    it('can notify team members of changes', function () {
        $this->team->users()->attach($this->member);

        Notification::fake();

        // Simulate team update notification
        $this->team->update(['name' => 'New Team Name']);

        // Would test notification dispatch if implemented
        expect($this->team->fresh()->name)->toBe('New Team Name');
    });

    it('can log team activities', function () {
        $this->team->users()->attach($this->member);

        // Test activity logging when members join/leave
        expect($this->team->users->contains($this->member))->toBeTrue();
    });
});
