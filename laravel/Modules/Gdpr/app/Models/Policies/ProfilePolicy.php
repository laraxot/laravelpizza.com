<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models\Policies;

use Modules\Gdpr\Models\Profile;
use Modules\Xot\Contracts\UserContract;

class ProfilePolicy extends GdprBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('profile.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Profile $_profile): bool
    {
        return $user->hasPermissionTo('profile.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('profile.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Profile $_profile): bool
    {
        return $user->hasPermissionTo('profile.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Profile $_profile): bool
    {
        return $user->hasPermissionTo('profile.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Profile $_profile): bool
    {
        return $user->hasPermissionTo('profile.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Profile $profile): bool
    {
        return $user->hasPermissionTo('profile.forceDelete');
    }
}
