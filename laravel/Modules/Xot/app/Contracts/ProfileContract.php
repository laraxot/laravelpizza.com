<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Models\Role;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

/**
 * Modules\Xot\Contracts\ProfileContract.
 *
 * @property string $id
 * @property string $email
 * @property string $slug
 * @property string $user_id
 * @property Collection<int, Role> $roles
 * @property int|null $roles_count
 * @property UserContract $user
 *
 * @phpstan-require-extends Model
 *
 * @mixin \Eloquent
 */
interface ProfileContract extends HasMedia
{
    /**
     * Grant the given permission(s) to a role.
     *
     * @return $this
     */
    public function givePermissionTo(string|int|array|Permission|\Illuminate\Support\Collection $permissions = []);

    /**
     * Assign the given role to the model.
     *
     * @return $this
     */
    public function assignRole(array|string|int|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection $roles = [
    ]);

    /**
     * Determine if the model has (one of) the given role(s).
     */
    public function hasRole(
        string|int|array|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection $roles,
        ?string $guard = null,
    ): bool;

    /**
     * Determine if the model has any of the given role(s).
     *
     * Alias to hasRole() but without Guard controls
     */
    public function hasAnyRole(string|int|array|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection $roles = [
    ]): bool;

    /**
     * Determine if the model may perform the given permission.
     *
     * @throws PermissionDoesNotExist
     */
    public function hasPermissionTo(string|int|Permission $permission, ?string $guardName = null): bool;

    /**
     * Undocumented function.
     */
    public function toggleSuperAdmin(): void;

    /**
     * ---return BelongsTo<UserContract, self>.
     */
    public function user(): BelongsTo;

    /**
     * --.
     */
    public function isSuperAdmin(): bool;
}
