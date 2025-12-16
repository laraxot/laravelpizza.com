<?php

declare(strict_types=1);

namespace Modules\Job\Models\Policies;

use Modules\Job\Models\Export;
use Modules\Xot\Contracts\UserContract;

class ExportPolicy extends JobBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('export.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Export $_export): bool
    {
        return $user->hasPermissionTo('export.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('export.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Export $_export): bool
    {
        return $user->hasPermissionTo('export.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Export $_export): bool
    {
        return $user->hasPermissionTo('export.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Export $_export): bool
    {
        return $user->hasPermissionTo('export.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Export $export): bool
    {
        return $user->hasPermissionTo('export.forceDelete');
    }
}
