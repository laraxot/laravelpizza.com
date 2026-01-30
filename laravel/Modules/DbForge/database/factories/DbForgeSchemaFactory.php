<?php

declare(strict_types=1);

namespace Modules\DbForge\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

// use Modules\DbForge\Models\DbForgeSchema; // Model not found

/**
 * DbForgeSchema factory.
 *
 * NOTE: Model not found - using stdClass temporarily
 */
class DbForgeSchemaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string
     *
     * @phpstan-ignore property.phpDocType
     */
    protected $model = \stdClass::class; // Using stdClass since DbForgeSchema model not found

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'table_name' => $this->faker->randomElement(['users', 'posts', 'comments', 'orders', 'products', 'categories', 'tags', 'permissions', 'roles', 'settings', 'logs', 'notifications', 'migrations', 'failed_jobs', 'password_resets', 'personal_access_tokens']),
            'table_comment' => $this->faker->optional()->sentence(),
            'engine' => $this->faker->randomElement(['InnoDB', 'MyISAM', 'MEMORY', 'CSV', 'ARCHIVE']),
            'collation' => $this->faker->randomElement(['utf8mb4_unicode_ci', 'utf8mb4_general_ci', 'utf8_unicode_ci', 'latin1_swedish_ci']),
            'row_format' => $this->faker->randomElement(['Dynamic', 'Fixed', 'Compressed', 'Redundant']),
            'table_rows' => $this->faker->numberBetween(0, 1000000),
            'avg_row_length' => $this->faker->numberBetween(100, 10000),
            'data_length' => $this->faker->numberBetween(1024, 1073741824), // 1KB to 1GB
            'max_data_length' => $this->faker->optional()->numberBetween(0, 9223372036854775807),
            'index_length' => $this->faker->numberBetween(1024, 536870912), // 1KB to 512MB
            'data_free' => $this->faker->optional()->numberBetween(0, 1048576), // 0 to 1MB
            'auto_increment' => $this->faker->optional()->numberBetween(1, 1000000),
            'create_time' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'update_time' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'check_time' => $this->faker->optional()->dateTimeBetween('-6 months', 'now'),
            'checksum' => $this->faker->optional()->numberBetween(0, 4294967295),
            'create_options' => $this->faker->optional()->randomElement(['', 'partitioned', 'temporary']),
            'table_catalog' => $this->faker->randomElement(['def', 'information_schema', 'mysql', 'performance_schema']),
            'table_schema' => $this->faker->randomElement(['app_db', 'test_db', 'staging_db', 'production_db', 'backup_db']),
            'version' => $this->faker->numberBetween(1, 10),
            'is_active' => $this->faker->boolean(90),
            'last_analyzed' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'last_optimized' => $this->faker->optional()->dateTimeBetween('-3 months', 'now'),
            'metadata' => [
                'columns_count' => $this->faker->numberBetween(3, 50),
                'indexes_count' => $this->faker->numberBetween(1, 20),
                'foreign_keys_count' => $this->faker->numberBetween(0, 10),
                'triggers_count' => $this->faker->numberBetween(0, 5),
                'views_count' => $this->faker->numberBetween(0, 3),
                'stored_procedures_count' => $this->faker->numberBetween(0, 5),
                'functions_count' => $this->faker->numberBetween(0, 3),
                'events_count' => $this->faker->numberBetween(0, 2),
                'partitioned' => $this->faker->boolean(20),
                'partition_count' => $this->faker->optional()->numberBetween(2, 16),
                'compression' => $this->faker->optional()->randomElement(['NONE', 'ZLIB', 'LZ4', 'ZSTD']),
                'encryption' => $this->faker->boolean(10),
                'tablespace' => $this->faker->optional()->randomElement(['innodb_system', 'innodb_file_per_table', 'innodb_undo']),
                'row_security' => $this->faker->boolean(5),
                'force_row_level_security' => $this->faker->boolean(5),
                'inherit' => $this->faker->optional()->randomElement(['', 'parent_table']),
                'persistence' => $this->faker->randomElement(['PERMANENT', 'TEMPORARY']),
                'log' => $this->faker->boolean(30),
                'temporary' => $this->faker->boolean(10),
                'unlogged' => $this->faker->boolean(5),
                'oids' => $this->faker->boolean(5),
                'on_commit' => $this->faker->optional()->randomElement(['DROP', 'DELETE ROWS', 'PRESERVE ROWS']),
                'parallel_workers' => $this->faker->optional()->numberBetween(1, 8),
                'fillfactor' => $this->faker->optional()->numberBetween(10, 100),
                'autovacuum_enabled' => $this->faker->boolean(80),
                'autovacuum_vacuum_threshold' => $this->faker->optional()->numberBetween(50, 1000),
                'autovacuum_analyze_threshold' => $this->faker->optional()->numberBetween(50, 1000),
                'autovacuum_vacuum_scale_factor' => $this->faker->optional()->randomFloat(2, 0.1, 0.5),
                'autovacuum_analyze_scale_factor' => $this->faker->optional()->randomFloat(2, 0.1, 0.5),
                'autovacuum_vacuum_cost_limit' => $this->faker->optional()->numberBetween(100, 10000),
                'autovacuum_vacuum_cost_delay' => $this->faker->optional()->randomFloat(2, 0.1, 2.0),
                'autovacuum_freeze_min_age' => $this->faker->optional()->numberBetween(1000000, 10000000),
                'autovacuum_freeze_max_age' => $this->faker->optional()->numberBetween(100000000, 200000000),
                'autovacuum_freeze_table_age' => $this->faker->optional()->numberBetween(100000000, 200000000),
                'autovacuum_multixact_freeze_min_age' => $this->faker->optional()->numberBetween(1000000, 10000000),
                'autovacuum_multixact_freeze_max_age' => $this->faker->optional()->numberBetween(100000000, 200000000),
                'autovacuum_multixact_freeze_table_age' => $this->faker->optional()->numberBetween(100000000, 200000000),
                'toast_tuple_target' => $this->faker->optional()->numberBetween(2048, 8192),
                'autovacuum_vacuum_insert_threshold' => $this->faker->optional()->numberBetween(1000, 10000),
                'autovacuum_vacuum_insert_scale_factor' => $this->faker->optional()->randomFloat(2, 0.1, 0.5),
                'user_catalog_table' => $this->faker->boolean(5),
                'is_insert_only' => $this->faker->boolean(5),
                'has_oids' => $this->faker->boolean(5),
                'relispartition' => $this->faker->boolean(20),
                'relispartition_parent' => $this->faker->boolean(5),
                'relpartbound' => $this->faker->optional()->text(),
                'relhasindex' => $this->faker->boolean(80),
                'relhasrules' => $this->faker->boolean(20),
                'relhastriggers' => $this->faker->boolean(30),
                'relhasoids' => $this->faker->boolean(5),
                'relhasprimarykey' => $this->faker->boolean(90),
                'relhasforeignkeys' => $this->faker->boolean(40),
                'relhascheck' => $this->faker->boolean(30),
                'relhaspartialindexes' => $this->faker->boolean(20),
                'relhasreplident' => $this->faker->boolean(10),
                'relisreplicated' => $this->faker->boolean(10),
                'relfrozenxid' => $this->faker->optional()->numberBetween(1000000, 10000000),
                'relminmxid' => $this->faker->optional()->numberBetween(1000000, 10000000),
                'relacl' => $this->faker->optional()->text(),
                'reloptions' => $this->faker->optional()->text(),
                'relpartbound_expr' => $this->faker->optional()->text(),
            ],
            'settings' => [
                'auto_increment_increment' => $this->faker->optional()->numberBetween(1, 10),
                'auto_increment_offset' => $this->faker->optional()->numberBetween(1, 10),
                'character_set_name' => $this->faker->randomElement(['utf8mb4', 'utf8', 'latin1', 'ascii']),
                'collation_name' => $this->faker->randomElement(['utf8mb4_unicode_ci', 'utf8mb4_general_ci', 'utf8_unicode_ci', 'latin1_swedish_ci']),
                'table_type' => $this->faker->randomElement(['BASE TABLE', 'VIEW', 'SYSTEM VIEW', 'LOCAL TEMPORARY', 'GLOBAL TEMPORARY']),
                'table_collation' => $this->faker->randomElement(['utf8mb4_unicode_ci', 'utf8mb4_general_ci', 'utf8_unicode_ci', 'latin1_swedish_ci']),
                'checksum' => $this->faker->optional()->numberBetween(0, 4294967295),
                'create_options' => $this->faker->optional()->sentence(),
                'table_comment' => $this->faker->optional()->sentence(),
                'max_index_length' => $this->faker->optional()->numberBetween(0, 1073741824),
                'temporary' => $this->faker->optional()->randomElement(['', 'Y', 'N']),
                'update_time' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
                'check_time' => $this->faker->optional()->dateTimeBetween('-6 months', 'now'),
                'table_rows' => $this->faker->optional()->numberBetween(0, 1000000),
                'avg_row_length' => $this->faker->optional()->numberBetween(100, 10000),
                'data_length' => $this->faker->optional()->numberBetween(1024, 1073741824),
                'max_data_length' => $this->faker->optional()->numberBetween(0, 9223372036854775807),
                'index_length' => $this->faker->optional()->numberBetween(1024, 536870912),
                'data_free' => $this->faker->optional()->numberBetween(0, 1048576),
                'auto_increment' => $this->faker->optional()->numberBetween(1, 1000000),
                'create_time' => $this->faker->optional()->dateTimeBetween('-2 years', 'now'),
                'table_catalog' => $this->faker->optional()->randomElement(['def', 'information_schema', 'mysql', 'performance_schema']),
                'table_schema' => $this->faker->optional()->randomElement(['app_db', 'test_db', 'staging_db', 'production_db', 'backup_db']),
                'version' => $this->faker->optional()->numberBetween(1, 10),
                'is_active' => $this->faker->optional()->boolean(90),
                'last_analyzed' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
                'last_optimized' => $this->faker->optional()->dateTimeBetween('-3 months', 'now'),
            ],
        ];
    }

    /**
     * Indicate that the table is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the table is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Create a large table.
     */
    public function large(): static
    {
        return $this->state(fn (array $attributes) => [
            'table_rows' => $this->faker->numberBetween(100000, 10000000),
            'avg_row_length' => $this->faker->numberBetween(5000, 50000),
            'data_length' => $this->faker->numberBetween(1073741824, 10737418240), // 1GB to 10GB
            'index_length' => $this->faker->numberBetween(536870912, 2147483648), // 512MB to 2GB
        ]);
    }

    /**
     * Create a small table.
     */
    public function small(): static
    {
        return $this->state(fn (array $attributes) => [
            'table_rows' => $this->faker->numberBetween(0, 1000),
            'avg_row_length' => $this->faker->numberBetween(100, 1000),
            'data_length' => $this->faker->numberBetween(1024, 1048576), // 1KB to 1MB
            'index_length' => $this->faker->numberBetween(1024, 1048576), // 1KB to 1MB
        ]);
    }

    /**
     * Create a partitioned table.
     */
    public function partitioned(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'partitioned' => true,
                    'partition_count' => $this->faker->numberBetween(2, 16),
                ]),
            ];
        });
    }

    /**
     * Create a non-partitioned table.
     */
    public function notPartitioned(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'partitioned' => false,
                    'partition_count' => null,
                ]),
            ];
        });
    }

    /**
     * Create a compressed table.
     */
    public function compressed(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'compression' => $this->faker->randomElement(['ZLIB', 'LZ4', 'ZSTD']),
                ]),
            ];
        });
    }

    /**
     * Create an uncompressed table.
     */
    public function uncompressed(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'compression' => 'NONE',
                ]),
            ];
        });
    }

    /**
     * Create an encrypted table.
     */
    public function encrypted(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'encryption' => true,
                ]),
            ];
        });
    }

    /**
     * Create an unencrypted table.
     */
    public function unencrypted(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'encryption' => false,
                ]),
            ];
        });
    }

    /**
     * Create a temporary table.
     */
    public function temporary(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'temporary' => true,
                    'persistence' => 'TEMPORARY',
                ]),
            ];
        });
    }

    /**
     * Create a permanent table.
     */
    public function permanent(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'temporary' => false,
                    'persistence' => 'PERMANENT',
                ]),
            ];
        });
    }

    /**
     * Create a table with many columns.
     */
    public function manyColumns(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'columns_count' => $this->faker->numberBetween(20, 100),
                ]),
            ];
        });
    }

    /**
     * Create a table with few columns.
     */
    public function fewColumns(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'columns_count' => $this->faker->numberBetween(3, 10),
                ]),
            ];
        });
    }

    /**
     * Create a table with many indexes.
     */
    public function manyIndexes(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'indexes_count' => $this->faker->numberBetween(10, 30),
                ]),
            ];
        });
    }

    /**
     * Create a table with few indexes.
     */
    public function fewIndexes(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'indexes_count' => $this->faker->numberBetween(1, 5),
                ]),
            ];
        });
    }

    /**
     * Create a table with foreign keys.
     */
    public function withForeignKeys(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'relhasforeignkeys' => true,
                    'foreign_keys_count' => $this->faker->numberBetween(1, 10),
                ]),
            ];
        });
    }

    /**
     * Create a table without foreign keys.
     */
    public function withoutForeignKeys(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'relhasforeignkeys' => false,
                    'foreign_keys_count' => 0,
                ]),
            ];
        });
    }

    /**
     * Create a table with triggers.
     */
    public function withTriggers(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'relhastriggers' => true,
                    'triggers_count' => $this->faker->numberBetween(1, 5),
                ]),
            ];
        });
    }

    /**
     * Create a table without triggers.
     */
    public function withoutTriggers(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'relhastriggers' => false,
                    'triggers_count' => 0,
                ]),
            ];
        });
    }

    /**
     * Create a table with rules.
     */
    public function withRules(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'relhasrules' => true,
                ]),
            ];
        });
    }

    /**
     * Create a table without rules.
     */
    public function withoutRules(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'relhasrules' => false,
            ]),
        ]);
    }

    /**
     * Create a table with checks.
     */
    public function withChecks(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'relhascheck' => true,
            ]),
        ]);
    }

    /**
     * Create a table without checks.
     */
    public function withoutChecks(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'relhascheck' => false,
            ]),
        ]);
    }

    /**
     * Create a table for a specific database.
     */
    public function forDatabase(string $databaseName): static
    {
        return $this->state(fn (array $attributes) => [
            'table_schema' => $databaseName,
        ]);
    }

    /**
     * Create a table with specific engine.
     */
    public function withEngine(string $engine): static
    {
        return $this->state(fn (array $attributes) => [
            'engine' => $engine,
        ]);
    }

    /**
     * Create a table with specific collation.
     */
    public function withCollation(string $collation): static
    {
        return $this->state(fn (array $attributes) => [
            'collation' => $collation,
        ]);
    }

    /**
     * Create a table with specific row format.
     */
    public function withRowFormat(string $rowFormat): static
    {
        return $this->state(fn (array $attributes) => [
            'row_format' => $rowFormat,
        ]);
    }

    /**
     * Create a table with specific character set.
     */
    public function withCharacterSet(string $characterSet): static
    {
        return $this->state(function (array $attributes) use ($characterSet): array {
            /** @var array<string, mixed> $existingSettings */
            $existingSettings = is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [];

            return [
                'settings' => array_merge($existingSettings, [
                    'character_set_name' => $characterSet,
                ]),
            ];
        });
    }

    /**
     * Create a table that was recently created.
     */
    public function recentlyCreated(): static
    {
        return $this->state(fn (array $attributes) => [
            'create_time' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Create a table that was created long ago.
     */
    public function old(): static
    {
        return $this->state(fn (array $attributes) => [
            'create_time' => $this->faker->dateTimeBetween('-5 years', '-2 years'),
        ]);
    }

    /**
     * Create a table that was recently updated.
     */
    public function recentlyUpdated(): static
    {
        return $this->state(fn (array $attributes) => [
            'update_time' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Create a table that was recently analyzed.
     */
    public function recentlyAnalyzed(): static
    {
        return $this->state(fn (array $attributes) => [
            'last_analyzed' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Create a table that was recently optimized.
     */
    public function recentlyOptimized(): static
    {
        return $this->state(fn (array $attributes) => [
            'last_optimized' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }
}
