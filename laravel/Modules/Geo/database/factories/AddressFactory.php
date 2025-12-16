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
        return [
            'route' => $this->faker->streetName(),
            'street_number' => $this->faker->buildingNumber(),
            'postal_code' => $this->faker->postcode(),
            'locality' => $this->faker->city(),
            // Use explicit Italian regions to avoid calling unavailable faker->state()
            'administrative_area_level_1' => $this->faker->randomElement([
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
            ]),
            'country' => 'IT',
            'latitude' => $this->faker->latitude(35.0, 47.0), // Italy bounds
            'longitude' => $this->faker->longitude(6.0, 19.0),
            'formatted_address' => $this->faker->address(),
        ];
    }

    public function italian(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'country' => 'IT',
            'administrative_area_level_1' => $this->faker->randomElement([
                'Lombardia',
                'Lazio',
                'Campania',
                'Sicilia',
                'Veneto',
            ]),
        ]);
    }
}
