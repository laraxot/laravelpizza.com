<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Policies;

use Modules\Geo\Models\Locality;
use Modules\Xot\Contracts\UserContract;

class LocalityPolicy extends GeoBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('locality.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Locality $locality): bool
    {
        return $user->hasPermissionTo('locality.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('locality.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Locality $locality): bool
    {
        return $user->hasPermissionTo('locality.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Locality $locality): bool
    {
        return $user->hasPermissionTo('locality.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Locality $locality): bool
    {
        return $user->hasPermissionTo('locality.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Locality $locality): bool
    {
        return $user->hasPermissionTo('locality.forceDelete');
    }
}
