<?php

declare(strict_types=1);

namespace Modules\DbForge\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\DbForge\Models\DbForgeBackup;

/**
 * DbForgeBackup factory.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\DbForge\Models\DbForgeBackup>
 */
class DbForgeBackupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\DbForge\Models\DbForgeBackup>
     */
    protected $model = DbForgeBackup::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var string $backupPrefix */
        $backupPrefix = $this->faker->randomElement(['daily_backup', 'weekly_backup', 'monthly_backup', 'manual_backup', 'emergency_backup', 'migration_backup', 'table_backup', 'schema_backup']);
        $dateTime = date('Y-m-d_H-i-s');
        $dateMonth = date('Y/m');
        /** @var string $word */
        $word = $this->faker->word();

        return [
            'backup_name' => $backupPrefix.'_'.$dateTime,
            'backup_path' => '/backups/database/'.$dateMonth.'/'.$dateTime.'_'.($word !== '' ? $word : 'backup').'.sql',
            'backup_size' => $this->faker->numberBetween(1024 * 1024, 1024 * 1024 * 1024), // 1MB to 1GB
            'backup_type' => $this->faker->randomElement(['full', 'incremental', 'selective']),
            'status' => $this->faker->randomElement(['pending', 'running', 'completed', 'failed']),
            'retention_days' => $this->faker->randomElement([7, 14, 30, 60, 90, 180, 365]),
            'created_by' => $this->faker->optional()->numberBetween(1, 100),
            'completed_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'metadata' => [
                'compression' => $this->faker->randomElement(['none', 'gzip', 'bzip2', 'lz4']),
                'encryption' => $this->faker->boolean(20),
                'checksum' => $this->faker->sha1(),
                'version' => $this->faker->semver(),
                'tables_included' => $this->faker->randomElements(['users', 'posts', 'comments', 'orders', 'products'], $this->faker->numberBetween(1, 5)),
                'tables_excluded' => $this->faker->optional()->randomElements(['logs', 'temp_data', 'cache'], $this->faker->numberBetween(0, 3)),
            ],
            'settings' => [
                'include_structure' => true,
                'include_data' => $this->faker->boolean(90),
                'include_triggers' => $this->faker->boolean(80),
                'include_procedures' => $this->faker->boolean(70),
                'include_functions' => $this->faker->boolean(70),
                'include_events' => $this->faker->boolean(60),
                'single_transaction' => $this->faker->boolean(80),
                'lock_tables' => $this->faker->boolean(40),
            ],
        ];
    }

    /**
     * Indicate that the backup is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'completed_at' => null,
        ]);
    }

    /**
     * Indicate that the backup is running.
     */
    public function running(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'running',
            'completed_at' => null,
        ]);
    }

    /**
     * Indicate that the backup is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'completed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Indicate that the backup failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
            'completed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Create a full backup.
     */
    public function full(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingSettings */
            $existingSettings = is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [];

            return [
                'backup_type' => 'full',
                'backup_size' => $this->faker->numberBetween(100 * 1024 * 1024, 1024 * 1024 * 1024), // 100MB to 1GB
                'settings' => array_merge(
                    $existingSettings,
                    [
                        'include_structure' => true,
                        'include_data' => true,
                        'include_triggers' => true,
                        'include_procedures' => true,
                        'include_functions' => true,
                        'include_events' => true,
                    ]
                ),
            ];
        });
    }

    /**
     * Create an incremental backup.
     */
    public function incremental(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'backup_type' => 'incremental',
                'backup_size' => $this->faker->numberBetween(10 * 1024 * 1024, 100 * 1024 * 1024), // 10MB to 100MB
                'metadata' => array_merge(
                    $existingMetadata,
                    [
                        'base_backup_id' => $this->faker->numberBetween(1, 1000),
                        'incremental_since' => $this->faker->dateTimeBetween('-1 week', 'now'),
                    ]
                ),
            ];
        });
    }

    /**
     * Create a selective backup.
     */
    public function selective(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'backup_type' => 'selective',
                'backup_size' => $this->faker->numberBetween(1 * 1024 * 1024, 50 * 1024 * 1024), // 1MB to 50MB
                'metadata' => array_merge($existingMetadata, [
                    'tables_included' => $this->faker->randomElements(['users', 'posts', 'comments'], $this->faker->numberBetween(1, 3)),
                    'tables_excluded' => $this->faker->randomElements(['logs', 'temp_data', 'cache', 'sessions'], $this->faker->numberBetween(1, 4)),
                ]),
            ];
        });
    }

    /**
     * Create a daily backup.
     */
    public function daily(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'backup_name' => 'daily_backup_'.$this->faker->date('Y-m-d_H-i-s'),
                'retention_days' => 7,
                'metadata' => array_merge($existingMetadata, [
                    'schedule' => 'daily',
                    'time' => '02:00:00',
                ]),
            ];
        });
    }

    /**
     * Create a weekly backup.
     */
    public function weekly(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'backup_name' => 'weekly_backup_'.$this->faker->date('Y-m-d_H-i-s'),
                'retention_days' => 30,
                'metadata' => array_merge($existingMetadata, [
                    'schedule' => 'weekly',
                    'day' => 'sunday',
                    'time' => '03:00:00',
                ]),
            ];
        });
    }

    /**
     * Create a monthly backup.
     */
    public function monthly(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'backup_name' => 'monthly_backup_'.$this->faker->date('Y-m-d_H-i-s'),
                'retention_days' => 365,
                'metadata' => array_merge($existingMetadata, [
                    'schedule' => 'monthly',
                    'day' => 1,
                    'time' => '04:00:00',
                ]),
            ];
        });
    }

    /**
     * Create a compressed backup.
     */
    public function compressed(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'compression' => $this->faker->randomElement(['gzip', 'bzip2', 'lz4']),
                    'compression_ratio' => $this->faker->randomFloat(2, 0.3, 0.8),
                ]),
            ];
        });
    }

    /**
     * Create an encrypted backup.
     */
    public function encrypted(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'metadata' => array_merge($existingMetadata, [
                    'encryption' => true,
                    'encryption_algorithm' => $this->faker->randomElement(['AES-256', 'ChaCha20', 'Twofish']),
                    'encryption_key_id' => $this->faker->uuid(),
                ]),
            ];
        });
    }

    /**
     * Create a large backup.
     */
    public function large(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'backup_size' => $this->faker->numberBetween(1024 * 1024 * 1024, 10 * 1024 * 1024 * 1024), // 1GB to 10GB
                'metadata' => array_merge($existingMetadata, [
                    'estimated_time' => $this->faker->numberBetween(300, 3600), // 5 minutes to 1 hour
                    'parallel_jobs' => $this->faker->numberBetween(2, 8),
                ]),
            ];
        });
    }

    /**
     * Create a small backup.
     */
    public function small(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'backup_size' => $this->faker->numberBetween(1024 * 1024, 10 * 1024 * 1024), // 1MB to 10MB
                'metadata' => array_merge($existingMetadata, [
                    'estimated_time' => $this->faker->numberBetween(10, 300), // 10 seconds to 5 minutes
                    'parallel_jobs' => 1,
                ]),
            ];
        });
    }

    /**
     * Create a backup with specific retention.
     */
    public function withRetention(int $days): static
    {
        return $this->state(fn (array $attributes) => [
            'retention_days' => $days,
        ]);
    }

    /**
     * Create a backup with specific user.
     */
    public function byUser(int $userId): static
    {
        return $this->state(fn (array $attributes) => [
            'created_by' => $userId,
        ]);
    }

    /**
     * Create a backup for specific tables.
     *
     * @param  array<string>  $tables
     */
    public function forTables(array $tables): static
    {
        return $this->state(function (array $attributes) use ($tables): array {
            /** @var array<string, mixed> $existingMetadata */
            $existingMetadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];

            return [
                'backup_type' => 'selective',
                'metadata' => array_merge($existingMetadata, [
                    'tables_included' => $tables,
                    'tables_excluded' => [],
                ]),
            ];
        });
    }
}
