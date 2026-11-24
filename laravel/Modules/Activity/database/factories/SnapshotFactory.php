<?php

declare(strict_types=1);

namespace Modules\Activity\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Activity\Models\Snapshot;

/**
 * Snapshot Factory
 *
 * Factory for creating Snapshot model instances for testing and seeding.
 *
 * @extends Factory<Snapshot>
 */
class SnapshotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Snapshot>
     */
    protected $model = Snapshot::class;

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
            'state' => [
                'data' => $this->faker->words(5, true),
                'status' => $this->faker->randomElement(['active', 'inactive', 'pending']),
                'metadata' => [
                    'user_id' => $this->faker->numberBetween(1, 100),
                    'timestamp' => $this->faker->dateTime()->format('Y-m-d H:i:s'),
                ],
            ],
        ];
    }

    /**
     * Create snapshot with specific UUID.
     */
    public function withUuid(string $uuid): static
    {
        return $this->state(fn (array $_attributes): array => [
            'aggregate_uuid' => $uuid,
        ]);
    }

    /**
     * Create snapshot with specific version.
     */
    public function withVersion(int $version): static
    {
        return $this->state(fn (array $_attributes): array => [
            'aggregate_version' => $version,
        ]);
    }

    /**
     * Create snapshot with specific state.
     *
     * @param  array<string, mixed>  $state
     */
    public function withState(array $state): static
    {
        return $this->state(fn (array $_attributes): array => [
            'state' => $state,
        ]);
    }
}
