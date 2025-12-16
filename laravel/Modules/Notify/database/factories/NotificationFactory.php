<?php

declare(strict_types=1);


namespace Modules\Notify\Database\Factories;

use Modules\Notify\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
