<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\Place;
use Modules\Geo\Models\PlaceType;

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
            'name' => $this->faker->city(),
            'slug' => $this->faker->slug(),
            'latitude' => $this->faker->latitude(35.0, 47.0),
            'longitude' => $this->faker->longitude(6.0, 19.0),
            'place_type_id' => PlaceType::factory(),
            'description' => $this->faker->optional()->paragraph(),
        ];
    }

    public function hospital(): static
    {
        return $this->state([
            'name' => 'Ospedale '.$this->faker->lastName(),
        ]);
    }

    public function clinic(): static
    {
        return $this->state([
            'name' => 'Clinica '.$this->faker->lastName(),
        ]);
    }
}
