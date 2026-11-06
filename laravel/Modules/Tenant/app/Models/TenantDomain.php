<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Sushi\Sushi;

/**
 * @property string|null $id
 * @property string|null $tenant_id
 * @property string|null $name
 * @property string|null $domain
 * @property bool $is_primary
 * @property string|null $status
 * @property string|null $verification_token
 * @property Carbon|null $verified_at
 *
 * @method static Builder<static>|TenantDomain newModelQuery()
 * @method static Builder<static>|TenantDomain newQuery()
 * @method static Builder<static>|TenantDomain query()
 * @method static Builder<static>|TenantDomain whereId($value)
 * @method static Builder<static>|TenantDomain whereName($value)
 *
 */
class TenantDomain extends BaseModel
{
    use Sushi;

    protected $fillable = [
        'tenant_id',
        'name',
        'domain',
        'is_primary',
        'status',
        'verification_token',
        'verified_at',
    ];

    /**
     * Model Rows.
     *
     * @return array<int, array<string, string>>
     */
    public function getRows(): array
    {
        return app(GetDomainsArrayAction::class)->execute();
    }
}
