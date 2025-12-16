<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Policies;

use Modules\Geo\Models\GeoNamesCap;
use Modules\Xot\Contracts\UserContract;

class GeoNamesCapPolicy extends GeoBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('geo_names_cap.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, GeoNamesCap $geo_names_cap): bool
    {
        return $user->hasPermissionTo('geo_names_cap.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('geo_names_cap.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, GeoNamesCap $geo_names_cap): bool
    {
        return $user->hasPermissionTo('geo_names_cap.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, GeoNamesCap $geo_names_cap): bool
    {
        return $user->hasPermissionTo('geo_names_cap.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, GeoNamesCap $geo_names_cap): bool
    {
        return $user->hasPermissionTo('geo_names_cap.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, GeoNamesCap $geo_names_cap): bool
    {
        return $user->hasPermissionTo('geo_names_cap.forceDelete');
    }
}
