<?php

declare(strict_types=1);

namespace Modules\Activity\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Activity\Models\StoredEvent;

/**
 * StoredEvent Factory
 *
 * Factory for creating StoredEvent model instances for testing and seeding.
 *
 * @extends Factory<StoredEvent>
 */
class StoredEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<StoredEvent>
     */
    protected $model = StoredEvent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'aggregate_uuid' => $faker->uuid(
            'aggregate_version' => $faker->numberBetween(1, 100
            'event_version' => $faker->numberBetween(1, 10
            'event_class' => $faker->randomElement([
                'App\\Events\\UserRegistered',
                'App\\Events\\UserLoggedIn',
                'App\\Events\\UserLoggedOut',
                'App\\Events\\ProfileUpdated',
            ]),
            'event_properties' => [
                'user_id' => $faker->numberBetween(1, 100
                'action' => $faker->randomElement(['create', 'update', 'delete']
                'data' => [
                    'field1' => $faker->word(
                    'field2' => $faker->sentence(
                ],
                'ip_address' => $faker->ipv4(
                'user_agent' => $faker->userAgent(
            ],
            'meta_data' => [
                'source' => $faker->randomElement(['web', 'api', 'console']
                'environment' => $faker->randomElement(['production', 'staging', 'local']
            ],
        ];
    }

    /**
     * Create stored event with specific UUID.
     */
    public function withUuid(string $uuid): static
    {
        return $this->state(fn (array $_attributes
            'aggregate_uuid' => $uuid,
        ]);
    }

    /**
     * Create stored event with specific version.
     */
    public function withVersion(int $version): static
    {
        return $this->state(fn (array $_attributes
            'aggregate_version' => $version,
        ]);
    }

    /**
     * Create stored event with specific event class.
     */
    public function withEventClass(string $eventClass): static
    {
        return $this->state(fn (array $_attributes
            'event_class' => $eventClass,
        ]);
    }

    /**
     * Create user-related stored event.
     */
    public function userEvent(): static
    {
        return $this->state(fn (array $attributes
            'event_class' => 'App\\Events\\UserRegistered',
            'event_properties' => array_merge((array) ($attributes['event_properties'] ?? []), [
                'user_id' => $faker->numberBetween(1, 100
                'action' => 'user_registered',
            ]),
        ]);
    }
}
