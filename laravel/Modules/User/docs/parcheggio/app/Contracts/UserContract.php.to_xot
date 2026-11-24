<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Contracts\Role;

interface UserContract extends Authenticatable
{
    /**
     * Get the primary key for the model.
     */
    public function getKey(): mixed;

    /**
     * Get the current team of the user's context.
     */
    public function currentTeam(): BelongsTo;

    /**
     * Get all of the teams the user belongs to.
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
     */
    public function roles(): BelongsToMany;

    /**
     * Determine if the user has the given role.
     *
     * @param  string|array|Role|\Illuminate\Support\Collection  $roles
     */
    public function hasRole($roles, ?string $guard = null): bool;

    /**
     * Get the user's authentication logs.
     */
    public function authentications(): BelongsToMany;

    /**
     * Get the user's socialite accounts.
     */
    public function socialiteUsers(): BelongsToMany;

    /**
     * Get the user's owned teams.
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
     */
    public function allTeams(): Collection;
}
