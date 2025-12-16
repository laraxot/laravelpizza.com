<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\Authentication;
use Modules\User\Models\User;

/**
 * Authentication Factory.
 *
 * Factory for creating Authentication model instances for testing and seeding.
 *
 * @extends Factory<Authentication>
 */
class AuthenticationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Authentication>
     */
    protected $model = Authentication::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $loginSuccessful = $this->faker->boolean(85); // 85% success rate
        $loginAt = $this->faker->dateTimeBetween('-1 year', 'now');

        return [
            'type' => $this->faker->randomElement(['login', 'logout', 'password_reset', 'email_verification']),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'location' => $this->faker->optional(0.7)->city().', '.$this->faker->optional(0.7)->country(),
            'login_successful' => $loginSuccessful,
            'login_at' => $loginAt,
            'logout_at' => $loginSuccessful && $this->faker->boolean(60)
                ? $this->faker->dateTimeBetween($loginAt, 'now')
                : null,
            'authenticatable_type' => User::class,
            'authenticatable_id' => User::factory(),
        ];
    }

    /**
     * Indicate that the authentication was successful.
     */
    public function successful(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'login_successful' => true,
        ]);
    }

    /**
     * Indicate that the authentication failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'login_successful' => false,
            'logout_at' => null,
        ]);
    }

    /**
     * Set the authentication type to login.
     */
    public function login(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'type' => 'login',
        ]);
    }

    /**
     * Set the authentication type to logout.
     */
    public function logout(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'type' => 'logout',
            'logout_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Create authentication record for a specific user.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (array $_attributes): array => [
            'authenticatable_type' => User::class,
            'authenticatable_id' => $user->id,
        ]);
    }
}
