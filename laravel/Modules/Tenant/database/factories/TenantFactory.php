<?php

namespace Modules\Tenant\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenant\Models\Tenant;

/**
 * @extends Factory<Tenant>
 */
class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'domain' => $this->faker->unique()->domainName(),
            'database' => 'tenant_' . $this->faker->word(),
            'is_active' => $this->faker->boolean(),
            'settings' => json_encode(['timezone' => 'UTC']),
        ];
    }

    /**
     * Indicate that the tenant is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the tenant is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Configure the factory to create a tenant with database configuration.
     */
    public function withDatabaseConfig(): static
    {
        return $this->afterCreating(function (Tenant $tenant) {
            $tenant->database_config()->create([
                'host' => 'localhost',
                'port' => 3306,
                'database' => $tenant->database,
                'username' => 'tenant_user',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ]);
        });
    }

    /**
     * Configure the factory to create a tenant with domains.
     */
    public function withDomains(): static
    {
        return $this->afterCreating(function (Tenant $tenant) {
            $tenant->domains()->create([
                'domain' => $tenant->domain,
                'is_primary' => true,
            ]);

            $tenant->domains()->create([
                'domain' => 'www.' . $tenant->domain,
                'is_primary' => false,
            ]);
        });
    }
}