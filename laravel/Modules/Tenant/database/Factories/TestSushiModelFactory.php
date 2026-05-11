<?php

declare(strict_types=1);

namespace Modules\Tenant\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenant\Models\TestSushiModel;

/**
 * @extends Factory<TestSushiModel>
 */
class TestSushiModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TestSushiModel>
     */
    protected $model = TestSushiModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'pending', 'completed']),
            'metadata' => [
                'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
                'category' => $this->faker->word(),
                'tags' => $this->faker->words(3),
            ],
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'created_by' => $this->faker->numberBetween(1, 100),
            'updated_by' => $this->faker->numberBetween(1, 100),
        ];
    }

    /**
     * Indicate that the model is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $_attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the model is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $_attributes) => [
            'status' => 'inactive',
        ]);
    }

    /**
     * Indicate that the model is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $_attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Set high priority metadata.
     */
    public function highPriority(): static
    {
        return $this->state(function (array $attributes) {
            /** @var array<string, mixed> $metadata */
            $metadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];
            $metadata['priority'] = 'high';

            return [
                'metadata' => $metadata,
            ];
        });
    }
}
