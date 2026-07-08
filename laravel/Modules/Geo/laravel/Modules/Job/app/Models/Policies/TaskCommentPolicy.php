<?php

declare(strict_types=1);

namespace Modules\Job\Models\Policies;

use Modules\Job\Models\TaskComment;
use Modules\Xot\Contracts\UserContract;

class TaskCommentPolicy extends JobBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('task_comment.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, TaskComment $_task_comment): bool
    {
        return $user->hasPermissionTo('task_comment.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('task_comment.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, TaskComment $_task_comment): bool
    {
        return $user->hasPermissionTo('task_comment.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, TaskComment $_task_comment): bool
    {
        return $user->hasPermissionTo('task_comment.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, TaskComment $_task_comment): bool
    {
        return $user->hasPermissionTo('task_comment.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, TaskComment $task_comment): bool
    {
        return $user->hasPermissionTo('task_comment.forceDelete');
    }
}
