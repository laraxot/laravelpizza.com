<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Modules\User\Database\Factories\PermissionFactory;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Models\Traits\RelationX;
use Modules\Xot\Traits\Updater;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * @property int                         $id
 * @property string                      $name
 * @property string                      $guard_name
 * @property Carbon|null                 $created_at
 * @property Carbon|null                 $updated_at
 * @property string|null                 $updated_by
 * @property string|null                 $created_by
 * @property Collection<int, Permission> $permissions
 * @property int|null                    $permissions_count
 * @property Collection<int, Role>       $roles
 * @property int|null                    $roles_count
 * @property Collection<int, User>       $users
 * @property int|null                    $users_count
 *
 * @method static PermissionFactory          factory($count = null, $state = [])
 * @method static Builder<static>|Permission newModelQuery()
 * @method static Builder<static>|Permission newQuery()
 * @method static Builder<static>|Permission permission($permissions, $without = false)
 * @method static Builder<static>|Permission query()
 * @method static Builder<static>|Permission role($roles, $guard = null, $without = false)
 * @method static Builder<static>|Permission whereCreatedAt($value)
 * @method static Builder<static>|Permission whereCreatedBy($value)
 * @method static Builder<static>|Permission whereGuardName($value)
 * @method static Builder<static>|Permission whereId($value)
 * @method static Builder<static>|Permission whereName($value)
 * @method static Builder<static>|Permission whereUpdatedAt($value)
 * @method static Builder<static>|Permission whereUpdatedBy($value)
 * @method static Builder<static>|Permission withoutPermission($permissions)
 * @method static Builder<static>|Permission withoutRole($roles, $guard = null)
 * @method static static                     firstOrCreate(array $attributes, array $values = [])
 * @method static static                     updateOrCreate(array $attributes, array $values = [])
 *
 * @mixin \Eloquent
 */
class Permission extends SpatiePermission
{
    use HasXotFactory;
    use RelationX;
    use Updater;

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
        'created_by',
        'updated_by',
    ];
}
