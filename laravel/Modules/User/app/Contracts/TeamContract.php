<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Xot\Contracts\ModelContract;
use Modules\Xot\Contracts\UserContract;

/**
 * Modules\User\Contracts\TeamContract.
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int $personal_team
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $role
 * @property UserContract|null $owner
 * @property int|null $team_invitations_count
 * @property int|null $users_count
 *
 * @method static Builder|TeamContract newModelQuery()
 * @method static Builder|TeamContract newQuery()
 * @method static Builder|TeamContract query()
 * @method static Builder|TeamContract whereCreatedAt($value)
 * @method static Builder|TeamContract whereId($value)
 * @method static Builder|TeamContract whereName($value)
 * @method static Builder|TeamContract wherePersonalTeam($value)
 * @method static Builder|TeamContract whereUpdatedAt($value)
 * @method static Builder|TeamContract whereUserId($value)
 *
 * @phpstan-require-extends Model
 *
 * @mixin \Eloquent
 */
interface TeamContract extends ModelContract
{
    /**
     * Get the owner of the team.
     */
    public function owner(): BelongsTo;

    /**
     * Get all of the team's users including its owner.
     */
    public function allUsers(): Collection;

    /**
     * Get all of the users that belong to the team.
     */
    public function users(): BelongsToMany;

    /**
     * Determine if the given user belongs to the team.
     */
    public function hasUser(UserContract $userContract): bool;

    /**
     * Determine if the given email address belongs to a user on the team.
     */
    public function hasUserWithEmail(string $email): bool;

    /**
     * Determine if the given user has the given permission on the team.
     */
    public function userHasPermission(UserContract $userContract, string $permission): bool;

    /**
     * Get all of the pending user invitations for the team.
     */
    public function teamInvitations(): HasMany;

    /**
     * Remove the given user from the team.
     */
    public function removeUser(UserContract $userContract): void;

    /**
     * Purge all of the team's resources.
     */
    public function purge(): void;

    /* --non qui
     * Get the disk that profile photos should be stored on.
     *
     * public function profilePhotoDisk(): string;
     */

    public function members(): BelongsToMany;
}
