<?php

declare(strict_types=1);

namespace Modules\Ptv\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Ptv\Models\MyLog;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Ptv\Models\MyLog> */
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
