<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Contracts\Role;

/**
 * Interface Modules\Xot\Contracts\ProfileContract.
 *
 * @property int               $id
 * @property string|null       $user_id
 * @property string|null       $first_name
 * @property string|null       $last_name
 * @property string|null       $full_name
 * @property UserContract|null $user
 *
 * @method        bool            isSuperAdmin()
 * @method static ProfileContract make()
 */
interface ProfileContract
{
    /**
     * Get the user associated with the profile.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo;

    /**
     * Get the profile full name.
     */
    public function getFullNameAttribute(): string;

    /**
     * Toggles the super-admin role for the associated user.
     */
    public function toggleSuperAdmin(): void;

    /**
     * Assign the given role to the model.
     *
     * @return $this
     */
    public function assignRole(array|string|int|Role|Collection $roles = []);

    /**
     * Determine if the model has (one of) the given role(s).
     */
    public function hasRole(string|int|array|Role|Collection $roles, ?string $guard = null): bool;

    /**
     * Revoke the given role from the model.
     *
     * @return $this
     */
    public function removeRole(string|int|array|Role|Collection $role);
}
