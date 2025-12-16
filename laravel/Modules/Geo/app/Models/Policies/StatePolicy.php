<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Policies;

use Modules\Geo\Models\State;
use Modules\Xot\Contracts\UserContract;

class StatePolicy extends GeoBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('state.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, State $state): bool
    {
        return $user->hasPermissionTo('state.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('state.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, State $state): bool
    {
        return $user->hasPermissionTo('state.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, State $state): bool
    {
        return $user->hasPermissionTo('state.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, State $state): bool
    {
        return $user->hasPermissionTo('state.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, State $state): bool
    {
        return $user->hasPermissionTo('state.forceDelete');
    }
}
