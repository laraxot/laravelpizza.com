<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Xot\Models\HealthCheckResultHistoryItem;

/**
 * HealthCheckResultHistoryItem Factory
 *
 * @extends Factory<HealthCheckResultHistoryItem>
 */
class HealthCheckResultHistoryItemFactory extends Factory
{
    protected $model = HealthCheckResultHistoryItem::class;

    public function definition(): array
    {
        return [
            'check_name' => $this->faker->randomElement([
                'DatabaseCheck',
                'CacheCheck',
                'QueueCheck',
                'StorageCheck',
                'MemoryCheck',
            ]),
            'check_label' => $this->faker->words(3, true),
            'status' => $this->faker->randomElement(['ok', 'warning', 'failed']),
            'notification_message' => $this->faker->optional()->sentence(),
            'short_summary' => $this->faker->words(5, true),
            'meta' => [
                'execution_time' => $this->faker->randomFloat(2, 0.1, 5.0),
                'memory_usage' => $this->faker->numberBetween(1024, 1048576),
            ],
            'ended_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ];
    }

    public function ok(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'status' => 'ok',
            'notification_message' => null,
        ]);
    }

    public function failed(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'status' => 'failed',
            'notification_message' => $this->faker->sentence(),
        ]);
    }
}
