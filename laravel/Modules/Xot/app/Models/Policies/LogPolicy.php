<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Policies;

use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Log;
use Override;

class LogPolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('log.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Log $_log): bool
    {
        return $user->hasPermissionTo('log.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('log.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Log $_log): bool
    {
        return $user->hasPermissionTo('log.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Log $_log): bool
    {
        return $user->hasPermissionTo('log.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Log $_log): bool
    {
        return $user->hasPermissionTo('log.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Log $log): bool
    {
        return $user->hasPermissionTo('log.forceDelete');
    }
}
