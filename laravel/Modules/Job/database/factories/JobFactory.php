<?php

declare(strict_types=1);

namespace Modules\Job\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\Job\Models\Job;

/**
 * @extends Factory<Job>
 */
class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Job>
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            // 'id' => $this->faker->randomNumber(5, false),
            'queue' => fake()->word,
            'payload' => fake()->text,
            'attempts' => fake()->boolean,
            'reserved_at' => fake()->randomNumber(5, false),
            'available_at' => fake()->randomNumber(5, false),
            'created_at' => fake()->randomNumber(5, false),
        ];
    }
}
