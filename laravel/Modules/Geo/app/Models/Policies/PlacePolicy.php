<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Policies;

use Modules\Geo\Models\Place;
use Modules\Xot\Contracts\UserContract;

class PlacePolicy extends GeoBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('place.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Place $place): bool
    {
        return $user->hasPermissionTo('place.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('place.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Place $place): bool
    {
        return $user->hasPermissionTo('place.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Place $place): bool
    {
        return $user->hasPermissionTo('place.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Place $place): bool
    {
        return $user->hasPermissionTo('place.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Place $place): bool
    {
        return $user->hasPermissionTo('place.forceDelete');
    }
}
