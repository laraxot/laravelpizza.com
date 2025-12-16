<?php

declare(strict_types=1);

namespace Modules\Cms\Models\Policies;

use Modules\Cms\Models\Module;
use Modules\Xot\Contracts\UserContract;

class ModulePolicy extends CmsBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('module.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Module $module): bool
    {
        return $user->hasPermissionTo('module.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('module.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Module $module): bool
    {
        return $user->hasPermissionTo('module.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Module $module): bool
    {
        return $user->hasPermissionTo('module.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Module $module): bool
    {
        return $user->hasPermissionTo('module.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Module $module): bool
    {
        return $user->hasPermissionTo('module.forceDelete');
    }
}
