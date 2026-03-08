<?php

namespace Modules\EventOrganizer\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\EventOrganizer\App\Models\EventOrganizer;

class EventOrganizerFactory extends Factory
{
    protected $model = EventOrganizer::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'organization' => $this->faker->company,
            'website' => $this->faker->url,
            'description' => $this->faker->paragraph,
            'event_id' => null,
        ];
    }
}