<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Modules\User\Models\TenantUser.
 *
 * @method static Builder<static>|TenantUser newModelQuery()
 * @method static Builder<static>|TenantUser newQuery()
 * @method static Builder<static>|TenantUser query()
 *
 * @property int $id
 * @property string|null $tenant_id
 * @property string|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static Builder<static>|TenantUser whereCreatedAt($value)
 * @method static Builder<static>|TenantUser whereCreatedBy($value)
 * @method static Builder<static>|TenantUser whereCustomerId($value)
 * @method static Builder<static>|TenantUser whereId($value)
 * @method static Builder<static>|TenantUser whereRole($value)
 * @method static Builder<static>|TenantUser whereTeamId($value)
 * @method static Builder<static>|TenantUser whereUpdatedAt($value)
 * @method static Builder<static>|TenantUser whereUpdatedBy($value)
 * @method static Builder<static>|TenantUser whereUserId($value)
 * @method static Builder<static>|TenantUser whereUuid($value)
 *
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static Builder<static>|TenantUser whereDeletedAt($value)
 * @method static Builder<static>|TenantUser whereDeletedBy($value)
 * @method static Builder<static>|TenantUser whereTenantId($value)
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $deleter
 * @property ProfileContract|null $updater
 *
 * @method static \Modules\User\Database\Factories\TenantUserFactory factory($count = null, $state = [])
 *
 */
class TenantUser extends BasePivot
{
    protected $connection = 'user';

    // public $incrementing = false;

    // protected $primaryKey = 'id';

    // protected $keyType = 'string';

    /** @var list<string> */
    protected $fillable = [
        'tenant_id',
        'user_id',
    ];

    /** @return array<string, string> */
    #[\Override]
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
            // 'email_verified_at' => 'datetime',
            // 'password' => 'hashed', //Call to undefined cast [hashed] on column [password] in model [Modules\User\Models\User].
            // 'is_active' => 'boolean',
            // 'roles.pivot.id' => 'string',
            // https://github.com/beitsafe/laravel-uuid-auditing
            // ALTER TABLE model_has_role CHANGE COLUMN `id` `id` CHAR(37) NOT NULL DEFAULT uuid();
        ];
    }
}
