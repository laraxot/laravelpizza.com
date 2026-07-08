<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Passport\PersonalAccessTokenResult;
use Laravel\Passport\Token;
use Laravel\Passport\TransientToken;
use Modules\User\Models\Role as UserRole;

/**
 * Alias tipizzato verso il contratto utente cross-modulo (SSoT: Xot).
 *
 * @phpstan-require-extends Model
 */
interface UserContract extends \Modules\Xot\Contracts\UserContract
{
    /**
     * Get the primary key for the model.
     */
    public function getKey(): mixed;

    /**
     * Get the current team of the user's context.
     *
     * @return BelongsTo<Model&TeamContract, Model>
     */
    public function currentTeam(): BelongsTo;

    /**
     * Get all of the teams the user belongs to.
     *
     * @return BelongsToMany<Model, $this>
     *
     * @phpstan-ignore generics.notSubtype
     */
    public function teams(): BelongsToMany;

    /**
     * Determine if the user owns the given team.
     */
    public function ownsTeam(TeamContract $team): bool;

    /**
     * Determine if the user belongs to the given team.
     */
    public function belongsToTeam(TeamContract $team): bool;

    /**
     * Get the user's permissions for the given team.
     *
     * @return array<string>
     */
    public function teamPermissions(TeamContract $team): array;

    /**
     * Determine if the user has the given permission on the given team.
     */
    public function hasTeamPermission(TeamContract $team, string $permission): bool;

    /**
     * Get the two factor authentication recovery codes for the user.
     *
     * @return array<int, string>
     */
    public function recoveryCodes(): array;

    /**
     * Replace the given recovery code with a new one in the user's stored codes.
     */
    public function replaceRecoveryCode(string $code): void;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier(): mixed;

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array<string, mixed>
     */
    public function getJWTCustomClaims(): array;

    /**
     * Get the user's roles.
     *
     * @return BelongsToMany<Model, Model>
     */
    public function roles(): BelongsToMany;

    /**
     * Determine if the user has the given role.
     *
     * @param string|int|array<int|string>|UserRole|\Illuminate\Database\Eloquent\Collection<int, UserRole> $roles
     */
    public function hasRole(string|int|array|UserRole|\Illuminate\Database\Eloquent\Collection $roles, ?string $guard = null): bool;

    /**
     * Get the user's authentication logs.
     *
     * @return BelongsToMany<Model, Model>
     */
    public function authentications(): BelongsToMany;

    /**
     * Get the user's socialite accounts.
     *
     * @return BelongsToMany<Model, Model>
     */
    public function socialiteUsers(): BelongsToMany;

    /**
     * Get the user's owned teams.
     *
     * @return BelongsToMany<Model&TeamContract, Model>
     */
    public function ownedTeams(): BelongsToMany;

    /**
     * Get the user's personal team.
     */
    public function personalTeam(): ?TeamContract;

    /**
     * Switch the user's context to the given team.
     */
    public function switchTeam(TeamContract $team): bool;

    /**
     * Get all of the teams the user owns or belongs to.
     *
     * @return Collection<int, Model&TeamContract>
     */
    public function allTeams(): Collection;

    /**
     * Check if the user can access Socialite.
     */
    public function canAccessSocialite(): bool;

    /**
     * Get the current access token being used by the user.
     */
    public function token(): Token|TransientToken|null;

    /**
     * Create a new personal access token for the user.
     *
     * @param array<int, string> $scopes
     *
     * @return PersonalAccessTokenResult<mixed>
     */
    public function createToken(string $name, array $scopes = []): PersonalAccessTokenResult;

    /**
     * Get the user's tenants.
     *
     * @return BelongsToMany<Model, $this>
     *
     * @phpstan-ignore generics.notSubtype
     */
    public function tenants(): BelongsToMany;

    /**
     * Remove a role from the user.
     */
    public function removeRole(mixed ...$role): static;
}
