<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Tenant\Database\Factories\TenantSettingFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * @property int|null $id
 * @property string|null $tenant_id
 * @property string|null $key
 * @property string|null $value
 * @property string|null $type
 *
 * @method static Builder|TenantSetting newModelQuery()
 * @method static Builder|TenantSetting newQuery()
 * @method static Builder|TenantSetting query()
 * @method static Builder|TenantSetting whereId($value)
 * @method static Builder|TenantSetting whereTenantId($value)
 * @method static Builder|TenantSetting whereKey($value)
 * @method static Builder|TenantSetting whereValue($value)
 * @method static Builder|TenantSetting whereType($value)
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property ProfileContract|null $deleter
 *
 * @method static TenantSettingFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class TenantSetting extends BaseModel
{
    protected $fillable = [
        'tenant_id',
        'key',
        'value',
        'type',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
