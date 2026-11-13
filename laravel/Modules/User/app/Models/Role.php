<?php

declare(strict_types=1);
/**
 * ---.
 */

namespace Modules\User\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\User\Models\Traits\RoleRelationsTrait;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Models\Traits\RelationX;
use Modules\Xot\Traits\Updater;
use Spatie\Permission\Models\Role as SpatieRole;
use Webmozart\Assert\Assert;

/**
 * Modules\User\Models\Role.
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $team_id
 * @property string $name
 * @property string $guard_name
 * @property string|null $display_name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Collection<int, Permission> $permissions
 * @property int|null $permissions_count
 * @property Team|null $team
 * @property Collection<int, Model&UserContract> $users
 * @property int|null $users_count
 * @property PermissionRole|null $pivot
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
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereCreatedBy($value)
 * @method static Builder|Role whereUpdatedBy($value)
 * @method static Builder|Role withoutPermission($permissions)
 * @method static Builder|Role whereDescription($value)
 * @method static Builder|Role whereDisplayName($value)
 * @method static static firstOrCreate(array<string, mixed> $attributes, array<string, mixed> $values = [])
 * @method static static updateOrCreate(array<string, mixed> $attributes, array<string, mixed> $values = [])
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $deleter
 * @property ProfileContract|null $updater
 *
 * @method static \Modules\User\Database\Factories\RoleFactory factory($count = null, $state = [])
 * @method static Builder<static>|Role whereUuid($value)
 *
 * @mixin \Eloquent
 */
class Role extends SpatieRole
{
    use HasXotFactory;
    use RelationX;
    use RoleRelationsTrait;
    use Updater;

    // use HasUuids;

    protected $connection = 'user';

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

    /**
     * Ruolo che apre ogni porta: assegnarlo equivale a creare un super-admin.
     */
    public const string SUPER_ADMIN = 'super-admin';

    public function getTable(): string
    {
        Assert::string($table = config('permission.table_names.roles'));

        return $table;
    }

    /**
     * Solo un super-admin ne crea un altro: `admin` e `user::admin` modificano gli utenti ma non si fanno super-admin.
     * Il resto della gerarchia (chi assegna quale ruolo) e' una decisione aperta: oggi e' l'unica regola.
     */
    public static function mayAssignSuperAdmin(?Authenticatable $actor): bool
    {
        return $actor instanceof UserContract && $actor->hasRole(self::SUPER_ADMIN);
    }

    /**
     * Toglie dalla query i ruoli che `$actor` non puo' assegnare. Si applica alle opzioni e alla lettura del valore
     * ricevuto: il form e' controllato dal client, l'elenco filtrato da solo non basta.
     *
     * @template TModel of Model
     *
     * @param  Builder<TModel>  $query
     * @return Builder<TModel>
     */
    public static function restrictAssignableBy(Builder $query, ?Authenticatable $actor): Builder
    {
        if (self::mayAssignSuperAdmin($actor)) {
            return $query;
        }

        return $query->where($query->qualifyColumn('name'), '!=', self::SUPER_ADMIN);
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

    use RoleRelationsTrait;
}
