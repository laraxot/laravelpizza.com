<?php

declare(strict_types=1);

namespace Modules\Job\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Job\Models\JobsWaiting;

/**
 * @extends Factory<JobsWaiting>
 */
class JobsWaitingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<JobsWaiting>
     */
    protected $model = JobsWaiting::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            // 'id' => $this->faker->number(1,5),
            'queue' => fake()->word,
            'payload' => fake()->text,
            'attempts' => fake()->boolean,
            // 'reserved_at' => $this->faker->randomNumber,
            // 'available_at' => $this->faker->randomNumber,
            // 'created_at' => $this->faker->randomNumber
        ];
    }
}
