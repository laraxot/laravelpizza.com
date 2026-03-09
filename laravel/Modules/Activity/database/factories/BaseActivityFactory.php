<?php

declare(strict_types=1);

namespace Modules\Activity\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Activity\Models\Activity;

/**
 * @extends Factory<Activity>
 */
class BaseActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Activity>
     */
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'log_name' => $this->faker->randomElement(['default', 'auth', 'user', 'system']),
            'description' => $this->faker->sentence(),
            'subject_type' => $this->faker->randomElement(['Modules\User\Models\User', 'Modules\<nome progetto>\Models\Appointment']),
            'subject_id' => $this->faker->numberBetween(1, 1000),
            'causer_type' => $this->faker->randomElement(['Modules\User\Models\User', null]),
            'causer_id' => $this->faker->optional(0.8)->numberBetween(1, 100),
            'properties' => [
                'ip_address' => $this->faker->ipv4(),
                'user_agent' => $this->faker->userAgent(),
                'action' => $this->faker->randomElement(['created', 'updated', 'deleted', 'viewed']),
            ],
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Indicate that the activity is for authentication.
     */
    public function auth(): static
    {
        return $this->state(fn (array $attributes) => [
            'log_name' => 'auth',
            'description' => $this->faker->randomElement([
                'User logged in',
                'User logged out',
                'Password changed',
                'Profile updated',
            ]),
        ]);
    }

    /**
     * Indicate that the activity is for user actions.
     */
    public function user(): static
    {
        return $this->state(fn (array $attributes) => [
            'log_name' => 'user',
            'description' => $this->faker->randomElement([
                'User created',
                'User updated',
                'User deleted',
                'User profile modified',
            ]),
        ]);
    }
}
