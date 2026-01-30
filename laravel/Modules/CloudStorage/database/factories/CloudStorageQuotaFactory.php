<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CloudStorage\Models\CloudStorageQuota;

/**
 * CloudStorageQuota factory.
 *
 * @extends Factory<CloudStorageQuota>
 */
class CloudStorageQuotaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<CloudStorageQuota>
     */
    protected $model = CloudStorageQuota::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 1000),
            'provider_id' => $this->faker->numberBetween(1, 100),
            'quota_type' => $this->faker->randomElement(['storage', 'file_count', 'bandwidth', 'api_calls']),
            'limit' => $this->faker->numberBetween(107374182400, 1099511627776), // 100GB to 1TB
            'used' => $this->faker->numberBetween(0, 107374182400), // 0 to 100GB
            'remaining' => $this->faker->numberBetween(0, 107374182400), // 0 to 100GB
            'percentage_used' => $this->faker->randomFloat(2, 0, 100),
            'is_active' => $this->faker->boolean(80),
            'is_unlimited' => $this->faker->boolean(10),
            'reset_frequency' => $this->faker->randomElement(['never', 'daily', 'weekly', 'monthly', 'yearly']),
            'reset_date' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'last_reset_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'next_reset_at' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'warning_threshold' => $this->faker->randomFloat(2, 70, 90),
            'critical_threshold' => $this->faker->randomFloat(2, 90, 99),
            'is_warning_sent' => $this->faker->boolean(30),
            'is_critical_sent' => $this->faker->boolean(10),
            'last_warning_sent_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'last_critical_sent_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'grace_period_days' => $this->faker->numberBetween(0, 30),
            'is_grace_period_active' => $this->faker->boolean(20),
            'grace_period_started_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'grace_period_ends_at' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
            'overage_allowed' => $this->faker->boolean(40),
            'overage_limit' => $this->faker->optional()->numberBetween(10737418240, 107374182400), // 10GB to 100GB
            'overage_used' => $this->faker->optional()->numberBetween(0, 10737418240), // 0 to 10GB
            'overage_cost_per_gb' => $this->faker->optional()->randomFloat(4, 0.01, 0.50),
            'total_overage_cost' => $this->faker->optional()->randomFloat(2, 0, 100),
            'settings' => [
                'auto_cleanup_enabled' => $this->faker->boolean(60),
                'cleanup_threshold' => $this->faker->randomFloat(2, 80, 95),
                'notifications_enabled' => $this->faker->boolean(90),
                'email_notifications' => $this->faker->boolean(80),
                'sms_notifications' => $this->faker->boolean(30),
                'push_notifications' => $this->faker->boolean(70),
                'webhook_notifications' => $this->faker->boolean(40),
                'retention_policy' => $this->faker->randomElement(['keep_all', 'delete_old', 'archive_old']),
                'retention_days' => $this->faker->optional()->numberBetween(30, 3650),
                'compression_enabled' => $this->faker->boolean(50),
                'encryption_enabled' => $this->faker->boolean(80),
                'backup_enabled' => $this->faker->boolean(70),
                'sync_enabled' => $this->faker->boolean(85),
            ],
            'metadata' => [
                'quota_category' => $this->faker->randomElement(['free', 'basic', 'premium', 'enterprise', 'custom']),
                'billing_cycle' => $this->faker->randomElement(['monthly', 'quarterly', 'yearly', 'one_time']),
                'cost_per_gb' => $this->faker->randomFloat(4, 0.01, 1.00),
                'currency' => $this->faker->randomElement(['USD', 'EUR', 'GBP', 'JPY']),
                'tax_rate' => $this->faker->randomFloat(2, 0, 25),
                'discount_percentage' => $this->faker->randomFloat(2, 0, 50),
                'features_included' => $this->faker->randomElements(['encryption', 'compression', 'backup', 'sync', 'cdn', 'versioning'], $this->faker->numberBetween(2, 6)),
                'support_level' => $this->faker->randomElement(['basic', 'standard', 'premium', 'dedicated']),
                'uptime_guarantee' => $this->faker->randomFloat(2, 95, 99.99),
                'response_time_guarantee_ms' => $this->faker->numberBetween(50, 500),
            ],
        ];
    }

    /**
     * Indicate that the quota is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the quota is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the quota is unlimited.
     */
    public function unlimited(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_unlimited' => true,
            'limit' => 0,
            'remaining' => 0,
            'percentage_used' => 0,
        ]);
    }

    /**
     * Indicate that the quota is limited.
     */
    public function limited(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_unlimited' => false,
        ]);
    }

    /**
     * Create a storage quota.
     */
    public function storage(): static
    {
        return $this->state(fn (array $attributes) => [
            'quota_type' => 'storage',
            'limit' => $this->faker->numberBetween(107374182400, 1099511627776), // 100GB to 1TB
            'used' => $this->faker->numberBetween(0, 107374182400), // 0 to 100GB
        ]);
    }

    /**
     * Create a file count quota.
     */
    public function fileCount(): static
    {
        return $this->state(fn (array $attributes) => [
            'quota_type' => 'file_count',
            'limit' => $this->faker->numberBetween(1000, 1000000),
            'used' => $this->faker->numberBetween(0, 100000),
        ]);
    }

    /**
     * Create a bandwidth quota.
     */
    public function bandwidth(): static
    {
        return $this->state(fn (array $attributes) => [
            'quota_type' => 'bandwidth',
            'limit' => $this->faker->numberBetween(107374182400, 1099511627776), // 100GB to 1TB
            'used' => $this->faker->numberBetween(0, 107374182400), // 0 to 100GB
        ]);
    }

    /**
     * Create an API calls quota.
     */
    public function apiCalls(): static
    {
        return $this->state(fn (array $attributes) => [
            'quota_type' => 'api_calls',
            'limit' => $this->faker->numberBetween(10000, 10000000),
            'used' => $this->faker->numberBetween(0, 1000000),
        ]);
    }

    /**
     * Create a quota with high usage.
     */
    public function highUsage(): static
    {
        return $this->state(fn (array $attributes) => [
            'used' => $this->faker->numberBetween(
                (int) ((is_numeric($attributes['limit'] ?? 0) ? (float) ($attributes['limit'] ?? 0) : 0) * 0.8),
                (int) ((is_numeric($attributes['limit'] ?? 0) ? (float) ($attributes['limit'] ?? 0) : 0) * 0.95)
            ),
            'percentage_used' => $this->faker->randomFloat(2, 80, 95),
        ]);
    }

    /**
     * Create a quota with low usage.
     */
    public function lowUsage(): static
    {
        return $this->state(fn (array $attributes) => [
            'used' => $this->faker->numberBetween(
                0,
                (int) ((is_numeric($attributes['limit'] ?? 0) ? (float) ($attributes['limit'] ?? 0) : 0) * 0.3)
            ),
            'percentage_used' => $this->faker->randomFloat(2, 0, 30),
        ]);
    }

    /**
     * Create a quota with critical usage.
     */
    public function criticalUsage(): static
    {
        return $this->state(fn (array $attributes) => [
            'used' => $this->faker->numberBetween(
                (int) ((is_numeric($attributes['limit'] ?? 0) ? (float) ($attributes['limit'] ?? 0) : 0) * 0.95),
                (int) ((is_numeric($attributes['limit'] ?? 0) ? (float) ($attributes['limit'] ?? 0) : 0) * 0.99)
            ),
            'percentage_used' => $this->faker->randomFloat(2, 95, 99),
            'is_critical_sent' => true,
            'last_critical_sent_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * Create a quota with warning usage.
     */
    public function warningUsage(): static
    {
        return $this->state(fn (array $attributes) => [
            'used' => $this->faker->numberBetween(
                (int) ((is_numeric($attributes['limit'] ?? 0) ? (float) ($attributes['limit'] ?? 0) : 0) * 0.7),
                (int) ((is_numeric($attributes['limit'] ?? 0) ? (float) ($attributes['limit'] ?? 0) : 0) * 0.85)
            ),
            'percentage_used' => $this->faker->randomFloat(2, 70, 85),
            'is_warning_sent' => true,
            'last_warning_sent_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * Create a daily reset quota.
     */
    public function dailyReset(): static
    {
        return $this->state(fn (array $attributes) => [
            'reset_frequency' => 'daily',
            'next_reset_at' => $this->faker->dateTimeBetween('now', '+1 day'),
        ]);
    }

    /**
     * Create a weekly reset quota.
     */
    public function weeklyReset(): static
    {
        return $this->state(fn (array $attributes) => [
            'reset_frequency' => 'weekly',
            'next_reset_at' => $this->faker->dateTimeBetween('now', '+1 week'),
        ]);
    }

    /**
     * Create a monthly reset quota.
     */
    public function monthlyReset(): static
    {
        return $this->state(fn (array $attributes) => [
            'reset_frequency' => 'monthly',
            'next_reset_at' => $this->faker->dateTimeBetween('now', '+1 month'),
        ]);
    }

    /**
     * Create a yearly reset quota.
     */
    public function yearlyReset(): static
    {
        return $this->state(fn (array $attributes) => [
            'reset_frequency' => 'yearly',
            'next_reset_at' => $this->faker->dateTimeBetween('now', '+1 year'),
        ]);
    }

    /**
     * Create a quota with no reset.
     */
    public function noReset(): static
    {
        return $this->state(fn (array $attributes) => [
            'reset_frequency' => 'never',
            'reset_date' => null,
            'next_reset_at' => null,
        ]);
    }

    /**
     * Create a quota with grace period.
     */
    public function withGracePeriod(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_grace_period_active' => true,
            'grace_period_started_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'grace_period_ends_at' => $this->faker->dateTimeBetween('now', '+1 month'),
            'grace_period_days' => $this->faker->numberBetween(7, 30),
        ]);
    }

    /**
     * Create a quota without grace period.
     */
    public function withoutGracePeriod(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_grace_period_active' => false,
            'grace_period_started_at' => null,
            'grace_period_ends_at' => null,
            'grace_period_days' => 0,
        ]);
    }

    /**
     * Create a quota with overage allowed.
     */
    public function withOverage(): static
    {
        return $this->state(fn (array $attributes) => [
            'overage_allowed' => true,
            'overage_limit' => $this->faker->numberBetween(10737418240, 107374182400), // 10GB to 100GB
            'overage_used' => $this->faker->numberBetween(0, 10737418240), // 0 to 10GB
            'overage_cost_per_gb' => $this->faker->randomFloat(4, 0.01, 0.50),
        ]);
    }

    /**
     * Create a quota without overage.
     */
    public function withoutOverage(): static
    {
        return $this->state(fn (array $attributes) => [
            'overage_allowed' => false,
            'overage_limit' => 0,
            'overage_used' => 0,
            'overage_cost_per_gb' => 0,
        ]);
    }

    /**
     * Create a free tier quota.
     */
    public function free(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'quota_category' => 'free',
                'cost_per_gb' => 0,
                'features_included' => ['encryption', 'backup'],
                'support_level' => 'basic',
            ]),
        ]);
    }

    /**
     * Create a basic tier quota.
     */
    public function basic(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'quota_category' => 'basic',
                'cost_per_gb' => $this->faker->randomFloat(4, 0.01, 0.10),
                'features_included' => ['encryption', 'backup', 'sync'],
                'support_level' => 'standard',
            ]),
        ]);
    }

    /**
     * Create a premium tier quota.
     */
    public function premium(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'quota_category' => 'premium',
                'cost_per_gb' => $this->faker->randomFloat(4, 0.05, 0.25),
                'features_included' => ['encryption', 'backup', 'sync', 'cdn', 'versioning'],
                'support_level' => 'premium',
            ]),
        ]);
    }

    /**
     * Create an enterprise tier quota.
     */
    public function enterprise(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => array_merge(is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [], [
                'quota_category' => 'enterprise',
                'cost_per_gb' => $this->faker->randomFloat(4, 0.10, 0.50),
                'features_included' => ['encryption', 'compression', 'backup', 'sync', 'cdn', 'versioning'],
                'support_level' => 'dedicated',
                'uptime_guarantee' => $this->faker->randomFloat(2, 99.5, 99.99),
            ]),
        ]);
    }

    /**
     * Create a quota with notifications enabled.
     */
    public function withNotifications(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'notifications_enabled' => true,
                'email_notifications' => true,
                'sms_notifications' => $this->faker->boolean(50),
                'push_notifications' => true,
            ]),
        ]);
    }

    /**
     * Create a quota without notifications.
     */
    public function withoutNotifications(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'notifications_enabled' => false,
                'email_notifications' => false,
                'sms_notifications' => false,
                'push_notifications' => false,
            ]),
        ]);
    }

    /**
     * Create a quota with auto cleanup enabled.
     */
    public function withAutoCleanup(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'auto_cleanup_enabled' => true,
                'cleanup_threshold' => $this->faker->randomFloat(2, 80, 95),
            ]),
        ]);
    }

    /**
     * Create a quota without auto cleanup.
     */
    public function withoutAutoCleanup(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'auto_cleanup_enabled' => false,
            ]),
        ]);
    }

    /**
     * Create a quota with encryption enabled.
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
     * Create a quota without encryption.
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
     * Create a quota with backup enabled.
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
     * Create a quota without backup.
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
     * Create a quota with sync enabled.
     */
    public function withSync(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'sync_enabled' => true,
            ]),
        ]);
    }

    /**
     * Create a quota without sync.
     */
    public function withoutSync(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge(is_array($attributes['settings'] ?? null) ? $attributes['settings'] : [], [
                'sync_enabled' => false,
            ]),
        ]);
    }
}
