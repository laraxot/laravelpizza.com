<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Database\Factories\TeamPermissionFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Team Permission Model.
 *
 * Represents a permission assigned to a user within a team context.
 *
 * @property string         $id
 * @property string         $team_id
 * @property string         $user_id
 * @property string         $permission
 * @property \DateTime|null $created_at
 * @property \DateTime|null $updated_at
 * @property Team           $team
 * @property User           $user
 *
 * @method static Builder<static>|TeamPermission newModelQuery()
 * @method static Builder<static>|TeamPermission newQuery()
 * @method static Builder<static>|TeamPermission query()
 *
 * @mixin IdeHelperTeamPermission
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $deleter
 * @property ProfileContract|null $updater
 *
 * @method static TeamPermissionFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class TeamPermission extends BaseModel
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'team_id',
        'user_id',
        'permission',
    ];

    /**
     * Get the team that owns the permission.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the user that owns the permission.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
