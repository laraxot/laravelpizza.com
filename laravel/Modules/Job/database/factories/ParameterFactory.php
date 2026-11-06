<?php

declare(strict_types=1);

namespace Modules\Job\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\Job\Models\Parameter;

/**
 * @extends Factory<Parameter>
 */
class ParameterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Parameter>
     */
    protected $model = Parameter::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            // 'id' => $this->faker->randomNumber(5, false),
            'name' => fake()->name,
            'value' => fake()->word,
        ];
    }
}
