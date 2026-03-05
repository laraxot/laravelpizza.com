<?php

declare(strict_types=1);

namespace Modules\Meetup\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Meetup\Models\Sponsor;

/**
 * @extends Factory<Sponsor>
 */
class SponsorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Sponsor>
     */
    protected $model = Sponsor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'level' => $this->faker->randomElement(['gold', 'silver', 'bronze', 'platinum', 'community']),
            'website' => $this->faker->url(),
            'logo' => $this->faker->imageUrl(400, 200, 'business'),
            'description' => $this->faker->paragraph(),
            'email' => $this->faker->companyEmail(),
            'contact_person' => $this->faker->name(),
            'meta_data' => [
                'industry' => $this->faker->word(),
                'employees' => $this->faker->numberBetween(10, 10000),
            ],
        ];
    }

    /**
     * Indicate a gold-level sponsor.
     */
    public function gold(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 'gold',
        ]);
    }

    /**
     * Indicate a platinum-level sponsor.
     */
    public function platinum(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 'platinum',
        ]);
    }

    /**
     * Indicate a community-level sponsor.
     */
    public function community(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 'community',
        ]);
    }
}
