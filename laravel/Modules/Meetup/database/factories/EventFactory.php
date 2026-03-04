<?php

declare(strict_types=1);

namespace Modules\Meetup\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Meetup\Enums\EventAttendanceMode;
use Modules\Meetup\Enums\EventStatus;
use Modules\Meetup\Models\Event;
use Modules\User\Models\User;

/**
 * @extends Factory<\Modules\Meetup\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\Meetup\Models\Event>
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        $startDate = $this->faker->dateTimeBetween('now', '+6 months');
        $endDate = (clone $startDate)->modify('+'.rand(1, 4).' hours');

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(3),
            'in_language' => 'it',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'location' => $this->faker->address(),
            'status' => 'published',
            'event_status' => EventStatus::SCHEDULED,
            'event_attendance_mode' => EventAttendanceMode::OFFLINE,
            'attendees_count' => 0,
            'max_attendees' => $this->faker->numberBetween(50, 200),
            'user_id' => User::factory(),
            'organizer_id' => User::factory(),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
        ];
    }

    /**
     * Indicate that the event is past.
     */
    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => $this->faker->dateTimeBetween('-1 year', '-1 month'),
            'end_date' => $this->faker->dateTimeBetween('-1 year', '-1 month'),
        ]);
    }

    /**
     * Indicate that the event is online.
     */
    public function online(): static
    {
        return $this->state(fn (array $attributes) => [
            'event_attendance_mode' => EventAttendanceMode::ONLINE,
            'url' => $this->faker->url(),
        ]);
    }
}
