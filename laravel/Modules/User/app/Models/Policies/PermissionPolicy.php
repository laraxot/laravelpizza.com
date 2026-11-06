<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Modules\User\Models\Permission;
use Modules\Xot\Contracts\UserContract;

class PermissionPolicy extends UserBasePolicy
{
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
    public function view(UserContract $_user, Permission $_permission): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $_user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $_user, Permission $_permission): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $_user, Permission $_permission): bool
    {
        // return $user->ownsTeam($team);
        return true;
    }
}
