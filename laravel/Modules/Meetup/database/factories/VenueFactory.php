<?php

declare(strict_types=1);

namespace Modules\Meetup\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Meetup\Models\Venue;

/**
 * @extends Factory<Venue>
 */
class VenueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Venue>
     */
    protected $model = Venue::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $italianCities = [
            'Milano', 'Roma', 'Torino', 'Bologna', 'Firenze',
            'Napoli', 'Venezia', 'Genova', 'Palermo', 'Bari',
        ];

        $city = $this->faker->randomElement($italianCities);

        return [
            'name' => $this->faker->company().' Space',
            'address' => $this->faker->streetAddress(),
            'city' => $city,
            'country' => 'IT',
            'latitude' => $this->faker->latitude(36.0, 47.0),
            'longitude' => $this->faker->longitude(6.0, 18.0),
            'capacity' => $this->faker->numberBetween(30, 500),
            'website' => $this->faker->url(),
            'phone' => $this->faker->phoneNumber(),
            'description' => $this->faker->paragraph(),
            'meta_data' => [
                'wifi' => $this->faker->boolean(),
                'parking' => $this->faker->boolean(),
                'accessible' => $this->faker->boolean(),
            ],
        ];
    }

    /**
     * Indicate a large venue with high capacity.
     */
    public function large(): static
    {
        return $this->state(fn (array $attributes) => [
            'capacity' => $this->faker->numberBetween(200, 1000),
        ]);
    }

    /**
     * Indicate a small venue with limited capacity.
     */
    public function small(): static
    {
        return $this->state(fn (array $attributes) => [
            'capacity' => $this->faker->numberBetween(10, 50),
        ]);
    }
}
