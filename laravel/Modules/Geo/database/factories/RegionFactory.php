<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\Region;

/**
 * Factory for Region model.
 *
 * @extends Factory<Region>
 */
class RegionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Region>
     */
    protected $model = Region::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Lista delle regioni italiane reali
        $regioniItaliane = [
            'Abruzzo',
            'Basilicata',
            'Calabria',
            'Campania',
            'Emilia-Romagna',
            'Friuli-Venezia Giulia',
            'Lazio',
            'Liguria',
            'Lombardia',
            'Marche',
            'Molise',
            'Piemonte',
            'Puglia',
            'Sardegna',
            'Sicilia',
            'Toscana',
            'Trentino-Alto Adige',
            'Umbria',
            "Valle d'Aosta",
            'Veneto',
        ];

        /** @var string $regionName */
        $regionName = $this->faker->unique()->randomElement($regioniItaliane);

        return [
            'name' => $regionName,
        ];
    }

    /**
     * Create a region from Northern Italy.
     */
    public function northern(): static
    {
        return $this->state(function (array $attributes): array {
            $regioniNord = [
                'Lombardia',
                'Piemonte',
                'Veneto',
                'Emilia-Romagna',
                'Liguria',
                'Friuli-Venezia Giulia',
                'Trentino-Alto Adige',
                "Valle d'Aosta",
            ];

            /** @var string $regionName */
            $regionName = $this->faker->randomElement($regioniNord);

            return array_merge($attributes, [
                'name' => $regionName,
            ]);
        });
    }

    /**
     * Create a region from Central Italy.
     */
    public function central(): static
    {
        return $this->state(function (array $attributes): array {
            $regioniCentro = [
                'Lazio',
                'Toscana',
                'Marche',
                'Umbria',
                'Abruzzo',
                'Molise',
            ];

            /** @var string $regionName */
            $regionName = $this->faker->randomElement($regioniCentro);

            return array_merge($attributes, [
                'name' => $regionName,
            ]);
        });
    }

    /**
     * Create a region from Southern Italy.
     */
    public function southern(): static
    {
        return $this->state(function (array $attributes): array {
            $regioniSud = [
                'Campania',
                'Puglia',
                'Calabria',
                'Basilicata',
                'Sicilia',
                'Sardegna',
            ];

            /** @var string $regionName */
            $regionName = $this->faker->randomElement($regioniSud);

            return array_merge($attributes, [
                'name' => $regionName,
            ]);
        });
    }

    /**
     * Create a specific region by name.
     */
    public function named(string $name): static
    {
        return $this->state(fn (array $attributes) => array_merge($attributes, [
            'name' => $name,
        ]));
    }
}
