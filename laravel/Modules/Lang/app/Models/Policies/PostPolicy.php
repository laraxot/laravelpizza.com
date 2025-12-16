<?php

declare(strict_types=1);

namespace Modules\Lang\Models\Policies;

use Modules\Lang\Models\Post;
use Modules\Xot\Contracts\UserContract;

class PostPolicy extends LangBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('post.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Post $post): bool
    {
        unset($post);

        return $user->hasPermissionTo('post.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('post.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Post $post): bool
    {
        unset($post);

        return $user->hasPermissionTo('post.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Post $post): bool
    {
        unset($post);

        return $user->hasPermissionTo('post.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Post $post): bool
    {
        unset($post);

        return $user->hasPermissionTo('post.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Post $post): bool
    {
        unset($post);

        return $user->hasPermissionTo('post.forceDelete');
    }
}
