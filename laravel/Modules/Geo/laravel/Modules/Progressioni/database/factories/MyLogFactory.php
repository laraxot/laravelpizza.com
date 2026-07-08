<?php

namespace Modules\Progressioni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Progressioni\Models\MyLog;

/**
 * @extends Factory<\Modules\Progressioni\Models\MyLog>
 */
class MyLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = MyLog::class;

    /**
     * Define the model's default state.
     */
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }
}
