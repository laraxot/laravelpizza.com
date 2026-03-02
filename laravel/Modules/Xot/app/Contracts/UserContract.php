<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use BackedEnum;
use Filament\Models\Contracts\HasName;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\PersonalAccessTokenResult;
use Laravel\Passport\Token;
use Laravel\Passport\TransientToken;
use Modules\User\Contracts\TeamContract;
use Modules\User\Models\Role as UserRole;
use Modules\User\Models\Team;
use Modules\User\Models\Tenant;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

/**
 * Modules\Xot\Contracts\UserContract.
 *
 * @property string|null $id
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $full_name
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $type
 * @property string|null $current_team_id
 * @property TeamContract $currentTeam
 * @property ProfileContract|null $profile
 * @property Collection<int, UserRole> $roles
 * @property Collection<int, Team> $teams
 * @property Collection<int, Tenant> $tenants
 *
 * @phpstan-require-extends Model
 *
 * @mixin \Eloquent
 */
interface UserContract extends Authenticatable, HasMedia, HasName, HasTenants, MustVerifyEmail, OAuthenticatable
{
    /*
     * public function isSuperAdmin();
     * public function name();
     * public function areas();
     * public function avatar();
     */
    public function profile(): HasOne;

    /**
     * Get the access token currently associated with the user.
     *
     * @return Token|TransientToken|null
     */
    public function token();

    /**
     * Create a new personal access token for the user.
     *
     * @param  array<int, string>  $scopes
     */
    public function createToken(string $name, array $scopes = []): PersonalAccessTokenResult;

    /**
     * Passport API tokens support.
     */
    // @phpstan-ignore-next-line interface should extend this contract

    /**
     * Determine if the model has (one of) the given role(s).
     */
    public function hasRole(
        string|int|array|UserRole|Collection $roles,
        ?string $guard = null,
    ): bool;

    /**
     * Assign the given role to the model.
     *
     * @return $this
     */
    public function assignRole(array|string|int|UserRole|Collection $roles = []);

    /**
     * Remove all current roles and set the given ones.
     *
     * @return $this
     */
    public function syncRoles(array|string|int|UserRole|Collection $roles = []);

    /**
     * Determine if the model has (one of) the given permission(s).
     *
     * @throws PermissionDoesNotExist
     */
    public function hasPermissionTo(string|int|Permission $permission, ?string $guardName = null): bool;

    /**
     * Check if the user can access Socialite.
     */
    public function canAccessSocialite(): bool;

    /**
     * Get the user's roles.
     */
    public function roles(): BelongsToMany;

    /**
     * Get the user's teams.
     */
    public function teams(): BelongsToMany;

    /**
     * Get the user's tenants.
     */
    public function tenants(): BelongsToMany;

    /**
     * Revoke the given role from the model.
     *
     * @param  string|int|array|UserRole|Collection|BackedEnum  ...$role
     * @return $this
     */
    public function removeRole(...$role);

    /**
     * Determine if the user owns the given team.
     */
    public function ownsTeam(TeamContract $team): bool;

    /**
     * Determine if the user belongs to the given team.
     */
    public function belongsToTeam(TeamContract $team): bool;

    /**
     * Determine if the user has the given permission on the given team.
     */
    public function hasTeamPermission(TeamContract $team, string $permission): bool;

    /**
     * Switch the user's context to the given team.
     */
    public function switchTeam(TeamContract $team): bool;

    /**
     * @return array<string, \Nwidart\Modules\Laravel\Module>
     */
    public function getModules(): array;

    /**
     * Find the user instance for the given username (Passport).
     */
    public static function findForPassport(string $username): ?self;

    /**
     * Validate the password of the user for the given password (Passport).
     */
    public function validateForPassportPasswordGrant(string $password): bool;
}
