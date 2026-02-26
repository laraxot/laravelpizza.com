<?php

declare(strict_types=1);

namespace Modules\Meetup\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\User\Models\User;

/**
 * Factory for EventUser pivot model.
 * 
 * Represents attendees/participants of an event.
 * 
 * @extends Factory<EventUser>
 */
class EventUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<EventUser>
     */
    protected $model = EventUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'user_id' => User::factory(),
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
     * State: attach to specific user.
     */
    public function forUser(User|string $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user instanceof User ? $user->id : $user,
        ]);
    }
}
