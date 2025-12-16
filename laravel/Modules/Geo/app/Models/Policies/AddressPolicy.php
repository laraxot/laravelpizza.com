<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Policies;

use Modules\Geo\Models\Address;
use Modules\Xot\Contracts\UserContract;

class AddressPolicy extends GeoBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('address.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Address $address): bool
    {
        return $user->hasPermissionTo('address.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('address.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Address $address): bool
    {
        return $user->hasPermissionTo('address.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Address $address): bool
    {
        return $user->hasPermissionTo('address.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Address $address): bool
    {
        return $user->hasPermissionTo('address.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Address $address): bool
    {
        return $user->hasPermissionTo('address.forceDelete');
    }
}
