<?php

declare(strict_types=1);

namespace Modules\Job\Models\Policies;

use Modules\Job\Models\Parameter;
use Modules\Xot\Contracts\UserContract;

class ParameterPolicy extends JobBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('parameter.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Parameter $_parameter): bool
    {
        return $user->hasPermissionTo('parameter.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('parameter.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Parameter $_parameter): bool
    {
        return $user->hasPermissionTo('parameter.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Parameter $_parameter): bool
    {
        return $user->hasPermissionTo('parameter.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Parameter $_parameter): bool
    {
        return $user->hasPermissionTo('parameter.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Parameter $parameter): bool
    {
        return $user->hasPermissionTo('parameter.forceDelete');
    }
}
