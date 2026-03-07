<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'remember_token' => \Illuminate\Support\Str::random(10),
            'is_active' => $this->faker->boolean(),
        ];
    }

    /**
     * Indicate that the user is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the user is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the email is verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Indicate that the email is not verified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Configure the factory to create a user with a profile.
     */
    public function withProfile(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->profile()->create([
                'bio' => $this->faker->text(),
                'avatar' => '/avatars/'.$this->faker->word().'.jpg',
                'phone' => $this->faker->phoneNumber(),
            ]);
        });
    }

    /**
     * Configure the factory to create a user for a specific tenant.
     */
    public function forTenant($tenant): static
    {
        return $this->afterCreating(function (User $user) use ($tenant) {
            $user->tenant_id = $tenant->id;
            $user->save();
        });
    }
}
