<?php

declare(strict_types=1);

namespace Modules\DbForge\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\DbForge\Models\DbForgeMigration;

/**
 * DbForgeMigration factory.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\DbForge\Models\DbForgeMigration>
 */
class DbForgeMigrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\DbForge\Models\DbForgeMigration>
     */
    protected $model = DbForgeMigration::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var string $word1 */
        $word1 = $this->faker->word();
        /** @var string $word2 */
        $word2 = $this->faker->word();
        /** @var string $word3 */
        $word3 = $this->faker->word();
        /** @var string $word4 */
        $word4 = $this->faker->word();

        $dateTimestamp = $this->faker->date('Y_m_d_His');
        $dateMonth = $this->faker->date('Y/m');

        return [
            'migration_name' => $word1.'_'.$word2.'_'.$dateTimestamp,
            'migration_path' => 'database/migrations/'.$dateMonth.'/'.$word3.'_'.$word4.'_'.$dateTimestamp.'.php',
            'migration_type' => $this->faker->randomElement(['create', 'update', 'delete', 'modify', 'seed']),
            'status' => $this->faker->randomElement(['pending', 'running', 'completed', 'failed', 'rolled_back']),
            'batch' => $this->faker->optional()->numberBetween(1, 100),
            'created_by' => $this->faker->optional()->numberBetween(1, 100),
            'executed_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'metadata' => [
                'module' => $this->faker->randomElement(['User', 'Cms', 'Quaeris', 'Xot', 'DbForge']),
                'description' => $this->faker->sentence(),
                'version' => $this->faker->semver(),
                'dependencies' => $this->faker->optional()->randomElements(['User', 'Cms', 'Quaeris', 'Xot'], $this->faker->numberBetween(0, 3)),
                'checksum' => $this->faker->sha1(),
            ],
            'settings' => [
                'run_in_background' => $this->faker->boolean(20),
                'force_execution' => $this->faker->boolean(10),
                'skip_transactions' => $this->faker->boolean(5),
                'batch_size' => $this->faker->numberBetween(100, 1000),
                'timeout_seconds' => $this->faker->numberBetween(30, 300),
            ],
        ];
    }

    /**
     * Indicate that the migration is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'executed_at' => null,
        ]);
    }

    /**
     * Indicate that the migration is running.
     */
    public function running(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'running',
            'executed_at' => null,
        ]);
    }

    /**
     * Indicate that the migration is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'executed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Indicate that the migration failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
            'executed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Indicate that the migration was rolled back.
     */
    public function rolledBack(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rolled_back',
            'executed_at' => null,
        ]);
    }

    /**
     * Create a create migration.
     */
    public function createMigration(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'migration_type' => 'create',
                'metadata' => array_merge($existingMetadata, [
                    'table_name' => $this->faker->word(),
                    'primary_key' => 'id',
                    'auto_increment' => true,
                ]),
            ];
        });
    }

    /**
     * Create an update migration.
     */
    public function update(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'migration_type' => 'update',
                'metadata' => array_merge($existingMetadata, [
                    'table_name' => $this->faker->word(),
                    'columns_to_update' => $this->faker->randomElements(['name', 'email', 'status', 'type'], $this->faker->numberBetween(1, 3)),
                ]),
            ];
        });
    }

    /**
     * Create a delete migration.
     */
    public function delete(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'migration_type' => 'delete',
                'metadata' => array_merge($existingMetadata, [
                    'table_name' => $this->faker->word(),
                    'conditions' => [
                        'status' => 'inactive',
                        'created_at' => '< '.$this->faker->date('Y-m-d'),
                    ],
                ]),
            ];
        });
    }

    /**
     * Create a modify migration.
     */
    public function modify(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'migration_type' => 'modify',
                'metadata' => array_merge($existingMetadata, [
                    'table_name' => $this->faker->word(),
                    'columns_to_modify' => $this->faker->randomElements(['name', 'email', 'status', 'type'], $this->faker->numberBetween(1, 3)),
                    'new_columns' => $this->faker->randomElements(['created_by', 'updated_by', 'deleted_at'], $this->faker->numberBetween(0, 2)),
                ]),
            ];
        });
    }

    /**
     * Create a seed migration.
     */
    public function seed(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'migration_type' => 'seed',
                'metadata' => array_merge($existingMetadata, [
                    'table_name' => $this->faker->word(),
                    'seed_count' => $this->faker->numberBetween(10, 1000),
                    'seed_type' => $this->faker->randomElement(['random', 'sequential', 'weighted']),
                ]),
            ];
        });
    }

    /**
     * Create a migration for a specific module.
     */
    public function forModule(string $module): static
    {
        return $this->state(function (array $attributes) use ($module): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'module' => $module,
                ]),
            ];
        });
    }

    /**
     * Create a migration with specific batch.
     */
    public function withBatch(int $batch): static
    {
        return $this->state(fn (array $attributes) => [
            'batch' => $batch,
        ]);
    }

    /**
     * Create a migration executed by specific user.
     */
    public function byUser(int $userId): static
    {
        return $this->state(fn (array $attributes) => [
            'created_by' => $userId,
        ]);
    }

    /**
     * Create a migration with specific settings.
     *
     * @param  array<string, mixed>  $settings
     */
    public function withSettings(array $settings): static
    {
        return $this->state(function (array $attributes) use ($settings): array {
            /** @var array<string, mixed> $existingSettings */
            $existingSettings = is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [];
            /** @var array<string, mixed> $settingsArray */
            $settingsArray = $settings;

            return [
                'settings' => array_merge($existingSettings, $settingsArray),
            ];
        });
    }

    /**
     * Create a migration with specific metadata.
     *
     * @param  array<string, mixed>  $metadata
     */
    public function withMetadata(array $metadata): static
    {
        return $this->state(function (array $attributes) use ($metadata): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];
            /** @var array<string, mixed> $metadataArray */
            $metadataArray = $metadata;

            return [
                'metadata' => array_merge($existingMetadata, $metadataArray),
            ];
        });
    }
}
