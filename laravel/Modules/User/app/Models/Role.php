<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Models\Traits\RelationX;
use Spatie\Permission\Models\Role as SpatieRole;
use Webmozart\Assert\Assert;

/**
 * Modules\User\Models\Role.
 *
 * @property string                                      $id
 * @property string                                      $uuid
 * @property string|null                                 $team_id
 * @property string                                      $name
 * @property string                                      $guard_name
 * @property Carbon|null                                 $created_at
 * @property Carbon|null                                 $updated_at
 * @property Collection<int, Permission>                 $permissions
 * @property int|null                                    $permissions_count
 * @property Team|null                                   $team
 * @property EloquentCollection<int, Model&UserContract> $users
 * @property int|null                                    $users_count
 *
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role permission($permissions)
 * @method static Builder|Role query()
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereGuardName($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereTeamId($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @method static Builder|Role whereUuid($value)
 *
 * @property int $id
 *
 * @method static Builder|Role whereId($value)
 *
 * @property string|null $updated_by
 * @property string|null $created_by
 *
 * @method static Builder|Role whereCreatedBy($value)
 * @method static Builder|Role whereUpdatedBy($value)
 *
 * @mixin Eloquent
 *
 * @method static Builder|Role withoutPermission($permissions)
 *
 * @property PermissionRole|null $pivot
 *
 * @mixin IdeHelperRole
 *
 * @property string|null $display_name
 * @property string|null $description
 *
 * @method static \Modules\User\Database\Factories\RoleFactory factory($count = null, $state = [])
 * @method static Builder<static>|Role                         whereDescription($value)
 * @method static Builder<static>|Role                         whereDisplayName($value)
 * @method static static                                       firstOrCreate(array $attributes, array $values = [])
 * @method static static                                       updateOrCreate(array $attributes, array $values = [])
 *
 * @mixin \Eloquent
 */
class Role extends SpatieRole
{
    use HasXotFactory;
    use RelationX;

    // use HasUuids;

    final public const ROLE_ADMINISTRATOR = 1;

    final public const ROLE_OWNER = 2;

    final public const ROLE_USER = 3;

    /** @var string */
    protected $connection = 'user';

    /** @var string */
    protected $keyType = 'string';

    // protected $fillable=['id','']

    public function getTable(): string
    {
        Assert::string($table = config('permission.table_names.roles'));

        return $table;
    }

    /**
     * Get all of the teams the user belongs to.
     */
    public function team(): BelongsTo
    {
        $xotData = XotData::make();
        /** @var class-string<Model> */
        $teamClass = $xotData->getTeamClass();

        return $this->belongsTo($teamClass);
    }

    /**
     * A role may be given various permissions.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToManyX(Permission::class);
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'name' => 'string',
            'guard_name' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
