<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Modules\User\Models\Role;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\Concerns\DeniesUndeclaredFilamentAbilities;

/**
 * Ruoli: gestione riservata al super-admin (passa da XotBasePolicy::before()).
 *
 * Concedere create/update/delete o il collegamento dei ruoli a chi amministra gli utenti
 * permette di rinominare o assegnarsi il ruolo super-admin (escalation di privilegi).
 */
class RolePolicy extends UserBasePolicy
{
    use DeniesUndeclaredFilamentAbilities;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $_user, Role $_role): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $_user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $_user, Role $_role): bool
    {
        return false;
    }

    /**
     * Determine whether the user can add team members.
     */
    public function addTeamMember(UserContract $user, Role $role): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update team member permissions.
     */
    public function updateTeamMember(UserContract $user, Role $role): bool
    {
        return false;
    }

    /**
     * Determine whether the user can remove team members.
     */
    public function removeTeamMember(UserContract $user, Role $role): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $_user, Role $_role): bool
    {
        return false;
    }
}
