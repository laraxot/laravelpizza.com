<?php

declare(strict_types=1);

namespace Modules\Gdpr\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Gdpr\Models\Consent;

/**
 * @extends Factory<Consent>
 */
class ConsentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Consent>
     */
    protected $model = Consent::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'subject_id' => null,
            'treatment_id' => null,
            'user_id' => null,
            'user_type' => 'Modules\\User\\Models\\User',
            'type' => $this->faker->randomElement(['privacy_policy', 'terms_conditions', 'marketing_consent']),
            'accepted_at' => $this->faker->optional(0.7)->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'accepted_at' => now(),
        ]);
    }

    public function declined(): static
    {
        return $this->state(fn (array $attributes) => [
            'accepted_at' => null,
        ]);
    }
}
