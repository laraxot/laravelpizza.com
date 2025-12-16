<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Models\Traits\RelationX;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * @property int                                                       $id
 * @property string                                                    $name
 * @property string                                                    $guard_name
 * @property \Illuminate\Support\Carbon|null                           $created_at
 * @property \Illuminate\Support\Carbon|null                           $updated_at
 * @property string|null                                               $updated_by
 * @property string|null                                               $created_by
 * @property \Illuminate\Database\Eloquent\Collection<int, Permission> $permissions
 * @property int|null                                                  $permissions_count
 * @property \Illuminate\Database\Eloquent\Collection<int, Role>       $roles
 * @property int|null                                                  $roles_count
 * @property \Illuminate\Database\Eloquent\Collection<int, User>       $users
 * @property int|null                                                  $users_count
 *
 * @method static \Modules\User\Database\Factories\PermissionFactory       factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission withoutRole($roles, $guard = null)
 * @method static static                                                   firstOrCreate(array $attributes, array $values = [])
 * @method static static                                                   updateOrCreate(array $attributes, array $values = [])
 *
 * @mixin \Eloquent
 */
class Permission extends SpatiePermission
{
    use RelationX;
    use HasXotFactory;

    /** @var string */
    protected $connection = 'user';

    /** @var string */
    protected $table = 'permissions';

    /** @var list<string> */
    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'description',
    ];
}
