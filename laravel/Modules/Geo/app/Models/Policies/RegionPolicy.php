<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Policies;

use Modules\Geo\Models\Region;
use Modules\Xot\Contracts\UserContract;

class RegionPolicy extends GeoBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('region.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Region $region): bool
    {
        return $user->hasPermissionTo('region.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('region.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Region $region): bool
    {
        return $user->hasPermissionTo('region.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Region $region): bool
    {
        return $user->hasPermissionTo('region.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Region $region): bool
    {
        return $user->hasPermissionTo('region.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Region $region): bool
    {
        return $user->hasPermissionTo('region.forceDelete');
    }
}
