<?php

declare(strict_types=1);

namespace Modules\Activity\Models\Policies;

use Modules\User\Models\Policies\UserBasePolicy;
use Modules\Xot\Contracts\UserContract;

class SnapshotPolicy extends UserBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(UserContract $user): bool
    // {
    //     return $user->hasPermissionTo('snapshot.viewAny');
    // }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user): bool
    {
        return $user->hasPermissionTo('snapshot.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('snapshot.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user): bool
    {
        return $user->hasPermissionTo('snapshot.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user): bool
    {
        return $user->hasPermissionTo('snapshot.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user): bool
    {
        return $user->hasPermissionTo('snapshot.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user): bool
    {
        return $user->hasPermissionTo('snapshot.forceDelete');
    }
}
