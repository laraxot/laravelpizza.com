<?php

declare(strict_types=1);

namespace Modules\Tenant\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenant\Models\TenantDomain;

/**
 * @extends Factory<TenantDomain>
 */
class TenantDomainFactory extends Factory
{
    protected $model = TenantDomain::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->domainName,
            'domain' => $this->faker->domainName,
            'is_primary' => $this->faker->boolean,
            'status' => $this->faker->randomElement(['active', 'pending', 'inactive', 'verified', 'unverified']),
            'verification_token' => $this->faker->uuid,
            'verified_at' => $this->faker->dateTime,
        ];
    }
}
