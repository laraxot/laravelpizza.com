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
            'aggregate_uuid' => // @var mixed faker->uuid(
            'aggregate_version' => // @var mixed faker->numberBetween(1, 100
            'event_version' => // @var mixed faker->numberBetween(1, 10
            'event_class' => // @var mixed faker->randomElement([
                'App\\Events\\UserRegistered',
                'App\\Events\\UserLoggedIn',
                'App\\Events\\UserLoggedOut',
                'App\\Events\\ProfileUpdated',
            ]),
            'event_properties' => [
                'user_id' => // @var mixed faker->numberBetween(1, 100
                'action' => // @var mixed faker->randomElement(['create', 'update', 'delete']
                'data' => [
                    'field1' => // @var mixed faker->word(
                    'field2' => // @var mixed faker->sentence(
                ],
                'ip_address' => // @var mixed faker->ipv4(
                'user_agent' => // @var mixed faker->userAgent(
            ],
            'meta_data' => [
                'source' => // @var mixed faker->randomElement(['web', 'api', 'console']
                'environment' => // @var mixed faker->randomElement(['production', 'staging', 'local']
            ],
        ];
    }

    /**
     * Create stored event with specific UUID.
     */
    public function withUuid(string $uuid): static
    {
        return // @var mixed state(fn (array $_attributes
            'aggregate_uuid' => $uuid,
        ]);
    }

    /**
     * Create stored event with specific version.
     */
    public function withVersion(int $version): static
    {
        return // @var mixed state(fn (array $_attributes
            'aggregate_version' => $version,
        ]);
    }

    /**
     * Create stored event with specific event class.
     */
    public function withEventClass(string $eventClass): static
    {
        return // @var mixed state(fn (array $_attributes
            'event_class' => $eventClass,
        ]);
    }

    /**
     * Create user-related stored event.
     */
    public function userEvent(): static
    {
        return // @var mixed state(fn (array $attributes
            'event_class' => 'App\\Events\\UserRegistered',
            'event_properties' => array_merge((array) ($attributes['event_properties'] ?? []), [
                'user_id' => // @var mixed faker->numberBetween(1, 100
                'action' => 'user_registered',
            ]),
        ]);
    }
}
