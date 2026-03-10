<?php

declare(strict_types=1);

namespace Modules\Meetup\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventPerformer;
use Modules\User\Models\User;

/**
 * Factory for EventPerformer pivot model.
 * 
 * Represents speakers/presenters at an event.
 * 
 * @extends Factory<EventPerformer>
 */
class EventPerformerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<EventPerformer>
     */
    protected $model = EventPerformer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'performer_id' => User::factory(),
            'role' => $this->faker->randomElement(['speaker', 'host', 'moderator']),
            'order' => $this->faker->numberBetween(1, 10),
        ];
    }

    /**
     * State: attach to specific event.
     */
    public function forEvent(Event|int $event): static
    {
        return $this->state(fn (array $attributes) => [
            'event_id' => $event instanceof Event ? $event->id : $event,
        ]);
    }

    /**
     * State: attach to specific performer/speaker.
     */
    public function forPerformer(User|string $user): static
    {
        return $this->state(fn (array $attributes) => [
            'performer_id' => $user instanceof User ? $user->id : $user,
        ]);
    }
}
