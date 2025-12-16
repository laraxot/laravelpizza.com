<?php

declare(strict_types=1);

namespace Modules\Job\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\Job\Models\JobBatch;

/**
 * @extends Factory<JobBatch>
 */
class JobBatchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<JobBatch>
     */
    protected $model = JobBatch::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'id' => fake()->word,
            'name' => fake()->name,
            'total_jobs' => fake()->randomNumber(5, false),
            'pending_jobs' => fake()->randomNumber(5, false),
            'failed_jobs' => fake()->randomNumber(5, false),
            'failed_job_ids' => fake()->text,
            'options' => fake()->text,
            'cancelled_at' => fake()->randomNumber(5, false),
            'created_at' => fake()->randomNumber(5, false),
            'finished_at' => fake()->randomNumber(5, false),
        ];
    }
}
