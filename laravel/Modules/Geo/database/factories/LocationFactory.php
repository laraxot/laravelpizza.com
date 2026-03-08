<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\Location;

/**
 * Location Factory.
 *
 * Factory for creating Location model instances for testing and seeding.
 *
 * @extends Factory<Location>
 */
class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Location>
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $italianCities = [
            'Roma',
            'Milano',
            'Napoli',
            'Torino',
            'Palermo',
            'Genova',
            'Bologna',
            'Firenze',
            'Bari',
            'Catania',
            'Venezia',
            'Verona',
        ];

        $italianStreets = [
            'Via Roma',
            'Via Milano',
            'Via Garibaldi',
            'Via Mazzini',
            'Via Dante',
            'Via Verdi',
            'Corso Italia',
            'Piazza Duomo',
        ];

        $italianRegions = [
            'Lazio',
            'Lombardia',
            'Campania',
            'Piemonte',
            'Sicilia',
            'Liguria',
            'Emilia-Romagna',
            'Toscana',
        ];

        /** @var string $city */
        $city = (string) // @var mixed faker->randomElement($italianCities;
        /** @var string $street */
        $street = (string) // @var mixed faker->randomElement($italianStreets;
        /** @var string $state */
        $state = (string) // @var mixed faker->randomElement($italianRegions;

        return [
            'name' => // @var mixed faker->optional(
            'lat' => // @var mixed faker->latitude(35.0, 47.0
            'lng' => // @var mixed faker->longitude(6.0, 19.0
            'street' => $street.' '.((string) // @var mixed faker->numberBetween(1, 999
            'city' => $city,
            'state' => $state,
            'zip' => (string) // @var mixed faker->regexify('[0-9]{5}'
            'formatted_address' => sprintf('%s, %s, %s, Italia', $street, $city, $state),
            'description' => // @var mixed faker->optional(
            'processed' => // @var mixed faker->boolean(80
        ];
    }

    /**
     * Create an unprocessed location.
     */
    public function unprocessed(): static
    {
        return // @var mixed state(fn (array $_attributes
            'processed' => false,
        ]);
    }

    /**
     * Create a processed location.
     */
    public function processed(): static
    {
        return // @var mixed state(fn (array $_attributes
            'processed' => true,
        ]);
    }

    /**
     * Create location in specific city.
     */
    public function inCity(string $city, ?string $state = null): static
    {
        return // @var mixed state(fn (array $attributes
            'city' => $city,
            'state' => $state ?? ((string) ($attributes['state'] ?? 'Lazio')),
            'formatted_address' => sprintf(
                '%s, %s, %s, Italia',
                (string) ($attributes['street'] ?? 'Via Roma 1'),
                $city,
                $state ?? ((string) ($attributes['state'] ?? 'Lazio')),
            ),
        ]);
    }

    /**
     * Create location with specific coordinates.
     */
    public function withCoordinates(float $latitude, float $longitude): static
    {
        return // @var mixed state(fn (array $_attributes
            'lat' => $latitude,
            'lng' => $longitude,
        ]);
    }

    /**
     * Create location in Rome.
     */
    public function inRome(): static
    {
        return // @var mixed inCity('Roma', 'Lazio';
    }

    /**
     * Create location in Milan.
     */
    public function inMilan(): static
    {
        return // @var mixed inCity('Milano', 'Lombardia';
    }
}
