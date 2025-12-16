<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Modules\User\Models\RoleHasPermission;
use Modules\Xot\Contracts\UserContract;

class RoleHasPermissionPolicy extends UserBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('role-has-permission.view.any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, RoleHasPermission $_roleHasPermission): bool
    {
        return $user->hasPermissionTo('role-has-permission.view') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('role-has-permission.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, RoleHasPermission $_roleHasPermission): bool
    {
        return $user->hasPermissionTo('role-has-permission.update') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, RoleHasPermission $_roleHasPermission): bool
    {
        return $user->hasPermissionTo('role-has-permission.delete') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, RoleHasPermission $_roleHasPermission): bool
    {
        return $user->hasPermissionTo('role-has-permission.restore') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, RoleHasPermission $roleHasPermission): bool
    {
        return $user->hasPermissionTo('role-has-permission.force-delete') || $user->hasRole('super-admin');
    }
}
