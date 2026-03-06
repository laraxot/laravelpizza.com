<?php

declare(strict_types=1);

namespace Modules\Meetup\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventSponsor;
use Modules\Meetup\Models\Sponsor;

/**
 * @extends Factory<\Modules\Meetup\Models\EventSponsor>
 */
class EventSponsorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\Meetup\Models\EventSponsor>
     */
    protected $model = EventSponsor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'sponsor_id' => Sponsor::factory(),
            'sponsorship_details' => $this->faker->optional()->sentence(),
        ];
    }
}
