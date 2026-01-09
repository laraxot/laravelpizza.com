<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Modules\User\Models\AuthenticationLog;
use Modules\User\Models\Permission;
use Modules\Xot\Contracts\UserContract;

class AuthenticationLogPolicy extends UserBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $this->hasPermission($user, 'authentication-log.view.any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, AuthenticationLog $authenticationLog): bool
    {
        return $this->hasPermission($user, 'authentication-log.view')
            || $user->id === $authenticationLog->authenticatable_id
            || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $this->hasPermission($user, 'authentication-log.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, AuthenticationLog $_authenticationLog): bool
    {
        return $this->hasPermission($user, 'authentication-log.update') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, AuthenticationLog $_authenticationLog): bool
    {
        return $this->hasPermission($user, 'authentication-log.delete') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, AuthenticationLog $_authenticationLog): bool
    {
        return $this->hasPermission($user, 'authentication-log.restore') || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, AuthenticationLog $authenticationLog): bool
    {
        return $this->hasPermission($user, 'authentication-log.force-delete') || $user->hasRole('super-admin');
    }

    protected function hasPermission(UserContract $user, string $permission): bool
    {
        $exists = Permission::query()
            ->where('name', $permission)
            ->where('guard_name', 'web')
            ->exists();

        if (! $exists) {
            return false;
        }

        try {
            return $user->hasPermissionTo($permission);
        } catch (\Throwable) {
            return false;
        }
    }
}
