<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CloudStorage\Models\CloudStorageProvider;

/**
 * CloudStorageProvider factory.
 *
 * @extends Factory<CloudStorageProvider>
 */
class CloudStorageProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<CloudStorageProvider>
     */
    protected $model = CloudStorageProvider::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Google Drive', 'Dropbox', 'AWS S3', 'Azure Blob', 'Local Storage']),
            'provider_key' => $this->faker->randomElement(['google_drive', 'dropbox', 'aws_s3', 'azure_blob', 'local']),
            'api_key' => $this->faker->sha1(),
            'api_secret' => $this->faker->sha1(),
            'access_token' => $this->faker->sha1(),
            'refresh_token' => $this->faker->optional()->sha1(),
            'bucket_name' => $this->faker->optional()->word(),
            'region' => $this->faker->optional()->randomElement(['us-east-1', 'eu-west-1', 'ap-southeast-1']),
            'endpoint' => $this->faker->optional()->url(),
            'is_active' => $this->faker->boolean(80),
            'is_default' => $this->faker->boolean(20),
            'priority' => $this->faker->numberBetween(1, 10),
            'max_file_size' => $this->faker->numberBetween(104857600, 107374182400), // 100MB to 100GB
            'max_storage_size' => $this->faker->numberBetween(107374182400, 1099511627776), // 100GB to 1TB
            'used_storage_size' => $this->faker->numberBetween(0, 107374182400), // 0 to 100GB
            'file_count' => $this->faker->numberBetween(0, 100000),
            'folder_count' => $this->faker->numberBetween(0, 10000),
            'status' => $this->faker->randomElement(['active', 'inactive', 'maintenance', 'error']),
            'last_sync_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'last_error_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'error_message' => $this->faker->optional()->sentence(),
            'retry_count' => $this->faker->numberBetween(0, 10),
            'max_retries' => $this->faker->numberBetween(3, 10),
            'settings' => [
                'encryption_enabled' => $this->faker->boolean(60),
                'compression_enabled' => $this->faker->boolean(40),
                'cdn_enabled' => $this->faker->boolean(70),
                'versioning_enabled' => $this->faker->boolean(50),
                'lifecycle_policy' => $this->faker->optional()->randomElement(['standard', 'intelligent_tiering', 'glacier']),
                'sync_interval' => $this->faker->randomElement(['realtime', 'hourly', 'daily', 'weekly']),
                'backup_enabled' => $this->faker->boolean(80),
                'virus_scan_enabled' => $this->faker->boolean(90),
                'watermark_enabled' => $this->faker->boolean(30),
                'thumbnail_enabled' => $this->faker->boolean(85),
            ],
            'metadata' => [
                'provider_type' => $this->faker->randomElement(['cloud', 'local', 'hybrid']),
                'supported_formats' => $this->faker->randomElements(['pdf', 'doc', 'jpg', 'png', 'mp4', 'zip'], $this->faker->numberBetween(3, 6)),
                'features' => $this->faker->randomElements(['encryption', 'compression', 'cdn', 'versioning', 'backup'], $this->faker->numberBetween(2, 5)),
                'pricing_tier' => $this->faker->randomElement(['free', 'basic', 'premium', 'enterprise']),
                'support_level' => $this->faker->randomElement(['basic', 'standard', 'premium', 'dedicated']),
                'uptime_percentage' => $this->faker->randomFloat(2, 95, 99.99),
                'response_time_ms' => $this->faker->numberBetween(10, 500),
            ],
        ];
    }

    /**
     * Indicate that the provider is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the provider is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
            'status' => 'inactive',
        ]);
    }

    /**
     * Indicate that the provider is in maintenance.
     */
    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'maintenance',
        ]);
    }

    /**
     * Indicate that the provider has an error.
     */
    public function error(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'error',
            'error_message' => $this->faker->sentence(),
            'last_error_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * Create a default provider.
     */
    public function default(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_default' => true,
            'priority' => 1,
        ]);
    }

    /**
     * Create a non-default provider.
     */
    public function notDefault(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_default' => false,
            'priority' => $this->faker->numberBetween(2, 10),
        ]);
    }

    /**
     * Create a Google Drive provider.
     */
    public function googleDrive(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Google Drive',
            'provider_key' => 'google_drive',
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'provider_type' => 'cloud',
                'features' => ['encryption', 'compression', 'cdn', 'versioning', 'backup'],
            ]),
        ]);
    }

    /**
     * Create a Dropbox provider.
     */
    public function dropbox(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Dropbox',
            'provider_key' => 'dropbox',
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'provider_type' => 'cloud',
                'features' => ['encryption', 'compression', 'versioning'],
            ]),
        ]);
    }

    /**
     * Create an AWS S3 provider.
     */
    public function awsS3(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'AWS S3',
            'provider_key' => 'aws_s3',
            'region' => $this->faker->randomElement(['us-east-1', 'eu-west-1', 'ap-southeast-1']),
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'provider_type' => 'cloud',
                'features' => ['encryption', 'compression', 'cdn', 'versioning', 'backup', 'lifecycle'],
            ]),
        ]);
    }

    /**
     * Create an Azure Blob provider.
     */
    public function azureBlob(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Azure Blob',
            'provider_key' => 'azure_blob',
            'region' => $this->faker->randomElement(['eastus', 'westeurope', 'southeastasia']),
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'provider_type' => 'cloud',
                'features' => ['encryption', 'compression', 'cdn', 'versioning'],
            ]),
        ]);
    }

    /**
     * Create a local storage provider.
     */
    public function local(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Local Storage',
            'provider_key' => 'local',
            'endpoint' => '/storage/app/public',
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'provider_type' => 'local',
                'features' => ['encryption', 'compression'],
            ]),
        ]);
    }

    /**
     * Create a provider with high priority.
     */
    public function highPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => $this->faker->numberBetween(1, 3),
        ]);
    }

    /**
     * Create a provider with low priority.
     */
    public function lowPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => $this->faker->numberBetween(8, 10),
        ]);
    }

    /**
     * Create a provider with large storage capacity.
     */
    public function largeCapacity(): static
    {
        return $this->state(fn (array $attributes) => [
            'max_storage_size' => $this->faker->numberBetween(1099511627776, 10995116277760), // 1TB to 10TB
        ]);
    }

    /**
     * Create a provider with small storage capacity.
     */
    public function smallCapacity(): static
    {
        return $this->state(fn (array $attributes) => [
            'max_storage_size' => $this->faker->numberBetween(107374182400, 536870912000), // 100GB to 500GB
        ]);
    }

    /**
     * Create a provider with many files.
     */
    public function withManyFiles(): static
    {
        return $this->state(fn (array $attributes) => [
            'file_count' => $this->faker->numberBetween(10000, 1000000),
            'folder_count' => $this->faker->numberBetween(1000, 100000),
        ]);
    }

    /**
     * Create a provider with few files.
     */
    public function withFewFiles(): static
    {
        return $this->state(fn (array $attributes) => [
            'file_count' => $this->faker->numberBetween(0, 1000),
            'folder_count' => $this->faker->numberBetween(0, 100),
        ]);
    }

    /**
     * Create a provider with high usage.
     */
    public function highUsage(): static
    {
        return $this->state(fn (array $attributes) => [
            'used_storage_size' => $this->faker->numberBetween(
                (int) ((is_numeric($attributes['max_storage_size'] ?? 0) ? (float) ($attributes['max_storage_size'] ?? 0) : 0) * 0.8),
                (int) ((is_numeric($attributes['max_storage_size'] ?? 0) ? (float) ($attributes['max_storage_size'] ?? 0) : 0) * 0.95)
            ),
        ]);
    }

    /**
     * Create a provider with low usage.
     */
    public function lowUsage(): static
    {
        return $this->state(fn (array $attributes) => [
            'used_storage_size' => $this->faker->numberBetween(
                0,
                (int) ((is_numeric($attributes['max_storage_size'] ?? 0) ? (float) ($attributes['max_storage_size'] ?? 0) : 0) * 0.3)
            ),
        ]);
    }

    /**
     * Create a provider with encryption enabled.
     */
    public function withEncryption(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'encryption_enabled' => true,
            ]),
        ]);
    }

    /**
     * Create a provider without encryption.
     */
    public function withoutEncryption(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'encryption_enabled' => false,
            ]),
        ]);
    }

    /**
     * Create a provider with CDN enabled.
     */
    public function withCdn(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'cdn_enabled' => true,
            ]),
        ]);
    }

    /**
     * Create a provider without CDN.
     */
    public function withoutCdn(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'cdn_enabled' => false,
            ]),
        ]);
    }

    /**
     * Create a provider with versioning enabled.
     */
    public function withVersioning(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'versioning_enabled' => true,
            ]),
        ]);
    }

    /**
     * Create a provider without versioning.
     */
    public function withoutVersioning(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'versioning_enabled' => false,
            ]),
        ]);
    }

    /**
     * Create a provider with backup enabled.
     */
    public function withBackup(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'backup_enabled' => true,
            ]),
        ]);
    }

    /**
     * Create a provider without backup.
     */
    public function withoutBackup(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'backup_enabled' => false,
            ]),
        ]);
    }

    /**
     * Create a provider with virus scan enabled.
     */
    public function withVirusScan(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'virus_scan_enabled' => true,
            ]),
        ]);
    }

    /**
     * Create a provider without virus scan.
     */
    public function withoutVirusScan(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'virus_scan_enabled' => false,
            ]),
        ]);
    }

    /**
     * Create a provider with real-time sync.
     */
    public function realtimeSync(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'sync_interval' => 'realtime',
            ]),
        ]);
    }

    /**
     * Create a provider with daily sync.
     */
    public function dailySync(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'sync_interval' => 'daily',
            ]),
        ]);
    }

    /**
     * Create a provider with weekly sync.
     */
    public function weeklySync(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'sync_interval' => 'weekly',
            ]),
        ]);
    }

    /**
     * Create a provider with high uptime.
     */
    public function highUptime(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'uptime_percentage' => $this->faker->randomFloat(2, 99.5, 99.99),
            ]),
        ]);
    }

    /**
     * Create a provider with low uptime.
     */
    public function lowUptime(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'uptime_percentage' => $this->faker->randomFloat(2, 95, 99),
            ]),
        ]);
    }

    /**
     * Create a provider with fast response time.
     */
    public function fastResponse(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'response_time_ms' => $this->faker->numberBetween(10, 100),
            ]),
        ]);
    }

    /**
     * Create a provider with slow response time.
     */
    public function slowResponse(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'response_time_ms' => $this->faker->numberBetween(200, 500),
            ]),
        ]);
    }

    /**
     * Create a provider with enterprise pricing.
     */
    public function enterprise(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'pricing_tier' => 'enterprise',
                'support_level' => 'dedicated',
            ]),
        ]);
    }

    /**
     * Create a provider with free pricing.
     */
    public function free(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'pricing_tier' => 'free',
                'support_level' => 'basic',
            ]),
        ]);
    }
}
