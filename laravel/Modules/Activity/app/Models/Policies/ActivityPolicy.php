<?php

declare(strict_types=1);

namespace Modules\Activity\Models\Policies;

use Modules\User\Models\Policies\UserBasePolicy;
use Modules\Xot\Contracts\UserContract;

class ActivityPolicy extends UserBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(UserContract $user): bool
    // {
    //     return $user->hasPermissionTo('activity.viewAny');
    // }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user): bool
    {
        return $user->hasPermissionTo('activity.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('activity.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user): bool
    {
        return $user->hasPermissionTo('activity.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user): bool
    {
        return $user->hasPermissionTo('activity.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user): bool
    {
        return $user->hasPermissionTo('activity.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user): bool
    {
        return $user->hasPermissionTo('activity.forceDelete');
    }
}
