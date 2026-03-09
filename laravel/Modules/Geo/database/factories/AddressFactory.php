<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\Address;

/**
 * Address Factory.
 *
 * @extends Factory<Address>
 */
class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        $routes = ['Via Roma', 'Corso Italia', 'Piazza Duomo', 'Via Milano', 'Viale Europa'];
        $cities = ['Milano', 'Roma', 'Napoli', 'Torino', 'Palermo'];
        $regions = [
            'Lombardia',
            'Lazio',
            'Campania',
            'Sicilia',
            'Veneto',
            'Piemonte',
            'Toscana',
            'Emilia-Romagna',
            'Puglia',
            'Calabria',
        ];

        $route = $routes[array_rand($routes)];
        $streetNumber = (string) random_int(1, 300);
        $locality = $cities[array_rand($cities)];

        return [
            'route' => $route,
            'street_number' => $streetNumber,
            'postal_code' => (string) random_int(10000, 99999),
            'locality' => $locality,
            'administrative_area_level_1' => $regions[array_rand($regions)],
            'country' => 'IT',
            'latitude' => random_int(350000, 470000) / 10000, // Italy bounds
            'longitude' => random_int(60000, 190000) / 10000,
            'formatted_address' => $route.' '.$streetNumber.', '.$locality.', Italia',
        ];
    }

    public function italian(): static
    {
        $regions = ['Lombardia', 'Lazio', 'Campania', 'Sicilia', 'Veneto'];

        return $this->state(fn (array $_attributes))
            'country' => 'IT',
            'administrative_area_level_1' => $regions[array_rand($regions)],
        ]);
    }
}
