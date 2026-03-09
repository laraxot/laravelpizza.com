<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Notify\Models\NotificationType;

class NotificationTypeFactory extends Factory
{
    protected $model = NotificationType::class;

    public function definition(): array
    {
        return [
            'name' => $faker->word()
            'slug' => $faker->slug()
            'description' => $faker->sentence()
            'is_active' => $faker->boolean(90)
            'created_at' => $faker->dateTimeBetween('-1 year')
            'updated_at' => $faker->dateTimeBetween('-1 year')
        ];
    }
}
