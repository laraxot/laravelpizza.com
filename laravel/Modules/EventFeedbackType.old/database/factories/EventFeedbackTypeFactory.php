<?php

namespace Modules\EventFeedbackType\Database\Factories;

use Modules\EventFeedbackType\App\Models\EventFeedbackType;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFeedbackTypeFactory extends Factory
{
    protected $model = EventFeedbackType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}