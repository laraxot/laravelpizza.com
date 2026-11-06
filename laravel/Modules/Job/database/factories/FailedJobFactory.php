<?php

declare(strict_types=1);

namespace Modules\Job\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\Job\Models\FailedJob;

/**
 * @extends Factory<FailedJob>
 */
class FailedJobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<FailedJob>
     */
    protected $model = FailedJob::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'id' => fake()->randomNumber(5, false),
            'uuid' => fake()->uuid,
            'connection' => fake()->text,
            'queue' => fake()->text,
            'payload' => fake()->text,
            'exception' => fake()->text,
            'failed_at' => fake()->dateTime,
        ];
    }
}
