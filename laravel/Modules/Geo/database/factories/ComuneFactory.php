<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\Comune;

/**
 * Factory for Comune model.
 *
 * @extends Factory<Comune>
 */
class ComuneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Comune>
     */
    protected $model = Comune::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Lista di comuni italiani reali per dati più realistici
        /**
         * @var non-empty-list<array{
         *   nome: string,
         *   regione: string,
         *   provincia: string,
         *   cap: string,
         *   lat: float|int|string,
         *   lng: float|int|string
         * }>
         */
        $comuniReali = [
            [
                'nome' => 'Milano',
                'regione' => 'Lombardia',
                'provincia' => 'Milano',
                'cap' => '20100',
                'lat' => 45.4642,
                'lng' => 9.1900,
            ],
            [
                'nome' => 'Roma',
                'regione' => 'Lazio',
                'provincia' => 'Roma',
                'cap' => '00100',
                'lat' => 41.9028,
                'lng' => 12.4964,
            ],
            [
                'nome' => 'Napoli',
                'regione' => 'Campania',
                'provincia' => 'Napoli',
                'cap' => '80100',
                'lat' => 40.8518,
                'lng' => 14.2681,
            ],
            [
                'nome' => 'Torino',
                'regione' => 'Piemonte',
                'provincia' => 'Torino',
                'cap' => '10100',
                'lat' => 45.0703,
                'lng' => 7.6869,
            ],
            [
                'nome' => 'Palermo',
                'regione' => 'Sicilia',
                'provincia' => 'Palermo',
                'cap' => '90100',
                'lat' => 38.1157,
                'lng' => 13.3613,
            ],
            [
                'nome' => 'Genova',
                'regione' => 'Liguria',
                'provincia' => 'Genova',
                'cap' => '16100',
                'lat' => 44.4056,
                'lng' => 8.9463,
            ],
            [
                'nome' => 'Bologna',
                'regione' => 'Emilia-Romagna',
                'provincia' => 'Bologna',
                'cap' => '40100',
                'lat' => 44.4949,
                'lng' => 11.3426,
            ],
            [
                'nome' => 'Firenze',
                'regione' => 'Toscana',
                'provincia' => 'Firenze',
                'cap' => '50100',
                'lat' => 43.7696,
                'lng' => 11.2558,
            ],
            [
                'nome' => 'Bari',
                'regione' => 'Puglia',
                'provincia' => 'Bari',
                'cap' => '70100',
                'lat' => 41.1171,
                'lng' => 16.8719,
            ],
            [
                'nome' => 'Catania',
                'regione' => 'Sicilia',
                'provincia' => 'Catania',
                'cap' => '95100',
                'lat' => 37.5079,
                'lng' => 15.0830,
            ],
        ];

        /** @var array{nome: string, regione: string, provincia: string, cap: string, lat: float|int|string, lng: float|int|string} $comuneData */
        $comuneData = $this->faker->randomElement($comuniReali);
        $latBase = (float) $comuneData['lat'];
        $lngBase = (float) $comuneData['lng'];

        return [
            'nome' => $comuneData['nome'],
            'codice' => $this->faker->unique()->numberBetween(1000, 9999),
            'regione' => $comuneData['regione'],
            'provincia' => $comuneData['provincia'],
            'sigla_provincia' => strtoupper(substr((string) $comuneData['provincia'], 0, 2)),
            'cap' => $comuneData['cap'],
            'codice_catastale' => $this->faker->unique()->regexify('[A-Z][0-9]{3}'),
            'popolazione' => $this->faker->numberBetween(1000, 1000000),
            'zona_altimetrica' => $this->faker->randomElement(['montagna', 'collina', 'pianura']),
            'altitudine' => $this->faker->numberBetween(0, 2000),
            'superficie' => $this->faker->randomFloat(2, 5.0, 500.0),
            'lat' => $latBase + $this->faker->randomFloat(4, -0.1, 0.1),
            'lng' => $lngBase + $this->faker->randomFloat(4, -0.1, 0.1),
        ];
    }

    /**
     * Create a comune in Lombardia region.
     */
    public function lombardia(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<int, array{nome: string, provincia: string, cap: string}> $comuniLombardia */
            $comuniLombardia = [
                ['nome' => 'Milano', 'provincia' => 'Milano', 'cap' => '20100'],
                ['nome' => 'Bergamo', 'provincia' => 'Bergamo', 'cap' => '24100'],
                ['nome' => 'Brescia', 'provincia' => 'Brescia', 'cap' => '25100'],
                ['nome' => 'Como', 'provincia' => 'Como', 'cap' => '22100'],
                ['nome' => 'Varese', 'provincia' => 'Varese', 'cap' => '21100'],
            ];

            /** @var array{nome: string, provincia: string, cap: string} $comuneData */
            $comuneData = $this->faker->randomElement($comuniLombardia);

            return array_merge($attributes, [
                'nome' => $comuneData['nome'],
                'regione' => 'Lombardia',
                'provincia' => $comuneData['provincia'],
                'cap' => $comuneData['cap'],
            ]);
        });
    }

    /**
     * Create a comune in Emilia-Romagna region.
     */
    public function emiliaRomagna(): static
    {
        return $this->state(function (array $attributes): array {
            /** @var array<int, array{nome: string, provincia: string, cap: string}> $comuniEmiliaRomagna */
            $comuniEmiliaRomagna = [
                ['nome' => 'Bologna', 'provincia' => 'Bologna', 'cap' => '40100'],
                ['nome' => 'Modena', 'provincia' => 'Modena', 'cap' => '41100'],
                ['nome' => 'Parma', 'provincia' => 'Parma', 'cap' => '43100'],
                ['nome' => 'Reggio Emilia', 'provincia' => 'Reggio Emilia', 'cap' => '42100'],
                ['nome' => 'Ferrara', 'provincia' => 'Ferrara', 'cap' => '44100'],
                ['nome' => 'Ravenna', 'provincia' => 'Ravenna', 'cap' => '48100'],
                ['nome' => 'Forlì', 'provincia' => 'Forlì-Cesena', 'cap' => '47100'],
                ['nome' => 'Cesena', 'provincia' => 'Forlì-Cesena', 'cap' => '47521'],
                ['nome' => 'Rimini', 'provincia' => 'Rimini', 'cap' => '47900'],
                ['nome' => 'Piacenza', 'provincia' => 'Piacenza', 'cap' => '29100'],
            ];

            /** @var array{nome: string, provincia: string, cap: string} $comuneData */
            $comuneData = $this->faker->randomElement($comuniEmiliaRomagna);

            return array_merge($attributes, [
                'nome' => $comuneData['nome'],
                'regione' => 'Emilia-Romagna',
                'provincia' => $comuneData['provincia'],
                'cap' => $comuneData['cap'],
            ]);
        });
    }

    /**
     * Create a small comune (under 5000 inhabitants).
     */
    public function small(): static
    {
        return $this->state([
            'popolazione' => $this->faker->numberBetween(500, 5000),
            'superficie' => $this->faker->randomFloat(2, 5.0, 50.0),
        ]);
    }

    /**
     * Create a large comune (over 100000 inhabitants).
     */
    public function large(): static
    {
        return $this->state([
            'popolazione' => $this->faker->numberBetween(100000, 2800000),
            'superficie' => $this->faker->randomFloat(2, 100.0, 1285.0),
        ]);
    }

    /**
     * Create a mountain comune.
     */
    public function mountain(): static
    {
        return $this->state([
            'zona_altimetrica' => 'montagna',
            'altitudine' => $this->faker->numberBetween(800, 3500),
            'popolazione' => $this->faker->numberBetween(500, 15000),
        ]);
    }

    /**
     * Create a coastal comune.
     */
    public function coastal(): static
    {
        return $this->state([
            'zona_altimetrica' => 'pianura',
            'altitudine' => $this->faker->numberBetween(0, 50),
            'popolazione' => $this->faker->numberBetween(2000, 100000),
        ]);
    }

    /**
     * Create a specific comune by name.
     */
    public function named(string $name): static
    {
        return $this->state(fn (array $attributes) => array_merge($attributes, [
            'nome' => $name,
        ]));
    }
}
