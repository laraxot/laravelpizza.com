<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Collection;
use Modules\User\Contracts\TeamContract;
use Modules\User\Models\Role;
use Modules\User\Models\TeamUser;
use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract as XotUserContract;
use Modules\Xot\Datas\XotData;

/**
 * Trait HasTeams.
 *
 * Provides team functionality for User models implementing team-based organization.
 * This trait handles team ownership, membership, permissions, and relationships.
 *
 * @property TeamContract                  $currentTeam
 * @property int|null                      $current_team_id
 * @property Collection<int, TeamContract> $teams
 * @property Collection<int, TeamContract> $ownedTeams
 * @property Collection<int, TeamUser>     $teamUsers
 */
trait HasTeams
{
    /**
     * Add a user to the team.
     */
    public function addTeamMember(Model $user, ?Model $role = null): Model
    {
        /** @var Model $teamUser */
        $teamUser = $this->teamUsers()->create([
            'user_id' => $user->getKey(),
            'role_id' => $role ? $role->getKey() : null,
        ]);

        $this->increment('total_members');

        return $teamUser;
    }

    /**
     * Get all teams the user belongs to.
     *
     * @return Collection<int, TeamContract>
     */
    public function allTeams(): Collection
    {
        return $this->ownedTeams->merge($this->teams);
    }

    /**
     * Check if the user belongs to any teams.
     */
    public function belongsToTeams(): bool
    {
        return $this->allTeams()->isNotEmpty();
    }

    /**
     * Check if the user belongs to a specific team.
     */
    public function belongsToTeam(?TeamContract $team): bool
    {
        if (null === $team) {
            return false;
        }

        return $this->ownsTeam($team) || $this->teams->contains($team);
    }

    /**
     * Check if the user can add a member to a team.
     */
    public function canAddTeamMember(TeamContract $team): bool
    {
        return $this->ownsTeam($team);
    }

    /**
     * Check if the user can create a team.
     */
    public function canCreateTeam(): bool
    {
        return true;
    }

    /**
     * Check if the user can delete a team.
     */
    public function canDeleteTeam(TeamContract $team): bool
    {
        return $this->ownsTeam($team);
    }

    /**
     * Check if the user can leave a team.
     */
    public function canLeaveTeam(TeamContract $team): bool
    {
        return $this->belongsToTeam($team) && ! $this->ownsTeam($team);
    }

    /**
     * Check if the user can manage a team.
     */
    public function canManageTeam(TeamContract $team): bool
    {
        return $this->ownsTeam($team);
    }

    /**
     * Check if the user can remove a member from a team.
     */
    public function canRemoveTeamMember(TeamContract $team, XotUserContract $_user): bool
    {
        return $this->ownsTeam($team);
    }

    /**
     * Check if the user can update a team.
     */
    public function canUpdateTeam(TeamContract $team): bool
    {
        return $this->ownsTeam($team);
    }

    /**
     * Check if the user can update a team member.
     */
    public function canUpdateTeamMember(TeamContract $team, XotUserContract $_user): bool
    {
        return $this->ownsTeam($team);
    }

    /**
     * Check if the user can view a team.
     */
    public function canViewTeam(TeamContract $team): bool
    {
        return $this->belongsToTeam($team);
    }

    /**
     * Get all of the team's users including its owner.
     *
     * @return Collection<int, User>
     */
    public function getAllTeamUsersAttribute(): Collection
    {
        /** @var Collection<int, User> $users */
        $users = $this->teamUsers->map(static function ($membership) {
            return $membership->user;
        })->filter();

        $owner = $this->owner;
        if (null !== $owner && $owner instanceof User) {
            return $users->merge([$owner]);
        }

        return $users;
    }

    /**
     * Get all of the team's users including its owner.
     *
     * @return Collection<int, User>
     */
    public function allTeamUsers(): Collection
    {
        return $this->teams->flatMap(function ($team) {
            return $team->users;
        })->unique('id');
    }

    /**
     * Determine if the given user is on the team.
     */
    public function hasTeamMember(XotUserContract $user): bool
    {
        return $this->teamUsers->contains(function ($membership) use ($user) {
            return $membership->user_id === $user->getKey();
        });
    }

    /**
     * Check if the user has teams.
     */
    public function hasTeams(): bool
    {
        return $this->allTeams()->isNotEmpty();
    }

    /**
     * Check if the user has a specific permission in a team.
     */
    public function hasTeamPermission(TeamContract $team, string $permission): bool
    {
        return $this->ownsTeam($team);
    }

    /**
     * Check if the user has a specific role in a team.
     */
    public function hasTeamRole(TeamContract $team, string $role): bool
    {
        if ($this->ownsTeam($team)) {
            return true;
        }

        $teamRole = $this->teamRole($team);

        return null !== $teamRole && $teamRole->name === $role;
    }

    /**
     * Get the role name for a specific team.
     */
    public function teamRoleName(TeamContract $team): string
    {
        $role = $this->teamRole($team);

        if (null === $role) {
            return 'Unknown';
        }

        return $role->name;
    }

    /**
     * Get the current team of the user's context.
     *
     * @return BelongsTo<Model&TeamContract, $this>
     */
    public function currentTeam(): BelongsTo
    {
        $xot = XotData::make();
        $teamClass = $xot->getTeamClass();

        return $this->belongsTo($teamClass, 'current_team_id');
    }

