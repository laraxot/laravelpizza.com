<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Modules\User\Models\PasswordReset;
use Modules\Xot\Contracts\UserContract;

class PasswordResetPolicy extends UserBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('password-reset.view.any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, PasswordReset $passwordReset): bool
    {
        return $user->hasPermissionTo('password-reset.view')
            || $user->email === $passwordReset->email
            || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('password-reset.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, PasswordReset $_passwordReset): bool
    {
        return $user->hasPermissionTo('password-reset.update') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, PasswordReset $_passwordReset): bool
    {
        return $user->hasPermissionTo('password-reset.delete') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, PasswordReset $_passwordReset): bool
    {
        return $user->hasPermissionTo('password-reset.restore') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, PasswordReset $passwordReset): bool
    {
        return $user->hasPermissionTo('password-reset.force-delete') || $user->hasRole('super-admin');
    }
}
