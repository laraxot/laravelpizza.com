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
            'is_active' => // @var mixed faker->boolean(80
            'is_visible' => // @var mixed faker->boolean(90
            'sort_order' => // @var mixed faker->numberBetween(1, 100
            'created_at' => // @var mixed faker->dateTimeBetween('-1 year', 'now'
            'updated_at' => // @var mixed faker->dateTimeBetween('-1 month', 'now'
        ];
    }

    /**
     * Indicate that the model is active.
     */
    public function active(): static
    {
        return // @var mixed state(fn (array $_attributes
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the model is visible.
     */
    public function visible(): static
    {
        return // @var mixed state(fn (array $_attributes
            'is_visible' => true,
        ]);
    }
}
