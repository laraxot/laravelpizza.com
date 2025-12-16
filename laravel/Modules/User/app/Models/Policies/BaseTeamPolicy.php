<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Modules\User\Models\BaseTeam as Model;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;

class BaseTeamPolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasRole(['super-admin', 'admin', 'hr-manager']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Model $model): bool
    {
        return $user->hasRole(['super-admin', 'admin', 'hr-manager'])
            || $model->hasUser($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasRole(['super-admin', 'admin', 'hr-manager']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Model $model): bool
    {
        return $user->hasRole(['super-admin', 'admin', 'hr-manager'])
            || $model->hasUser($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Model $model): bool
    {
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Model $model): bool
    {
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Model $model): bool
    {
        return $user->hasRole('super-admin');
    }
}
