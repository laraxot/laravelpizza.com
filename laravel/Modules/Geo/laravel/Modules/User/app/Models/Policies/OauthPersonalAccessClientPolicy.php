<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Modules\User\Models\OauthPersonalAccessClient;
use Modules\Xot\Contracts\UserContract;

class OauthPersonalAccessClientPolicy extends UserBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('oauth-personal-access-client.view.any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, OauthPersonalAccessClient $_oauthPersonalAccessClient): bool
    {
        return $user->hasPermissionTo('oauth-personal-access-client.view') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('oauth-personal-access-client.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, OauthPersonalAccessClient $_oauthPersonalAccessClient): bool
    {
        return $user->hasPermissionTo('oauth-personal-access-client.update') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, OauthPersonalAccessClient $_oauthPersonalAccessClient): bool
    {
        return $user->hasPermissionTo('oauth-personal-access-client.delete') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, OauthPersonalAccessClient $_oauthPersonalAccessClient): bool
    {
        return $user->hasPermissionTo('oauth-personal-access-client.restore') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, OauthPersonalAccessClient $oauthPersonalAccessClient): bool
    {
        return $user->hasPermissionTo('oauth-personal-access-client.force-delete') || $user->hasRole('super-admin');
    }
}
