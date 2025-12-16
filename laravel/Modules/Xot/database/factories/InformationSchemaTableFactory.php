<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Xot\Models\InformationSchemaTable;

/**
 * InformationSchemaTable Factory
 *
 * @extends Factory<InformationSchemaTable>
 */
class InformationSchemaTableFactory extends Factory
{
    protected $model = InformationSchemaTable::class;

    public function definition(): array
    {
        /** @var string $tableName */
        $tableName = $this->faker->randomElement([
            'users',
            'posts',
            'comments',
            'categories',
            'tags',
            'orders',
            'products',
            'customers',
            'invoices',
        ]);

        return [
            'table_catalog' => 'def',
            'table_schema' => $this->faker->randomElement(['<nome progetto>', 'public', 'main']),
            'table_name' => $tableName,
            'table_type' => $this->faker->randomElement(['BASE TABLE', 'VIEW']),
            'engine' => $this->faker->randomElement(['InnoDB', 'MyISAM']),
            'version' => $this->faker->numberBetween(10, 11),
            'row_format' => $this->faker->randomElement(['Dynamic', 'Fixed', 'Compressed']),
            'table_rows' => $this->faker->numberBetween(0, 10000),
            'avg_row_length' => $this->faker->numberBetween(50, 500),
            'data_length' => $this->faker->numberBetween(1024, 1048576),
            'max_data_length' => $this->faker->numberBetween(1048576, 10485760),
            'index_length' => $this->faker->numberBetween(0, 524288),
            'data_free' => $this->faker->numberBetween(0, 1024),
            'auto_increment' => $this->faker->optional()->numberBetween(1, 1000),
            'create_time' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'update_time' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'check_time' => $this->faker->optional()->dateTimeBetween('-1 week', 'now'),
            'table_collation' => 'utf8mb4_unicode_ci',
            'checksum' => $this->faker->optional()->numberBetween(1000000, 9999999),
            'create_options' => '',
            'table_comment' => $this->faker->optional()->sentence(),
        ];
    }

    public function baseTable(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'table_type' => 'BASE TABLE',
        ]);
    }

    public function view(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'table_type' => 'VIEW',
        ]);
    }
}
