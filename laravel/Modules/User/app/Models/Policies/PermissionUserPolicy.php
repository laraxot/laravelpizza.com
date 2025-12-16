<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Modules\User\Models\PermissionUser;
use Modules\Xot\Contracts\UserContract;

class PermissionUserPolicy extends UserBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('permission-user.view.any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, PermissionUser $_permissionUser): bool
    {
        return $user->hasPermissionTo('permission-user.view') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('permission-user.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, PermissionUser $_permissionUser): bool
    {
        return $user->hasPermissionTo('permission-user.update') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, PermissionUser $_permissionUser): bool
    {
        return $user->hasPermissionTo('permission-user.delete') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, PermissionUser $_permissionUser): bool
    {
        return $user->hasPermissionTo('permission-user.restore') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, PermissionUser $permissionUser): bool
    {
        return $user->hasPermissionTo('permission-user.force-delete') || $user->hasRole('super-admin');
    }
}
