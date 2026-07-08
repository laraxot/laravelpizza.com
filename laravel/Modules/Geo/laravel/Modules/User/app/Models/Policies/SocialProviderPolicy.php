<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Modules\User\Models\SocialProvider;
use Modules\Xot\Contracts\UserContract;

class SocialProviderPolicy extends UserBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        // return $user->hasPermissionTo('social-provider.view.any');
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, SocialProvider $_socialProvider): bool
    {
        return $user->hasPermissionTo('social-provider.view') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('social-provider.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, SocialProvider $_socialProvider): bool
    {
        return $user->hasPermissionTo('social-provider.update') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, SocialProvider $_socialProvider): bool
    {
        return $user->hasPermissionTo('social-provider.delete') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, SocialProvider $_socialProvider): bool
    {
        return $user->hasPermissionTo('social-provider.restore') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, SocialProvider $socialProvider): bool
    {
        return $user->hasPermissionTo('social-provider.force-delete') || $user->hasRole('super-admin');
    }
}
