<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Tenant\Models\Traits\TenantSubscriptionRelations;

/**
 * Subscription plan, limits and billing data of a tenant (`tenant_subscriptions`).
 *
 * The `tenant()` relation lives in {@see TenantSubscriptionRelations}.
 *
 * @property string|null $tenant_id
 * @property string|null $plan_name
 * @property string|null $status
 * @property int|null $max_users
 * @property int|null $current_users
 * @property int|null $max_storage_gb
 * @property int|null $current_storage_gb
 * @property string|null $billing_cycle
 * @property float|null $billing_amount
 * @property Carbon|null $next_billing_date
 * @property Carbon|null $expires_at
 * @property-read Tenant|null $tenant
 *
 * @method static Builder<static>|TenantSubscription newModelQuery()
 * @method static Builder<static>|TenantSubscription newQuery()
 * @method static Builder<static>|TenantSubscription query()
 */
class TenantSubscription extends BaseModel
{
    use TenantSubscriptionRelations;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id',
        'plan_name',
        'status',
        'max_users',
        'current_users',
        'max_storage_gb',
        'current_storage_gb',
        'billing_cycle',
        'billing_amount',
        'next_billing_date',
        'expires_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'next_billing_date' => 'datetime',
            'expires_at' => 'datetime',
        ]);
    }
}
