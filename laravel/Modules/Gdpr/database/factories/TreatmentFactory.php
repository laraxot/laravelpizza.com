<?php

declare(strict_types=1);

namespace Modules\Gdpr\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Gdpr\Models\Treatment;

/**
 * @extends Factory<Treatment>
 */
class TreatmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Treatment>
     */
    protected $model = Treatment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'privacy_policy', 'terms_conditions', 'marketing_consent',
                'analytics_consent', 'profiling_consent', 'third_party_consent',
            ]),
            'description' => $this->faker->sentence(),
            'weight' => $this->faker->numberBetween(1, 100),
            'active' => true,
            'required' => $this->faker->boolean(60),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }

    public function required(): static
    {
        return $this->state(fn (array $attributes) => [
            'required' => true,
        ]);
    }

    public function optional(): static
    {
        return $this->state(fn (array $attributes) => [
            'required' => false,
        ]);
    }
}
