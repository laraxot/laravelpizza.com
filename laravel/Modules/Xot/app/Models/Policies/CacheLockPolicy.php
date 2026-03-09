<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Policies;

use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\CacheLock;
use Override;

class CacheLockPolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('cache_lock.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, CacheLock $_cache_lock): bool
    {
        return $user->hasPermissionTo('cache_lock.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('cache_lock.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, CacheLock $_cache_lock): bool
    {
        return $user->hasPermissionTo('cache_lock.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, CacheLock $_cache_lock): bool
    {
        return $user->hasPermissionTo('cache_lock.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, CacheLock $_cache_lock): bool
    {
        return $user->hasPermissionTo('cache_lock.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, CacheLock $cache_lock): bool
    {
        return $user->hasPermissionTo('cache_lock.forceDelete');
    }
}
