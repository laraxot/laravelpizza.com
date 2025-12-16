<?php

declare(strict_types=1);

namespace Modules\Job\Models\Policies;

use Modules\Job\Models\FailedImportRow;
use Modules\Xot\Contracts\UserContract;

class FailedImportRowPolicy extends JobBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('failed_import_row.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, FailedImportRow $_failed_import_row): bool
    {
        return $user->hasPermissionTo('failed_import_row.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('failed_import_row.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, FailedImportRow $_failed_import_row): bool
    {
        return $user->hasPermissionTo('failed_import_row.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, FailedImportRow $_failed_import_row): bool
    {
        return $user->hasPermissionTo('failed_import_row.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, FailedImportRow $_failed_import_row): bool
    {
        return $user->hasPermissionTo('failed_import_row.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, FailedImportRow $failed_import_row): bool
    {
        return $user->hasPermissionTo('failed_import_row.forceDelete');
    }
}
