<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Modules\Xot\Contracts\UserContract as Post;

class UserPolicy extends UserBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Post $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Post $_user, Post $_post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Post $_user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Post $_user, Post $_post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Post $_user, Post $_post): bool
    {
        // return $user->ownsTeam($team);
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function superadmin(Post $_user, Post $_post): bool
    {
        // return $user->ownsTeam($team);
        return false;
    }
}
