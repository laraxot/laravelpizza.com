<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Policies;

use Modules\Geo\Models\PlaceType;
use Modules\Xot\Contracts\UserContract;

class PlaceTypePolicy extends GeoBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('place_type.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, PlaceType $place_type): bool
    {
        return $user->hasPermissionTo('place_type.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('place_type.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, PlaceType $place_type): bool
    {
        return $user->hasPermissionTo('place_type.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, PlaceType $place_type): bool
    {
        return $user->hasPermissionTo('place_type.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, PlaceType $place_type): bool
    {
        return $user->hasPermissionTo('place_type.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, PlaceType $place_type): bool
    {
        return $user->hasPermissionTo('place_type.forceDelete');
    }
}
