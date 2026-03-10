<?php

namespace Modules\Meetup\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Meetup\Models\Feedback::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

