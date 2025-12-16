<?php

namespace Modules\Notify\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Notify\Models\NotificationLog::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
