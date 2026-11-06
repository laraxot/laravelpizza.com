<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Modules\User\Models\AuthenticationLog;
use Modules\Xot\Contracts\UserContract;

class AuthenticationLogPolicy extends UserBasePolicy
{
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionToOrCreate(
            'authentication-log.view.any'
        );
    }

    public function view(UserContract $user, AuthenticationLog $authenticationLog): bool
    {
        return $user->hasPermissionToOrCreate('authentication-log.view')
            || $user->id === $authenticationLog->authenticatable_id
            || $user->hasRole('super-admin');
    }

    public function create(UserContract $user): bool
    {
        return $user->hasPermissionToOrCreate('authentication-log.create');
    }

    public function update(UserContract $user, AuthenticationLog $_authenticationLog): bool
    {
        return $user->hasPermissionToOrCreate('authentication-log.update') || $user->hasRole('super-admin');
    }

    public function delete(UserContract $user, AuthenticationLog $_authenticationLog): bool
    {
        return $user->hasPermissionToOrCreate('authentication-log.delete') || $user->hasRole('super-admin');
    }

    public function restore(UserContract $user, AuthenticationLog $_authenticationLog): bool
    {
        return $user->hasPermissionToOrCreate('authentication-log.restore') || $user->hasRole('super-admin');
    }

    public function forceDelete(UserContract $user, AuthenticationLog $authenticationLog): bool
    {
        return $user->hasPermissionToOrCreate('authentication-log.force-delete') || $user->hasRole('super-admin');
    }
}
