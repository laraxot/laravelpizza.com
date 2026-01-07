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
            'plan_name' => $this->faker->randomElement(['basic', 'pro', 'enterprise']),
            'status' => $this->faker->randomElement(['active', 'inactive', 'trial', 'cancelled']),
            'max_users' => $this->faker->numberBetween(1, 1000),
            'current_users' => $this->faker->numberBetween(1, 500),
            'max_storage_gb' => $this->faker->randomFloat(2, 1, 100),
            'current_storage_gb' => $this->faker->randomFloat(2, 0, 50),
            'billing_cycle' => $this->faker->randomElement(['monthly', 'yearly']),
            'billing_amount' => $this->faker->randomFloat(2, 10, 500),
            'next_billing_date' => $this->faker->dateTime,
            'expires_at' => $this->faker->dateTime,
        ];
    }
}
