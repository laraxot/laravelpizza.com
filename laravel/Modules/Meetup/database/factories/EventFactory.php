<?php

declare(strict_types=1);

namespace Modules\Meetup\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Meetup\Enums\EventAttendanceMode;
use Modules\Meetup\Enums\EventStatus;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\Venue;
use Modules\User\Models\User;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Event>
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
        $user = User::factory()->create();

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::random(4),
            'description' => $this->faker->paragraph(3),
            'in_language' => 'it',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'location' => $this->faker->address(),
            'location_id' => null,
            'status' => 'published',
            'event_status' => EventStatus::SCHEDULED,
            'event_attendance_mode' => EventAttendanceMode::OFFLINE,
            'attendees_count' => 0,
            'max_attendees' => $this->faker->numberBetween(50, 200),
            'user_id' => $user->id,
            'organizer_id' => User::factory()->create()->id,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ];
    }

    /**
     * Indicate that the event is past.
     */
    public function past(): static
    {
        return $this->state(function (array $attributes): array {
            $startDate = $this->faker->dateTimeBetween('-1 year', '-1 month');
            $endDate = (clone $startDate)->modify('+'.rand(1, 4).' hours');

            return [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'event_status' => EventStatus::COMPLETED,
            ];
        });
    }

    /**
     * Indicate that the event is upcoming.
     */
    public function upcoming(): static
    {
        return $this->state(function (array $attributes): array {
            $startDate = $this->faker->dateTimeBetween('+1 week', '+6 months');
            $endDate = (clone $startDate)->modify('+'.rand(1, 4).' hours');

            return [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'event_status' => EventStatus::SCHEDULED,
            ];
        });
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

    /**
     * Assign a specific venue to the event.
     */
    public function withVenue(Venue $venue): static
    {
        return $this->state(fn (array $attributes) => [
            'location_id' => $venue->id,
            'location' => $venue->name.', '.$venue->address.', '.$venue->city,
        ]);
    }

    /**
     * Indicate a nearly full event (for REGS-03 capacity testing).
     */
    public function nearlyFull(): static
    {
        return $this->state(function (array $attributes): array {
            $max = $this->faker->numberBetween(20, 100);

            return [
                'max_attendees' => $max,
                'attendees_count' => (int) ($max * 0.9),
            ];
        });
    }

    /**
     * Indicate a fully booked event (for REGS-03 capacity testing).
     */
    public function fullyBooked(): static
    {
        return $this->state(function (array $attributes): array {
            $max = $this->faker->numberBetween(20, 100);

            return [
                'max_attendees' => $max,
                'attendees_count' => $max,
            ];
        });
    }
}
