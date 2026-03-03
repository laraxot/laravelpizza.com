<?php

declare(strict_types=1);

namespace Modules\Meetup\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Meetup\Models\Profile;
use Modules\User\Models\User;

/**
 * @extends Factory<\Modules\Meetup\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\Meetup\Models\Profile>
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'fiscal_code' => $this->faker->regexify('[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]'),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'notes' => $this->faker->paragraph(),
        ];
    }
}
