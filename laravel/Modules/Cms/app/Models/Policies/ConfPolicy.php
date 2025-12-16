<?php

declare(strict_types=1);

namespace Modules\Cms\Models\Policies;

use Modules\Cms\Models\Conf;
use Modules\Xot\Contracts\UserContract;

class ConfPolicy extends CmsBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('conf.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Conf $conf): bool
    {
        return $user->hasPermissionTo('conf.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('conf.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Conf $conf): bool
    {
        return $user->hasPermissionTo('conf.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Conf $conf): bool
    {
        return $user->hasPermissionTo('conf.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Conf $conf): bool
    {
        return $user->hasPermissionTo('conf.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Conf $conf): bool
    {
        return $user->hasPermissionTo('conf.forceDelete');
    }
}
