<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models\Policies;

use Modules\Gdpr\Models\Consent;
use Modules\Xot\Contracts\UserContract;

class ConsentPolicy extends GdprBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('consent.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Consent $_consent): bool
    {
        return $user->hasPermissionTo('consent.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('consent.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Consent $_consent): bool
    {
        return $user->hasPermissionTo('consent.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Consent $_consent): bool
    {
        return $user->hasPermissionTo('consent.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Consent $_consent): bool
    {
        return $user->hasPermissionTo('consent.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Consent $consent): bool
    {
        return $user->hasPermissionTo('consent.forceDelete');
    }
}
