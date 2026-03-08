<?php

namespace Modules\EventAnalytics\Database\Factories;

use Modules\EventAnalytics\App\Models\EventAnalytics;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventAnalyticsFactory extends Factory
{
    protected $model = EventAnalytics::class;

    public function definition(): array
    {
        return [
            'event_id' => \Modules\Meetup\App\Models\Event::factory(),
            'metric_name' => $this->faker->word(),
            'metric_value' => $this->faker->randomFloat(2, 0, 10000),
            'recorded_at' => now(),
        ];
    }
}