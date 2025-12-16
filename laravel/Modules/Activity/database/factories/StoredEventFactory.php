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
            'aggregate_uuid' => $this->faker->uuid(),
            'aggregate_version' => $this->faker->numberBetween(1, 100),
            'event_version' => $this->faker->numberBetween(1, 10),
            'event_class' => $this->faker->randomElement([
                'App\\Events\\UserRegistered',
                'App\\Events\\UserLoggedIn',
                'App\\Events\\UserLoggedOut',
                'App\\Events\\ProfileUpdated',
            ]),
            'event_properties' => [
                'user_id' => $this->faker->numberBetween(1, 100),
                'action' => $this->faker->randomElement(['create', 'update', 'delete']),
                'data' => [
                    'field1' => $this->faker->word(),
                    'field2' => $this->faker->sentence(),
                ],
                'ip_address' => $this->faker->ipv4(),
                'user_agent' => $this->faker->userAgent(),
            ],
            'meta_data' => [
                'source' => $this->faker->randomElement(['web', 'api', 'console']),
                'environment' => $this->faker->randomElement(['production', 'staging', 'local']),
            ],
        ];
    }

    /**
     * Create stored event with specific UUID.
     */
    public function withUuid(string $uuid): static
    {
        return $this->state(fn (array $_attributes): array => [
            'aggregate_uuid' => $uuid,
        ]);
    }

    /**
     * Create stored event with specific version.
     */
    public function withVersion(int $version): static
    {
        return $this->state(fn (array $_attributes): array => [
            'aggregate_version' => $version,
        ]);
    }

    /**
     * Create stored event with specific event class.
     */
    public function withEventClass(string $eventClass): static
    {
        return $this->state(fn (array $_attributes): array => [
            'event_class' => $eventClass,
        ]);
    }

    /**
     * Create user-related stored event.
     */
    public function userEvent(): static
    {
        return $this->state(fn (array $attributes): array => [
            'event_class' => 'App\\Events\\UserRegistered',
            'event_properties' => array_merge((array) ($attributes['event_properties'] ?? []), [
                'user_id' => $this->faker->numberBetween(1, 100),
                'action' => 'user_registered',
            ]),
        ]);
    }
}
