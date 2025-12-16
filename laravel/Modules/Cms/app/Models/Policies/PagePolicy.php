<?php

declare(strict_types=1);

namespace Modules\Cms\Models\Policies;

use Modules\Cms\Models\Page;
use Modules\Xot\Contracts\UserContract;

class PagePolicy extends CmsBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('page.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Page $page): bool
    {
        return $user->hasPermissionTo('page.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('page.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Page $page): bool
    {
        return $user->hasPermissionTo('page.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Page $page): bool
    {
        return $user->hasPermissionTo('page.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Page $page): bool
    {
        return $user->hasPermissionTo('page.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Page $page): bool
    {
        return $user->hasPermissionTo('page.forceDelete');
    }
}
