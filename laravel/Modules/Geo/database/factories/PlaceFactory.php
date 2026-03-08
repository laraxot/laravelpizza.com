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
            'locality' => // @var mixed faker->city(
            'administrative_area_level_1' => // @var mixed faker->state(
            'country' => 'Italia',
            'route' => // @var mixed faker->streetName(
            'street_number' => (string) // @var mixed faker->buildingNumber(
            'postal_code' => // @var mixed faker->postcode(
            'formatted_address' => // @var mixed faker->address(
            'latitude' => // @var mixed faker->latitude(35.0, 47.0
            'longitude' => // @var mixed faker->longitude(6.0, 19.0
        ];
    }

    public function hospital(): static
    {
        return // @var mixed state([
            'locality' => 'Ospedale '.// @var mixed faker->lastName(
        ]);
    }

    public function clinic(): static
    {
        return // @var mixed state([
            'locality' => 'Clinica '.// @var mixed faker->lastName(
        ]);
    }
}
