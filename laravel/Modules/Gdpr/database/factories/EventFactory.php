<?php

declare(strict_types=1);

namespace Modules\Gdpr\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Gdpr\Models\Event;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
<<<<<<< HEAD
    /**
     * The name of the factory's corresponding model.
     */
=======
>>>>>>> 40b96bcd6 (.)
    protected $model = Event::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject_id' => fake()->uuid(),
            'ip' => '127.0.0.1',
            'action' => 'consent_given',
            'payload' => '{}',
        ];
    }
}
