<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Notify\Models\NotificationChannel;

/**
 * @extends Factory<NotificationChannel>
 */
class NotificationChannelFactory extends Factory
{
    /** @var class-string<NotificationChannel> */
    protected $model = NotificationChannel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'driver' => 'email',
            'config' => json_encode(['smtp_host' => 'localhost']),
            'is_enabled' => true,
            'priority' => 1,
        ];
    }

    /**
     * Indicate that the channel is enabled.
     */
    public function enabled(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_enabled' => true,
        ]);
    }

    /**
     * Indicate that the channel is disabled.
     */
    public function disabled(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_enabled' => false,
        ]);
    }

    /**
     * Configure the factory for email channels.
     */
    public function email(): static
    {
        return $this->state(fn (array $attributes) => [
            'driver' => 'email',
        ]);
    }

    /**
     * Configure the factory for SMS channels.
     */
    public function sms(): static
    {
        return $this->state(fn (array $attributes) => [
            'driver' => 'sms',
        ]);
    }
}
