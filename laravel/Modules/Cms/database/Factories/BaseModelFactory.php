<?php

declare(strict_types=1);

namespace Modules\Cms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cms\Models\BaseModel;

/**
 * @extends Factory<BaseModel>
 */
class BaseModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<BaseModel>
     */
    protected $model = BaseModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_active' => $this->faker->boolean(80),
            'is_visible' => $this->faker->boolean(90),
            'sort_order' => $this->faker->numberBetween(1, 100),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Indicate that the model is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the model is visible.
     */
    public function visible(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'is_visible' => true,
        ]);
    }
}
