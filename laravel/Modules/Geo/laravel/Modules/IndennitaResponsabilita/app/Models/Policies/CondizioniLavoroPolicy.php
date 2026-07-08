<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models\Policies;

use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita as Post;
use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;
use Override;

class CondizioniLavoroPolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function compila(UserContract $user, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view any models.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Post $post): bool
    {
        return false; // puo' far modifica solo superadmin
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Post $post): bool
    {
        return false;
    }
}
