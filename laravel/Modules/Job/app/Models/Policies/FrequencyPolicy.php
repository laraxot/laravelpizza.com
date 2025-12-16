<?php

declare(strict_types=1);

namespace Modules\Job\Models\Policies;

use Modules\Job\Models\Frequency;
use Modules\Xot\Contracts\UserContract;

class FrequencyPolicy extends JobBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('frequency.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Frequency $_frequency): bool
    {
        return $user->hasPermissionTo('frequency.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('frequency.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Frequency $_frequency): bool
    {
        return $user->hasPermissionTo('frequency.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Frequency $_frequency): bool
    {
        return $user->hasPermissionTo('frequency.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Frequency $_frequency): bool
    {
        return $user->hasPermissionTo('frequency.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Frequency $frequency): bool
    {
        return $user->hasPermissionTo('frequency.forceDelete');
    }
}
