<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Modules\User\Database\Factories\TeamFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Class Modules\User\Models\Team.
 *
 * @property string                          $id
 * @property string                          $user_id                (DC2Type:guid)
 * @property string                          $name
 * @property int                             $personal_team
 * @property Carbon|null                     $created_at
 * @property Carbon|null                     $updated_at
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 * @property Carbon|null                     $deleted_at
 * @property string|null                     $deleted_by
 * @property ProfileContract|null            $creator
 * @property TeamUser                        $pivot
 * @property Collection<int, User>           $members
 * @property int|null                        $members_count
 * @property User|null                       $owner
 * @property Collection<int, TeamInvitation> $teamInvitations
 * @property int|null                        $team_invitations_count
 * @property ProfileContract|null            $updater
 * @property Collection<int, User>           $users
 * @property int|null                        $users_count
 *
 * @method static TeamFactory  factory($count = null, $state = [])
 * @method static Builder|Team newModelQuery()
 * @method static Builder|Team newQuery()
 * @method static Builder|Team query()
 * @method static Builder|Team whereCreatedAt($value)
 * @method static Builder|Team whereCreatedBy($value)
 * @method static Builder|Team whereDeletedAt($value)
 * @method static Builder|Team whereDeletedBy($value)
 * @method static Builder|Team whereId($value)
 * @method static Builder|Team whereName($value)
 * @method static Builder|Team wherePersonalTeam($value)
 * @method static Builder|Team whereUpdatedAt($value)
 * @method static Builder|Team whereUpdatedBy($value)
 * @method static Builder|Team whereUserId($value)
 *
 * @property string|null $code
 *
 * @method static Builder|Team whereCode($value)
 *
 * @property string|null $uuid
 *
 * @method static Builder<static>|Team whereUuid($value)
 *
 * @property string|null $owner_id
 *
 * @method static Builder<static>|Team whereOwnerId($value)
 * @method static static               create(array $attributes = [])
 * @method static static               firstOrCreate(array $attributes, array $values = [])
 * @method static static               updateOrCreate(array $attributes, array $values = [])
 *
 * @mixin IdeHelperTeam
 *
 * @property ProfileContract|null $deleter
 *
 * @mixin \Eloquent
 */
class Team extends BaseTeam
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'avatar_path',
        'personal_team',
        'settings',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'personal_team' => 'boolean',
            'settings' => 'array',
        ];
    }

    public function permissions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TeamPermission::class);
    }
}
