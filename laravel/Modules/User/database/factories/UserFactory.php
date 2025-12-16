<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\User\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    /** @var class-string<User> */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'lang' => fake()->randomElement(['it', 'en', 'de']),
            'is_active' => true,
            'is_otp' => false,
            'password_expires_at' => fake()->optional()->dateTimeBetween('now', '+1 year'),
        ];
    }

    /**
     * Indicate that the user should be active.
     */
    public function active(): static
    {
        return $this->state(fn (array $_attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the user should be inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $_attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the user's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $_attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
