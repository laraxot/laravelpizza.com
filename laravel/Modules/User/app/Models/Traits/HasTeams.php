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
use Modules\User\Models\BaseUser;
use Modules\User\Models\Membership;
use Modules\User\Models\Role;
use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;

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
 * @property Collection<int, Membership>   $teamUsers
 * @property UserContract|null             $owner
 */
trait HasTeams
{
    /**
     * Add a user to the team.
     */
    public function addTeamMember(Model $user, ?Model $role = null): Model
    {
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
     * @return Collection<TeamContract>
     */
    public function allTeams(): Collection
    {
        return $this->ownedTeams->merge($this->teams)->sortBy('name');
    }

    /**
     * Check if the user belongs to any teams.
     */
    public function belongsToTeams(): bool
    {
        return true;
    }

    /**
     * Check if the user belongs to a specific team.
     */
    public function belongsToTeam(TeamContract $team): bool
    {
        $found = $this->teams()->where('teams.id', $team->id)->first();
        if (null === $found) {
            return false;
        }
        Assert::isInstanceOf($found, TeamContract::class, 'Team must implement TeamContract.');

        return true;
    }

    /**
     * Check if the user can add a member to a team.
     */
    public function canAddTeamMember(TeamContract $team): bool
    {
        return $this->ownsTeam($team) || $this->hasTeamPermission($team, 'add team member');
    }

    /**
     * Check if the user can create a team.
     */
    public function canCreateTeam(): bool
    {
        return $this->hasPermissionTo('create team');
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
    public function canRemoveTeamMember(TeamContract $team, UserContract $_user): bool
    {
        return $this->ownsTeam($team) || $this->hasTeamPermission($team, 'remove team member');
    }

    /**
     * Check if the user can update a team.
     */
    public function canUpdateTeam(TeamContract $team): bool
    {
        return $this->ownsTeam($team) || $this->hasTeamPermission($team, 'update team');
    }

    /**
     * Check if the user can update a team member.
     */
    public function canUpdateTeamMember(TeamContract $team, UserContract $_user): bool
    {
        return $this->ownsTeam($team) || $this->hasTeamPermission($team, 'update team member');
    }

    /**
     * Check if the user can view a team.
     */
    public function canViewTeam(TeamContract $team): bool
    {
        return $this->belongsToTeam($team) || $this->hasTeamPermission($team, 'view team');
    }

    /**
     * Get all of the team's users including its owner.
     *
     * @return Collection<int, User>
     */
    public function getAllTeamUsersAttribute(): Collection
    {
        // teamUsers are Membership objects, we need to extract the User models
        /** @var Collection<int, User> $users */
        $users = $this->teamUsers->map(static function ($membership) {
            // Membership always extends Model, check only if user attribute exists
            $user = $membership->getAttribute('user');

            return null !== $user ? $user : null;
        })->filter();

        $owner = $this->owner;
        if (null !== $owner && $owner instanceof User) {
            return $users->merge([$owner]);
        }

        return $users;
    }

    /**
     * Determine if the given user is on the team.
     */
    public function hasTeamMember(UserContract $user): bool
    {
        // Check if user is in teamUsers (checking by key since Membership != UserContract)
        $userFound = $this->teamUsers->first(static function ($membership) use ($user) {
            // Membership always extends Model
            $memberUser = $membership->getAttribute('user');
            if (\is_object($memberUser) && method_exists($memberUser, 'getKey')) {
                $memberUserKey = $memberUser->getKey();

                return null !== $memberUserKey && $memberUserKey === $user->getKey();
            }

            return false;
        });

        if (null !== $userFound) {
            return true;
        }

        // Check if user can own this team (UserContract sempre ha il metodo ownsTeam)
        if ($this instanceof TeamContract) {
            return $user->ownsTeam($this);
        }

        return false;
    }

    /**
     * Check if the user has teams.
     */
    public function hasTeams(): bool
    {
        return true;
    }

    /**
     * Check if the user has a specific permission in a team.
     */
    public function hasTeamPermission(TeamContract $team, string $permission): bool
    {
        return $this->ownsTeam($team) || \in_array($permission, $this->teamPermissions($team), strict: true);
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

        return null !== $teamRole && isset($teamRole->name) && $teamRole->name === $role;
    }

    /**
     * Get the current team of the user's context.
     *
     * @return BelongsTo<Model&TeamContract, $this>
     */
    public function currentTeam(): BelongsTo
    {
        $xot = XotData::make();
        if (null === $this->current_team_id && $this->id) {
            $this->switchTeam($this->personalTeam());
        }

        if ($this->allTeams()->isEmpty() && null !== $this->getKey()) {
            $this->current_team_id = null;
            $this->save();
        }

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
     * @return HasMany<Membership, $this>
     */
    public function teamUsers(): HasMany
    {
        return $this->hasMany(Membership::class, 'user_id');
    }

    /**
     * Get the role for a specific team.
     */
    public function teamRole(TeamContract $team): ?Role
    {
        /** @var Model|Pivot|null $teamUser */
        $teamUser = $this->teamUsers()->where('team_id', $team->id)->first();

        if (null === $teamUser) {
            return null;
        }

        // Accesso sicuro alla proprietà role usando getAttribute
        $role = $teamUser->getAttribute('role');

        return $role instanceof Role ? $role : null;
    }

    /**
     * Get permissions for a specific team.
     *
     * @return array<int, string>
     */
    public function teamPermissions(TeamContract $team): array
    {
        $role = $this->teamRole($team);

        if (null === $role || ! $role->permissions) {
            return [];
        }

        $permissionsRaw = $role->permissions->pluck('name')->values()->toArray();

        $permissions = [];
        foreach ($permissionsRaw as $value) {
            if (\is_string($value)) {
                $permissions[] = $value;
            }
        }
        /** @var array<int, string> $permissions */
        return $permissions;
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
        /* @var TeamContract|null */
        return $this->ownedTeams->where('personal_team', true)->first();
    }

    /**
     * Switch the user's context to the given team.
     */
    public function switchTeam(?TeamContract $team): bool
    {
        if (null === $team) {
            return false;
        }

        if (! $this->belongsToTeam($team)) {
            return false;
        }

        $this->current_team_id = (string) $team->id;
        $this->save();

        return true;
    }

    /**
     * Determine if the given team is the current team.
     */
    public function isCurrentTeam(TeamContract $team): bool
    {
        if (null === $this->currentTeam) {
            return false;
        }

        return $team->getKey() === $this->currentTeam->getKey();
    }

    /**
     * Determine if the user owns the given team.
     */
    public function ownsTeam(TeamContract $team): bool
    {
        /** @var ?Model $found */
        $found = $this->ownedTeams()->where('teams.id', $team->id)->first();

        return null !== $found;
    }

    /**
     * Get all of the teams the user belongs to.
     *
     * @return BelongsToMany<Model&TeamContract, $this, Membership>
     */
    public function teams(): BelongsToMany
    {
        $xot = XotData::make();
        $teamClass = $xot->getTeamClass();

        return $this->belongsToMany($teamClass, 'team_user', 'user_id', 'team_id')->using(Membership::class);
    }

    /**
     * Invite a user to a team.
     */
    public function inviteToTeam(UserContract $user, TeamContract $team): bool
    {
        if ($this->ownsTeam($team)) {
            $team->members()->attach($user->id, ['role' => 'member']);

            return true;
        }

        return false;
    }

    /**
     * Remove a user from the team.
     */
    public function removeFromTeam(UserContract $user, TeamContract $team): bool
    {
        if ($this->ownsTeam($team)) {
            $team->members()->detach($user->id);

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
    public function promoteToAdmin(UserContract $user, TeamContract $team): bool
    {
        if ($this->ownsTeam($team)) {
            $team->members()->updateExistingPivot($user->id, ['role' => 'admin']);

            return true;
        }

        return false;
    }

    /**
     * Demote a member from team admin.
     */
    public function demoteFromAdmin(UserContract $user, TeamContract $team): bool
    {
        if ($this->ownsTeam($team)) {
            $team->members()->updateExistingPivot($user->id, ['role' => 'member']);

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

    /**
     * Boot the HasTeams trait.
     */
    protected static function bootHasTeams(): void
    {
        /*
         * static::deleting(function ($team) {
         * $team->teamUsers()->delete();
         * $team->teamInvitations()->delete();
         * });
         */
    }
}
