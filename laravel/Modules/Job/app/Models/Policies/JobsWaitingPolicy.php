<?php

declare(strict_types=1);

namespace Modules\Job\Models\Policies;

use Modules\Job\Models\JobsWaiting;
use Modules\Xot\Contracts\UserContract;

class JobsWaitingPolicy extends JobBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('jobs_waiting.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, JobsWaiting $_jobs_waiting): bool
    {
        return $user->hasPermissionTo('jobs_waiting.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('jobs_waiting.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, JobsWaiting $_jobs_waiting): bool
    {
        return $user->hasPermissionTo('jobs_waiting.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, JobsWaiting $_jobs_waiting): bool
    {
        return $user->hasPermissionTo('jobs_waiting.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, JobsWaiting $_jobs_waiting): bool
    {
        return $user->hasPermissionTo('jobs_waiting.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, JobsWaiting $jobs_waiting): bool
    {
        return $user->hasPermissionTo('jobs_waiting.forceDelete');
    }
}
