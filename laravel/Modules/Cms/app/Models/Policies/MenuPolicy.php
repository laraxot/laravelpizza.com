<?php

declare(strict_types=1);

namespace Modules\Cms\Models\Policies;

use Modules\Cms\Models\Menu;
use Modules\Xot\Contracts\UserContract;

class MenuPolicy extends CmsBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('menu.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Menu $menu): bool
    {
        return $user->hasPermissionTo('menu.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('menu.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Menu $menu): bool
    {
        return $user->hasPermissionTo('menu.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Menu $menu): bool
    {
        return $user->hasPermissionTo('menu.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Menu $menu): bool
    {
        return $user->hasPermissionTo('menu.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Menu $menu): bool
    {
        return $user->hasPermissionTo('menu.forceDelete');
    }
}
