<?php

declare(strict_types=1);

namespace Modules\Job\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Job\Models\JobManager;

/**
 * @extends Factory<JobManager>
 */
class JobManagerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<JobManager>
     */
    protected $model = JobManager::class;

    /**
     * Define the model's default state.
<<<<<<< HEAD
=======
     * @return array<string, mixed>
>>>>>>> laraxot/dev
     */
    public function definition(): array
    {
        return [];
    }
}
