<?php

namespace Modules\EventNotification\Database\Factories;

use Modules\EventNotification\App\Models\EventNotification;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventNotificationFactory extends Factory
{
    protected $model = EventNotification::class;

    public function definition(): array
    {
        return [
            'event_id' => \Modules\Meetup\App\Models\Event::factory(),
            'user_id' => \Modules\User\App\Models\User::factory(),
            'type' => $this->faker->randomElement(['reminder', 'update', 'cancellation', 'other']),
            'title' => $this->faker->sentence(),
            'message' => $this->faker->paragraph(),
            'is_read' => $this->faker->boolean(30),
            'read_at' => $this->faker->boolean(30) ? now() : null,
            'sent_at' => now(),
        ];
    }
}