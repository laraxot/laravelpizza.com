<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Contracts\TeamContract;
use Modules\Xot\Contracts\UserContract as XotUserContract;

/** @phpstan-ignore trait.unused */
trait HasTeamsMembershipAdministration
{
    public function inviteToTeam(XotUserContract $user, TeamContract $team): bool
    {
        if (! $this->ownsTeam($team)) {
            return false;
        }

        $team->members()->attach($user->id, ['role' => 'member']);

        return true;
    }

    public function removeFromTeam(XotUserContract $user, TeamContract $team): bool
    {
        if (! $this->ownsTeam($team)) {
            return false;
        }

        $team->members()->detach($user->id);

        return true;
    }

    public function isOwnerOrMember(TeamContract $team): bool
    {
        return $this->ownsTeam($team) || $this->belongsToTeam($team);
    }

    public function promoteToAdmin(XotUserContract $user, TeamContract $team): bool
    {
        if (! $this->ownsTeam($team)) {
            return false;
        }

        $team->members()->updateExistingPivot($user->id, ['role' => 'admin']);

        return true;
    }

    public function demoteFromAdmin(XotUserContract $user, TeamContract $team): bool
    {
        if (! $this->ownsTeam($team)) {
            return false;
        }

        $team->members()->updateExistingPivot($user->id, ['role' => 'member']);

        return true;
    }

    /**
     * @return Collection<int, Model>
     */
    public function getTeamAdmins(TeamContract $team): Collection
    {
        /** @var Collection<int, Model> $admins */
        $admins = $team->members()->wherePivot('role', 'admin')->get();

        return $admins;
    }

    /**
     * @return Collection<int, Model>
     */
    public function getTeamMembers(TeamContract $team): Collection
    {
        /** @var Collection<int, Model> $members */
        $members = $team->members()->wherePivot('role', 'member')->get();

        return $members;
    }

    public function checkTeamOwnership(TeamContract $team): bool
    {
        return $this->ownsTeam($team);
    }
}
