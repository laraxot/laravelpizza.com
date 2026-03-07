<?php

namespace Modules\Tenant\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenant\Models\DatabaseConfig;

/**
 * @extends Factory<DatabaseConfig>
 */
class DatabaseConfigFactory extends Factory
{
    protected $model = DatabaseConfig::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'host' => $this->faker->word() . '_host',
            'port' => 3306,
            'database' => 'tenant_' . $this->faker->word(),
            'username' => 'tenant_user',
            'password' => $this->faker->password(),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => [],
        ];
    }
}