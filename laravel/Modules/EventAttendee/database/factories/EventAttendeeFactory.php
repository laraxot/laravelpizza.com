<?php

namespace Modules\EventAttendee\Database\Factories;

use Modules\EventAttendee\App\Models\EventAttendee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventAttendeeFactory extends Factory
{
    protected $model = EventAttendee::class;

    public function definition(): array
    {
        return [
            'user_id' => \Modules\User\App\Models\User::factory(),
            'event_id' => \Modules\Meetup\App\Models\Event::factory(),
            'registration_date' => now(),
            'status' => $this->faker->randomElement(['registered', 'confirmed', 'cancelled']),
            'ticket_type' => $this->faker->randomElement(['free', 'paid', 'vip']),
            'payment_status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'attended' => $this->faker->boolean(70),
            'check_in_time' => $this->faker->boolean(70) ? now()->subHours(1) : null,
            'notes' => $this->faker->sentence(),
        ];
    }
}