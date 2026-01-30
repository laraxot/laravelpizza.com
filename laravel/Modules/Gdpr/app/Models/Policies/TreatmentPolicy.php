<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models\Policies;

use Modules\Gdpr\Models\Treatment;
use Modules\Xot\Contracts\UserContract;

class TreatmentPolicy extends GdprBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('treatment.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Treatment $_treatment): bool
    {
        return $user->hasPermissionTo('treatment.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('treatment.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Treatment $_treatment): bool
    {
        return $user->hasPermissionTo('treatment.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Treatment $_treatment): bool
    {
        return $user->hasPermissionTo('treatment.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Treatment $_treatment): bool
    {
        return $user->hasPermissionTo('treatment.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Treatment $treatment): bool
    {
        return $user->hasPermissionTo('treatment.forceDelete');
    }
}
