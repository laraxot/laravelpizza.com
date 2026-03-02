<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * <<<<<<< HEAD
 *
 * @property ProfileContract|null            $creator
 * @property ProfileContract|null            $deleter
 * @property ProfileContract|null            $updater
 * @property string|null                     $name
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null                     $deleted_by
 *
 * @method static \Modules\User\Database\Factories\TeamPermissionFactory factory($count = null, $state = [])
 * @method static Builder<static>|TeamPermission                         whereCreatedAt($value)
 * @method static Builder<static>|TeamPermission                         whereCreatedBy($value)
 * @method static Builder<static>|TeamPermission                         whereDeletedAt($value)
 * @method static Builder<static>|TeamPermission                         whereDeletedBy($value)
 * @method static Builder<static>|TeamPermission                         whereId($value)
 * @method static Builder<static>|TeamPermission                         whereName($value)
 * @method static Builder<static>|TeamPermission                         wherePermission($value)
 * @method static Builder<static>|TeamPermission                         whereTeamId($value)
 * @method static Builder<static>|TeamPermission                         whereUpdatedAt($value)
 * @method static Builder<static>|TeamPermission                         whereUpdatedBy($value)
 *
 * ||||||| parent of da38c10 (.)
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $deleter
 * @property ProfileContract|null $updater
 *
 * =======
 * @property ProfileContract|null            $creator
 * @property ProfileContract|null            $deleter
 * @property ProfileContract|null            $updater
 * @property string|null                     $name
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null                     $deleted_by
 *
 * @method static \Modules\User\Database\Factories\TeamPermissionFactory factory($count = null, $state = [])
 * @method static Builder<static>|TeamPermission                         whereCreatedAt($value)
 * @method static Builder<static>|TeamPermission                         whereCreatedBy($value)
 * @method static Builder<static>|TeamPermission                         whereDeletedAt($value)
 * @method static Builder<static>|TeamPermission                         whereDeletedBy($value)
 * @method static Builder<static>|TeamPermission                         whereId($value)
 * @method static Builder<static>|TeamPermission                         whereName($value)
 * @method static Builder<static>|TeamPermission                         wherePermission($value)
 * @method static Builder<static>|TeamPermission                         whereTeamId($value)
 * @method static Builder<static>|TeamPermission                         whereUpdatedAt($value)
 * @method static Builder<static>|TeamPermission                         whereUpdatedBy($value)
 *                                                                                                           >>>>>>> da38c10 (.)
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
