<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Modules\User\Models\DeviceProfile;
use Modules\Xot\Contracts\UserContract;

class DeviceProfilePolicy extends UserBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('device-profile.view.any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, DeviceProfile $deviceProfile): bool
    {
        return $user->hasPermissionTo('device-profile.view')
            || $user->id === $deviceProfile->user_id
            || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('device-profile.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, DeviceProfile $_deviceProfile): bool
    {
        return $user->hasPermissionTo('device-profile.update') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, DeviceProfile $_deviceProfile): bool
    {
        return $user->hasPermissionTo('device-profile.delete') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, DeviceProfile $_deviceProfile): bool
    {
        return $user->hasPermissionTo('device-profile.restore') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, DeviceProfile $deviceProfile): bool
    {
        return $user->hasPermissionTo('device-profile.force-delete') || $user->hasRole('super-admin');
    }
}
