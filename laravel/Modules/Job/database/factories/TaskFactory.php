<?php

declare(strict_types=1);

namespace Modules\Job\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Job\Models\Task;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

<<<<<<< HEAD
=======
    /**
     * @return array<string, mixed>
     */
>>>>>>> laraxot/dev
    public function definition(): array
    {
        return [
            'description' => fake()->sentence,
            'command' => 'Modules\Job\Console\Commands\ListSchedule',
            'expression' => '* * * * *',
        ];
    }
}
