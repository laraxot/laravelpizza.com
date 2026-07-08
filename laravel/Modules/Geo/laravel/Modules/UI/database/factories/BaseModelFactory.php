<?php

declare(strict_types=1);

namespace Modules\UI\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\UI\Models\BaseModel;

/**
 * BaseModel factory.
 *
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
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Indicate that the model is active.
     */
    public function active(): static
    {
        return $this->state(static fn () => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the model is inactive.
     */
    public function inactive(): static
    {
        return $this->state(static fn () => [
            'is_active' => false,
        ]);
    }
}
