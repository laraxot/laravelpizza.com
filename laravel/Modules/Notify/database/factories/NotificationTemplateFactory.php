<?php

declare(strict_types=1);


namespace Modules\Notify\Database\Factories;

use Modules\Notify\Models\NotificationTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = NotificationTemplate::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
