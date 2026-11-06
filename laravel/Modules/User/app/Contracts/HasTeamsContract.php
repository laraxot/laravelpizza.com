<?php

declare(strict_types=1);
/**
 * --- Artmin.
 */

namespace Modules\User\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Modules\User\Models\Role;

/**
 * Modules\User\Contracts\HasTeamsContract.
 *
 * @phpstan-require-extends Model
 *
 * @mixin \Eloquent
 */
interface HasTeamsContract
{
    /**
     * Determine if the given team is the current team.
     */
    public function isCurrentTeam(TeamContract $teamContract): bool;

    /**
     * Get the current team of the user's context.
     *
     * @return BelongsTo<Model, Model>
     */
    public function currentTeam(): BelongsTo;

    /**
     * Switch the user's context to the given team.
     */
    public function switchTeam(TeamContract $teamContract): bool;

    /**
     * Get all of the teams the user owns or belongs to.
     *
     * @return Collection<int, Model>
     */
    public function allTeams(): Collection;

    /**
     * Get all of the teams the user owns.
     *
     * @return HasMany<Model, Model>
     */
    public function ownedTeams(): HasMany;

    /**
     * Get all of the teams the user belongs to.
     *
     * @return BelongsToMany<Model, Model>
     */
    public function teams(): BelongsToMany;

    /**
     * Get the user's "personal" team.
     */
    public function personalTeam(): ?TeamContract;

    /**
     * Determine if the user owns the given team.
     */
    public function ownsTeam(TeamContract $teamContract): bool;

    /**
     * Determine if the user belongs to the given team.
     */
    public function belongsToTeam(TeamContract $teamContract): bool;

    /**
     * Get the role that the user has on the team.
     */
    public function teamRole(TeamContract $teamContract): ?Role;

    /**
     * Determine if the user has the given role on the given team.
     */
    public function hasTeamRole(TeamContract $teamContract, string $role): bool;

    /**
     * Get the user's permissions for the given team.
     *
     * @return array<string>
     */
    public function teamPermissions(TeamContract $teamContract): array;

    /**
     * Determine if the user has the given permission on the given team.
     */
    public function hasTeamPermission(TeamContract $teamContract, string $permission): bool;
}
