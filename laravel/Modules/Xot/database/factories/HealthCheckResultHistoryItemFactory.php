<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Xot\Models\HealthCheckResultHistoryItem;

/**
 * HealthCheckResultHistoryItem Factory.
 *
 * @extends Factory<HealthCheckResultHistoryItem>
 */
class HealthCheckResultHistoryItemFactory extends Factory
{
    protected $model = HealthCheckResultHistoryItem::class;

    public function definition(): array
    {
        return [
            'check_name' => $faker->randomElement([
                'DatabaseCheck',
                'CacheCheck',
                'QueueCheck',
                'StorageCheck',
                'MemoryCheck',
            ]),
            'check_label' => $faker->words(3, true
            'status' => $faker->randomElement(['ok', 'warning', 'failed']
            'notification_message' => $faker->optional(
            'short_summary' => $faker->words(5, true
            'meta' => [
                'execution_time' => $faker->randomFloat(2, 0.1, 5.0
                'memory_usage' => $faker->numberBetween(1024, 1048576)
            ],
            'ended_at' => $faker->dateTimeBetween('-1 week', 'now')
        ];
    }

    public function ok(): static
    {
        return $this->state(fn (array $_attributes
            'status' => 'ok',
            'notification_message' => null,
        ]);
    }

    public function failed(): static
    {
        return $this->state(fn (array $_attributes
            'status' => 'failed',
            'notification_message' => $faker->sentence()
        ]);
    }
}
