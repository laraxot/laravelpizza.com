<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Policies;

use Modules\Geo\Models\County;
use Modules\Xot\Contracts\UserContract;

class CountyPolicy extends GeoBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('county.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, County $county): bool
    {
        return $user->hasPermissionTo('county.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('county.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, County $county): bool
    {
        return $user->hasPermissionTo('county.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, County $county): bool
    {
        return $user->hasPermissionTo('county.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, County $county): bool
    {
        return $user->hasPermissionTo('county.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, County $county): bool
    {
        return $user->hasPermissionTo('county.forceDelete');
    }
}
