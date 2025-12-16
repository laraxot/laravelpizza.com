<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\Locality;

/**
 * Locality Factory.
 *
 * @extends Factory<Locality>
 */
class LocalityFactory extends Factory
{
    protected $model = Locality::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->city(),
            'slug' => $this->faker->slug(),
            'latitude' => $this->faker->latitude(35.0, 47.0),
            'longitude' => $this->faker->longitude(6.0, 19.0),
            'postal_code' => $this->faker->postcode(),
        ];
    }

    public function italian(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'name' => $this->faker->randomElement(['Centro', 'Periferia', 'Quartiere Nord', 'Zona Industriale']),
        ]);
    }
}
