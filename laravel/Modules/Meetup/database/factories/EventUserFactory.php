<?php

declare(strict_types=1);

namespace Modules\Meetup\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\User\Models\User;

/**
 * @extends Factory<\Modules\Meetup\Models\EventUser>
 */
class EventUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\Meetup\Models\EventUser>
     */
    protected $model = EventUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'user_id' => User::factory(),
        ];
    }
}
