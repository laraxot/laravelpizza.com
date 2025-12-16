<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Policies;

use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Feed;
use Override;

class FeedPolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('feed.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Feed $_feed): bool
    {
        return $user->hasPermissionTo('feed.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('feed.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Feed $_feed): bool
    {
        return $user->hasPermissionTo('feed.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Feed $_feed): bool
    {
        return $user->hasPermissionTo('feed.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Feed $_feed): bool
    {
        return $user->hasPermissionTo('feed.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Feed $feed): bool
    {
        return $user->hasPermissionTo('feed.forceDelete');
    }
}
