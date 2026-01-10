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
use Modules\User\Database\Factories\RoleFactory;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Models\Traits\RelationX;
use Modules\Xot\Traits\Updater;
use Spatie\Permission\Models\Role as SpatieRole;
use Webmozart\Assert\Assert;

/**
 * Modules\User\Models\Role.
 *
 * @property int                                  $id
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
 * @method static RoleFactory          factory($count = null, $state = [])
 * @method static Builder<static>|Role whereDescription($value)
 * @method static Builder<static>|Role whereDisplayName($value)
 * @method static static               firstOrCreate(array $attributes, array $values = [])
 * @method static static               updateOrCreate(array $attributes, array $values = [])
 *
 * @mixin \Eloquent
 */
class Role extends SpatieRole
{
    use HasXotFactory;
    use RelationX;
    use Updater;

    // use HasUuids;

    final public const ROLE_ADMINISTRATOR = 1;

    final public const ROLE_OWNER = 2;

    final public const ROLE_USER = 3;

    /** @var string */
    protected $connection = 'user';

    /** @var string */
    protected $keyType = 'int';

    /** @var list<string> */
    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'description',
        'team_id',
        'created_by',
        'updated_by',
    ];

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
            'id' => 'int',
            'name' => 'string',
            'guard_name' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
