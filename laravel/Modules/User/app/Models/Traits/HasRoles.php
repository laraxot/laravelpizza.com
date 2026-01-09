<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Modules\User\Models\Role;
use Spatie\Permission\Traits\HasRoles as SpatieHasRoles;

trait HasRoles
{
    use SpatieHasRoles;

    /**
     * A user may have multiple roles.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id')->where(
            'model_type',
            self::class,
        );
    }

    /**
     * Determine if the user has the given role.
     */
    public function hasRoleTest(string|array|\Spatie\Permission\Contracts\Role|Collection $roles, ?string $guard = null): bool
    {
        if (is_string($roles) && str_contains($roles, '|')) {
            $roles = explode('|', $roles);
        }

        if (is_string($roles)) {
            return $this->roles->contains('name', $roles);
        }

        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }

            return false;
        }

        return ! is_null($roles) && $this->roles->contains('id', $roles->id);
    }
}
