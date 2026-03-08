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
        $cities = ['Milano', 'Roma', 'Napoli', 'Torino', 'Palermo', 'Bologna', 'Firenze'];

        return [
            'name' => $cities[array_rand($cities)],
            'slug' => 'locality-'.uniqid(),
            'latitude' => random_int(350000, 470000) / 10000,
            'longitude' => random_int(60000, 190000) / 10000,
            'postal_code' => (string) random_int(10000, 99999),
        ];
    }

    public function italian(): static
    {
        return // @var mixed state(fn (array $_attributes
            'name' => ['Centro', 'Periferia', 'Quartiere Nord', 'Zona Industriale'][array_rand(['Centro', 'Periferia', 'Quartiere Nord', 'Zona Industriale'])],
        ]);
    }
}
