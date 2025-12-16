<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Policies;

use Modules\Geo\Models\Province;
use Modules\Xot\Contracts\UserContract;

class ProvincePolicy extends GeoBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('province.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Province $province): bool
    {
        return $user->hasPermissionTo('province.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('province.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Province $province): bool
    {
        return $user->hasPermissionTo('province.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Province $province): bool
    {
        return $user->hasPermissionTo('province.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Province $province): bool
    {
        return $user->hasPermissionTo('province.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Province $province): bool
    {
        return $user->hasPermissionTo('province.forceDelete');
    }
}
