<?php

declare(strict_types=1);

namespace Modules\Job\Models\Policies;

use Modules\Job\Models\JobManager;
use Modules\Xot\Contracts\UserContract;

class JobManagerPolicy extends JobBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('job_manager.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, JobManager $_job_manager): bool
    {
        return $user->hasPermissionTo('job_manager.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('job_manager.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, JobManager $_job_manager): bool
    {
        return $user->hasPermissionTo('job_manager.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, JobManager $_job_manager): bool
    {
        return $user->hasPermissionTo('job_manager.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, JobManager $_job_manager): bool
    {
        return $user->hasPermissionTo('job_manager.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, JobManager $job_manager): bool
    {
        return $user->hasPermissionTo('job_manager.forceDelete');
    }
}
