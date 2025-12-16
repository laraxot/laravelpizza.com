<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Policies;

use Modules\Geo\Models\Location;
use Modules\Xot\Contracts\UserContract;

class LocationPolicy extends GeoBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('location.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Location $location): bool
    {
        return $user->hasPermissionTo('location.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('location.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Location $location): bool
    {
        return $user->hasPermissionTo('location.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Location $location): bool
    {
        return $user->hasPermissionTo('location.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Location $location): bool
    {
        return $user->hasPermissionTo('location.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Location $location): bool
    {
        return $user->hasPermissionTo('location.forceDelete');
    }
}