    /**
     * Get the teams owned by the user.
     *
     * @return HasMany<Model&TeamContract, $this>
     */
    public function ownedTeams(): HasMany
    {
        $xot = XotData::make();
        $teamClass = $xot->getTeamClass();

        return $this->hasMany($teamClass, 'user_id');
    }

    /**
     * Get all team users.
     *
     * @return HasMany<TeamUser, $this>
     */
    public function teamUsers(): HasMany
    {
        return $this->hasMany(TeamUser::class, 'user_id');
    }

    /**
     * Get the role for a specific team.
     */
    public function teamRole(TeamContract $team): ?Role
    {
        if ($this->ownsTeam($team)) {
            return Role::where('name', 'owner')->first() ?? new Role(['name' => 'owner']);
        }

        $teamUser = $this->teamUsers()->where('team_id', $team->getKey())->first();

        if (null === $teamUser) {
            return null;
        }

        return $teamUser->role;
    }

    /**
     * Get permissions for a specific team.
     *
     * @return array<int, string>
     */
    public function teamPermissions(TeamContract $team): array
    {
        $permissions = [];

        $role = $this->teamRole($team);
        if (null !== $role && $role->permissions) {
            $permissions = $role->permissions->pluck('name')->toArray();
        }

        return array_values(array_unique($permissions));
    }

    /**
     * Remove a user from the team.
     */
    public function removeTeamMember(Model $user): void
    {
        $this->teamUsers()->where('user_id', $user->getKey())->delete();

        $this->decrement('total_members');
    }

    /**
     * Get the user's personal team.
     */
    public function personalTeam(): ?TeamContract
    {
        return $this->ownedTeams->where('personal_team', true)->first();
    }

    /**
     * Initialize the user's current team.
     */
    public function initializeCurrentTeam(): void
    {
        if (null !== $this->current_team_id) {
            return;
        }

        $team = $this->personalTeam();
        if (null === $team) {
            $team = $this->allTeams()->first();
        }

        if (null !== $team) {
            $this->switchTeam($team);
        }
    }

    /**
     * Switch the user's context to the given team.
     */
    public function switchTeam(TeamContract $team): bool
    {
        if (! $this->belongsToTeam($team)) {
            return false;
        }

        $this->forceFill([
            'current_team_id' => $team->getKey(),
        ]);

        return $this->save();
    }

    /**
     * Determine if the given team is the current team.
     */
    public function isCurrentTeam(TeamContract $team): bool
    {
        return $this->current_team_id === $team->getKey();
    }

    /**
     * Determine if the user owns the given team.
     */
    public function ownsTeam(?TeamContract $team): bool
    {
        if (null === $team) {
            return false;
        }

        return $this->getKey() === $team->user_id;
    }

    /**
     * Get all of the teams the user belongs to.
     *
     * @return BelongsToMany<Model&TeamContract, $this, TeamUser, 'pivot'>
     */
    public function teams(): BelongsToMany
    {
        $xot = XotData::make();
        $teamClass = $xot->getTeamClass();

        return $this->belongsToMany($teamClass, 'team_user', 'user_id', 'team_id')
            ->withPivot('role')
            ->withTimestamps()
            ->as('membership');
    }

    /**
     * Get all of the teams that the user owns.
     */
    public function inviteToTeam(XotUserContract $user, TeamContract $team): bool
    {
        if ($this->ownsTeam($team)) {
            $team->members()->attach($user->getKey(), ['role' => 'member']);

            return true;
        }

        return false;
    }

    /**
     * Remove a user from the team.
     */
    public function removeFromTeam(XotUserContract $user, TeamContract $team): bool
    {
        if ($this->ownsTeam($team)) {
            $team->members()->detach($user->getKey());

            return true;
        }

        return false;
    }

    /**
     * Check if the user is an owner or a member.
     */
    public function isOwnerOrMember(TeamContract $team): bool
    {
        return $this->ownsTeam($team) || $this->belongsToTeam($team);
    }

    /**
     * Promote a member to team admin.
     */
    public function promoteToAdmin(XotUserContract $user, TeamContract $team): bool
    {
        if ($this->ownsTeam($team)) {
            $team->members()->updateExistingPivot($user->getKey(), ['role' => 'admin']);

            return true;
        }

        return false;
    }

    /**
     * Demote a member from team admin.
     */
    public function demoteFromAdmin(XotUserContract $user, TeamContract $team): bool
    {
        if ($this->ownsTeam($team)) {
            $team->members()->updateExistingPivot($user->getKey(), ['role' => 'member']);

            return true;
        }

        return false;
    }

    /**
     * Get all admins of the team.
     */
    public function getTeamAdmins(TeamContract $team): Collection
    {
        return $team->members()->wherePivot('role', 'admin')->get();
    }

    /**
     * Get all members of the team.
     */
    public function getTeamMembers(TeamContract $team): Collection
    {
        return $team->members()->wherePivot('role', 'member')->get();
    }

    /**
     * Determine if the user owns the given team.
     */
    public function checkTeamOwnership(TeamContract $team): bool
    {
        return $this->ownsTeam($team);
    }
}
