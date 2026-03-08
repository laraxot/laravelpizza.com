<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Xot\Models\InformationSchemaTable;

/**
 * InformationSchemaTable Factory.
 *
 * @extends Factory<InformationSchemaTable>
 */
class InformationSchemaTableFactory extends Factory
{
    protected $model = InformationSchemaTable::class;

    public function definition(): array
    {
        /** @var string $tableName */
        $tableName = $faker->randomElement([
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
            'table_schema' => $faker->randomElement(['<nome progetto>', 'public', 'main']
            'table_name' => $tableName,
            'table_type' => $faker->randomElement(['BASE TABLE', 'VIEW']
            'engine' => $faker->randomElement(['InnoDB', 'MyISAM']
            'version' => $faker->numberBetween(10, 11
            'row_format' => $faker->randomElement(['Dynamic', 'Fixed', 'Compressed']
            'table_rows' => $faker->numberBetween(0, 10000
            'avg_row_length' => $faker->numberBetween(50, 500
            'data_length' => $faker->numberBetween(1024, 1048576
            'max_data_length' => $faker->numberBetween(1048576, 10485760
            'index_length' => $faker->numberBetween(0, 524288
            'data_free' => $faker->numberBetween(0, 1024
            'auto_increment' => $faker->optional(
            'create_time' => $faker->dateTimeBetween('-1 year', 'now'
            'update_time' => $faker->optional(
            'check_time' => $faker->optional(
            'table_collation' => 'utf8mb4_unicode_ci',
            'checksum' => $faker->optional(
            'create_options' => '',
            'table_comment' => $faker->optional()
        ];
    }

    public function baseTable(): static
    {
        return $this->state(fn (array $_attributes
            'table_type' => 'BASE TABLE',
        ]);
    }

    public function view(): static
    {
        return $this->state(fn (array $_attributes
            'table_type' => 'VIEW',
        ]);
    }
}
