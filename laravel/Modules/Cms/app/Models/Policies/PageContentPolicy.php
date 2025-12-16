<?php

declare(strict_types=1);

namespace Modules\Cms\Models\Policies;

use Modules\Cms\Models\PageContent;
use Modules\Xot\Contracts\UserContract;

class PageContentPolicy extends CmsBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('page_content.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, PageContent $page_content): bool
    {
        return $user->hasPermissionTo('page_content.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('page_content.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, PageContent $page_content): bool
    {
        return $user->hasPermissionTo('page_content.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, PageContent $page_content): bool
    {
        return $user->hasPermissionTo('page_content.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, PageContent $page_content): bool
    {
        return $user->hasPermissionTo('page_content.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, PageContent $page_content): bool
    {
        return $user->hasPermissionTo('page_content.forceDelete');
    }
}
