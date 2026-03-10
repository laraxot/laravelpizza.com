<?php

declare(strict_types=1);

namespace Modules\Meetup\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Modules\Meetup\Enums\EventAttendanceMode;
use Modules\Meetup\Enums\EventStatus;
use Modules\Meetup\Models\Event;
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
        $title = $this->generateEventTitle();
        $startDate = Carbon::now()->addDays($this->faker->numberBetween(1, 90));
        $endDate = (clone $startDate)->addHours($this->faker->numberBetween(2, 4));
        
        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::random(6),
            'description' => $this->faker->paragraphs(3, true),
            'in_language' => $this->faker->randomElement(['it', 'en']),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration' => 'PT'.$this->faker->numberBetween(2, 4).'H',
            'location' => $this->generateLocation(),
            'status' => $this->faker->randomElement(['draft', 'published', 'cancelled']),
            'event_status' => EventStatus::SCHEDULED,
            'event_attendance_mode' => $this->faker->randomElement([
                EventAttendanceMode::OFFLINE,
                EventAttendanceMode::ONLINE,
                EventAttendanceMode::MIXED,
            ]),
            'attendees_count' => 0,
            'max_attendees' => $this->faker->numberBetween(50, 200),
            'cover_image' => $this->faker->optional()->imageUrl(1200, 630, 'tech', true),
            'url' => $this->faker->optional()->url(),
            'offers' => $this->generateOffers(),
            'meta_data' => [
                'difficulty' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
                'topics' => $this->faker->randomElements(['Laravel', 'PHP', 'Vue.js', 'Livewire', 'Filament'], $this->faker->numberBetween(1, 3)),
            ],
            'is_accessible_for_free' => $this->faker->boolean(70),
            'keywords' => $this->faker->words(5),
            'typical_age_range' => '18-65',
            'audience' => $this->faker->randomElement(['developers', 'designers', 'students', 'professionals']),
            'registration_opens_at' => Carbon::now()->subDays($this->faker->numberBetween(7, 30)),
            'schedule_timezone' => 'Europe/Rome',
            'user_id' => User::factory(),
            'organizer_id' => User::factory(),
        ];
    }

    /**
     * Generate realistic event title.
     */
    protected function generateEventTitle(): string
    {
        $topics = [
            'Laravel Meetup',
            'PHP Conference',
            'Vue.js Workshop',
            'Livewire Deep Dive',
            'Filament Admin Panel',
            'Laravel Best Practices',
            'API Development',
            'Testing Workshop',
            'DevOps for Laravel',
            'Database Optimization',
        ];

        $locations = ['Milano', 'Roma', 'Torino', 'Bologna', 'Firenze', 'Napoli'];
        
        return (string) $this->faker->randomElement($topics).' - '.(string) $this->faker->randomElement($locations);
    }

    /**
     * Generate realistic location.
     */
    protected function generateLocation(): string
    {
        $venues = [
            'Impact Hub Milano',
            'Talent Garden Roma',
            'Toolbox Coworking Torino',
            'Kilowatt Bologna',
            'Impact Hub Firenze',
            'Stazione Leopolda Firenze',
        ];

        return (string) $this->faker->randomElement($venues);
    }

    /**
     * Generate offers data.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function generateOffers(): array
    {
        if ($this->faker->boolean(30)) {
            return [];
        }

        return [
            [
                '@type' => 'Offer',
                'price' => $this->faker->randomElement(['0', '10', '25', '50']),
                'priceCurrency' => 'EUR',
                'availability' => 'https://schema.org/InStock',
                'url' => $this->faker->url(),
                'validFrom' => Carbon::now()->subDays(30)->toIso8601String(),
            ],
        ];
    }

    /**
     * State: upcoming event.
     */
    public function upcoming(): static
    {
        return $this->state(function (array $attributes) {
            $startDate = Carbon::now()->addDays($this->faker->numberBetween(1, 90));
            
            return [
                'start_date' => $startDate,
                'end_date' => (clone $startDate)->addHours($this->faker->numberBetween(2, 4)),
                'status' => 'published',
            ];
        });
    }

    /**
     * State: past event.
     */
    public function past(): static
    {
        return $this->state(function (array $attributes) {
            $startDate = Carbon::now()->subDays($this->faker->numberBetween(1, 365));
            
            return [
                'start_date' => $startDate,
                'end_date' => (clone $startDate)->addHours($this->faker->numberBetween(2, 4)),
                'status' => 'published',
            ];
        });
    }

    /**
     * State: online event.
     */
    public function online(): static
    {
        return $this->state(fn (array $attributes): array => [
            'event_attendance_mode' => EventAttendanceMode::ONLINE,
            'location' => 'Online',
            'url' => $this->faker->url(),
        ]);
    }

    /**
     * State: free event.
     */
    public function free(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_accessible_for_free' => true,
            'offers' => [],
        ]);
    }

    /**
     * State: cancelled event.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => 'cancelled',
            'event_status' => EventStatus::CANCELLED,
        ]);
    }

    /**
     * State: nearly full event.
     */
    public function nearlyFull(): static
    {
        return $this->state(fn (array $attributes): array => [
            'attendees_count' => 95,
            'max_attendees' => 100,
        ]);
    }

    /**
     * State: fully booked event.
     */
    public function fullyBooked(): static
    {
        return $this->state(fn (array $attributes): array => [
            'attendees_count' => 100,
            'max_attendees' => 100,
        ]);
    }

    /**
     * State: with venue.
     */
    public function withVenue(\Modules\Meetup\Models\Venue $venue): static
    {
        return $this->state(fn (array $attributes): array => [
            'location' => $venue->name,
            'location_id' => $venue->id,
        ]);
    }
}

