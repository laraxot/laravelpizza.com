<?php

declare(strict_types=1);

namespace Modules\Cms\Models\Policies;

use Modules\Cms\Models\Section;
use Modules\Xot\Contracts\UserContract;

class SectionPolicy extends CmsBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('section.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Section $section): bool
    {
        return $user->hasPermissionTo('section.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('section.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Section $section): bool
    {
        return $user->hasPermissionTo('section.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Section $section): bool
    {
        return $user->hasPermissionTo('section.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Section $section): bool
    {
        return $user->hasPermissionTo('section.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Section $section): bool
    {
        return $user->hasPermissionTo('section.forceDelete');
    }
}
