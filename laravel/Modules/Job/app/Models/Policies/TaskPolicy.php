<?php

declare(strict_types=1);

namespace Modules\Job\Models\Policies;

use Modules\Job\Models\Task;
use Modules\Xot\Contracts\UserContract;

class TaskPolicy extends JobBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('task.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Task $_task): bool
    {
        return $user->hasPermissionTo('task.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('task.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Task $_task): bool
    {
        return $user->hasPermissionTo('task.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Task $_task): bool
    {
        return $user->hasPermissionTo('task.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Task $_task): bool
    {
        return $user->hasPermissionTo('task.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Task $task): bool
    {
        return $user->hasPermissionTo('task.forceDelete');
    }
}
