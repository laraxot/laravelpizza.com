<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\Place;

/**
 * Place Factory.
 *
 * @extends Factory<Place>
 */
class PlaceFactory extends Factory
{
    protected $model = Place::class;

    public function definition(): array
    {
        return [
            'locality' => $this->faker->city(),
            'administrative_area_level_1' => $this->faker->state(),
            'country' => 'Italia',
            'route' => $this->faker->streetName(),
            'street_number' => (string) $this->faker->buildingNumber(),
            'postal_code' => $this->faker->postcode(),
            'formatted_address' => $this->faker->address(),
            'latitude' => $this->faker->latitude(35.0, 47.0),
            'longitude' => $this->faker->longitude(6.0, 19.0),
        ];
    }

    public function hospital(): static
    {
        return $this->state([
            'locality' => 'Ospedale '.$this->faker->lastName(),
        ]);
    }

    public function clinic(): static
    {
        return $this->state([
            'locality' => 'Clinica '.$this->faker->lastName(),
        ]);
    }
}
