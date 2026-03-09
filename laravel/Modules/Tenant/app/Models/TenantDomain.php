<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Database\Factories\DomainFactory;
use Modules\Xot\Contracts\ProfileContract;
use Sushi\Sushi;

/**
 * @property int|null $id
 * @property string|int|null $tenant_id
 * @property string|null $name
 * @property string|null $domain
 * @property bool|null $is_primary
 * @property string|null $status
 * @property string|null $verification_token
 * @property \Carbon\Carbon|null $verified_at
 * @method static Builder|TenantDomain newModelQuery()
 * @method static Builder|TenantDomain newQuery()
 * @method static Builder|TenantDomain query()
 * @method static Builder|TenantDomain whereId($value)
 * @method static Builder|TenantDomain whereName($value)
 * @method static Builder|TenantDomain whereDomain($value)
 * @method static Builder|TenantDomain whereIsPrimary($value)
 * @method static Builder|TenantDomain whereStatus($value)
 * @method static Builder|TenantDomain whereVerificationToken($value)
 * @method static Builder|TenantDomain whereVerifiedAt($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property ProfileContract|null $deleter
 * @method static DomainFactory factory($count = null, $state = [])
 * @mixin \Eloquent
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
     */
    public function getRows(): array
    {
        return app(GetDomainsArrayAction::class)->execute();
    }
}
