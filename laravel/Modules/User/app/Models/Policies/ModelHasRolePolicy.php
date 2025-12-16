<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Modules\User\Models\ModelHasRole;
use Modules\Xot\Contracts\UserContract;

class ModelHasRolePolicy extends UserBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('model-has-role.view.any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, ModelHasRole $_modelHasRole): bool
    {
        return $user->hasPermissionTo('model-has-role.view') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('model-has-role.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, ModelHasRole $_modelHasRole): bool
    {
        return $user->hasPermissionTo('model-has-role.update') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, ModelHasRole $_modelHasRole): bool
    {
        return $user->hasPermissionTo('model-has-role.delete') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, ModelHasRole $_modelHasRole): bool
    {
        return $user->hasPermissionTo('model-has-role.restore') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, ModelHasRole $modelHasRole): bool
    {
        return $user->hasPermissionTo('model-has-role.force-delete') || $user->hasRole('super-admin');
    }
}
