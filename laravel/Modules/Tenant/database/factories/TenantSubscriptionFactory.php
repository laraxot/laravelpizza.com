<?php

declare(strict_types=1);

namespace Modules\Tenant\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TenantSubscription;

/**
 * @extends Factory<TenantSubscription>
 */
class TenantSubscriptionFactory extends Factory
{
    protected $model = TenantSubscription::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'plan_name' => ['basic', 'pro', 'enterprise'][array_rand(['basic', 'pro', 'enterprise'])],
            'status' => ['active', 'inactive', 'trial', 'cancelled'][array_rand(['active', 'inactive', 'trial', 'cancelled'])],
            'max_users' => random_int(1, 1000),
            'current_users' => random_int(1, 500),
            'max_storage_gb' => round(random_int(100, 10000) / 100, 2),
            'current_storage_gb' => round(random_int(0, 5000) / 100, 2),
            'billing_cycle' => ['monthly', 'yearly'][array_rand(['monthly', 'yearly'])],
            'billing_amount' => round(random_int(1000, 50000) / 100, 2),
            'next_billing_date' => \Carbon\Carbon::now()->addDays(random_int(1, 365)),
            'expires_at' => \Carbon\Carbon::now()->addDays(random_int(1, 365)),
        ];
    }
}
