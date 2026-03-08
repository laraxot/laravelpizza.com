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
            'locality' => $faker->city(
            'administrative_area_level_1' => $faker->state(
            'country' => 'Italia',
            'route' => $faker->streetName(
            'street_number' => (string) $faker->buildingNumber(
            'postal_code' => $faker->postcode(
            'formatted_address' => $faker->address(
            'latitude' => $faker->latitude(35.0, 47.0
            'longitude' => $faker->longitude(6.0, 19.0
        ];
    }

    public function hospital(): static
    {
        return $this->state([
            'locality' => 'Ospedale '.$faker->lastName(
        ]);
    }

    public function clinic(): static
    {
        return $this->state([
            'locality' => 'Clinica '.$faker->lastName(
        ]);
    }
}
