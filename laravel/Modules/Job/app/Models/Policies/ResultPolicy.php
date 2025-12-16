<?php

declare(strict_types=1);

namespace Modules\Job\Models\Policies;

use Modules\Job\Models\Result;
use Modules\Xot\Contracts\UserContract;

class ResultPolicy extends JobBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('result.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Result $_result): bool
    {
        return $user->hasPermissionTo('result.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('result.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Result $_result): bool
    {
        return $user->hasPermissionTo('result.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Result $_result): bool
    {
        return $user->hasPermissionTo('result.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Result $_result): bool
    {
        return $user->hasPermissionTo('result.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Result $result): bool
    {
        return $user->hasPermissionTo('result.forceDelete');
    }
}
