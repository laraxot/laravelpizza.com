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
            'host' => // @var mixed faker->word(
            'port' => 3306,
            'database' => 'tenant_' . // @var mixed faker->word(
            'username' => 'tenant_user',
            'password' => // @var mixed faker->password(
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