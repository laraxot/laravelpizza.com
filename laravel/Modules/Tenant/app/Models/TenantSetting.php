<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Tenant\Models\Traits\TenantSettingRelations;

/**
 * Key/value setting owned by a tenant (`tenant_settings`).
 *
 * The `tenant()` relation lives in {@see TenantSettingRelations}.
 *
 * @property string|null $tenant_id
 * @property string|null $key
 * @property string|null $value
 * @property string|null $type
 * @property-read Tenant|null $tenant
 *
 * @method static Builder<static>|TenantSetting newModelQuery()
 * @method static Builder<static>|TenantSetting newQuery()
 * @method static Builder<static>|TenantSetting query()
 */
class TenantSetting extends BaseModel
{
    use TenantSettingRelations;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id',
        'key',
        'value',
        'type',
    ];
}
