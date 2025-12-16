<?php

declare(strict_types=1);

namespace Modules\Job\Models\Policies;

use Modules\Job\Models\Import;
use Modules\Xot\Contracts\UserContract;

class ImportPolicy extends JobBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('import.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Import $_import): bool
    {
        return $user->hasPermissionTo('import.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('import.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Import $_import): bool
    {
        return $user->hasPermissionTo('import.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Import $_import): bool
    {
        return $user->hasPermissionTo('import.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Import $_import): bool
    {
        return $user->hasPermissionTo('import.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Import $import): bool
    {
        return $user->hasPermissionTo('import.forceDelete');
    }
}
