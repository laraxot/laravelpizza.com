<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Modules\User\Models\OauthAuthCode;
use Modules\Xot\Contracts\UserContract;

class OauthAuthCodePolicy extends UserBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('oauth-auth-code.view.any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, OauthAuthCode $_oauthAuthCode): bool
    {
        return $user->hasPermissionTo('oauth-auth-code.view') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('oauth-auth-code.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, OauthAuthCode $_oauthAuthCode): bool
    {
        return $user->hasPermissionTo('oauth-auth-code.update') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, OauthAuthCode $_oauthAuthCode): bool
    {
        return $user->hasPermissionTo('oauth-auth-code.delete') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, OauthAuthCode $_oauthAuthCode): bool
    {
        return $user->hasPermissionTo('oauth-auth-code.restore') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, OauthAuthCode $oauthAuthCode): bool
    {
        return $user->hasPermissionTo('oauth-auth-code.force-delete') || $user->hasRole('super-admin');
    }
}
