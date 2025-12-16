<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\Province;
use Modules\Geo\Models\Region;

/**
 * Factory for Province model.
 *
 * @extends Factory<Province>
 */
class ProvinceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Province>
     */
    protected $model = Province::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Lista delle province italiane reali
        $provinceItaliane = [
            'Agrigento',
            'Alessandria',
            'Ancona',
            'Aosta',
            'Arezzo',
            'Ascoli Piceno',
            'Asti',
            'Avellino',
            'Bari',
            'Barletta-Andria-Trani',
            'Belluno',
            'Benevento',
            'Bergamo',
            'Biella',
            'Bologna',
            'Bolzano',
            'Brescia',
            'Brindisi',
            'Cagliari',
            'Caltanissetta',
            'Campobasso',
            'Carbonia-Iglesias',
            'Caserta',
            'Catania',
            'Catanzaro',
            'Chieti',
            'Como',
            'Cosenza',
            'Cremona',
            'Crotone',
            'Cuneo',
            'Enna',
            'Fermo',
            'Ferrara',
            'Firenze',
            'Foggia',
            'Forlì-Cesena',
            'Frosinone',
            'Genova',
            'Gorizia',
            'Grosseto',
            'Imperia',
            'Isernia',
            'La Spezia',
            "L'Aquila",
            'Latina',
            'Lecce',
            'Lecco',
            'Livorno',
            'Lodi',
            'Lucca',
            'Macerata',
            'Mantova',
            'Massa-Carrara',
            'Matera',
            'Medio Campidano',
            'Messina',
            'Milano',
            'Modena',
            'Monza e Brianza',
            'Napoli',
            'Novara',
            'Nuoro',
            'Ogliastra',
            'Olbia-Tempio',
            'Oristano',
            'Padova',
            'Palermo',
            'Parma',
            'Pavia',
            'Perugia',
            'Pesaro e Urbino',
            'Pescara',
            'Piacenza',
            'Pisa',
            'Pistoia',
            'Pordenone',
            'Potenza',
            'Prato',
            'Ragusa',
            'Ravenna',
            'Reggio Calabria',
            'Reggio Emilia',
            'Rieti',
            'Rimini',
            'Roma',
            'Rovigo',
            'Salerno',
            'Sassari',
            'Savona',
            'Siena',
            'Siracusa',
            'Sondrio',
            'Taranto',
            'Teramo',
            'Terni',
            'Torino',
            'Trapani',
            'Trento',
            'Treviso',
            'Trieste',
            'Udine',
            'Varese',
            'Venezia',
            'Verbano-Cusio-Ossola',
            'Vercelli',
            'Verona',
            'Vibo Valentia',
            'Vicenza',
            'Viterbo',
        ];

        /** @var string $provinceName */
        $provinceName = $this->faker->unique()->randomElement($provinceItaliane);

        return [
            'name' => $provinceName,
            'region_id' => $this->faker->numberBetween(1, 20),
        ];
    }

    /**
     * Create a province from Northern Italy.
     */
    public function northern(): static
    {
        return $this->state(function (array $attributes): array {
            $provinceNord = [
                'Milano',
                'Torino',
                'Genova',
                'Bologna',
                'Venezia',
                'Verona',
                'Brescia',
                'Bergamo',
                'Padova',
                'Parma',
                'Modena',
                'Reggio Emilia',
                'Ravenna',
                'Ferrara',
                'Forlì-Cesena',
                'Rimini',
                'Piacenza',
                'Como',
                'Varese',
                'Monza e Brianza',
                'Cremona',
                'Mantova',
                'Pavia',
                'Sondrio',
                'Lecco',
                'Lodi',
                'Trento',
                'Bolzano',
                'Udine',
                'Trieste',
                'Pordenone',
                'Gorizia',
                'Belluno',
                'Treviso',
                'Vicenza',
                'Rovigo',
                'La Spezia',
                'Imperia',
                'Savona',
                'Aosta',
                'Novara',
                'Cuneo',
                'Asti',
                'Alessandria',
                'Vercelli',
                'Biella',
                'Verbano-Cusio-Ossola',
            ];

            /** @var string $provinceName */
            $provinceName = $this->faker->randomElement($provinceNord);

            return array_merge($attributes, [
                'name' => $provinceName,
            ]);
        });
    }

    /**
     * Create a province from Central Italy.
     */
    public function central(): static
    {
        return $this->state(function (array $attributes): array {
            $provinceCentro = [
                'Roma',
                'Firenze',
                'Pisa',
                'Livorno',
                'Siena',
                'Arezzo',
                'Grosseto',
                'Lucca',
                'Pistoia',
                'Prato',
                'Massa-Carrara',
                'Perugia',
                'Terni',
                'Ancona',
                'Pesaro e Urbino',
                'Macerata',
                'Ascoli Piceno',
                'Fermo',
                'Viterbo',
                'Rieti',
                'Frosinone',
                'Latina',
                "L'Aquila",
                'Teramo',
                'Pescara',
                'Chieti',
                'Campobasso',
                'Isernia',
            ];

            /** @var string $provinceName */
            $provinceName = $this->faker->randomElement($provinceCentro);

            return array_merge($attributes, [
                'name' => $provinceName,
            ]);
        });
    }

    /**
     * Create a province from Southern Italy.
     */
    public function southern(): static
    {
        return $this->state(function (array $attributes): array {
            $provinceSud = [
                'Napoli',
                'Salerno',
                'Caserta',
                'Avellino',
                'Benevento',
                'Bari',
                'Taranto',
                'Brindisi',
                'Lecce',
                'Foggia',
                'Barletta-Andria-Trani',
                'Potenza',
                'Matera',
                'Cosenza',
                'Catanzaro',
                'Reggio Calabria',
                'Crotone',
                'Vibo Valentia',
                'Palermo',
                'Catania',
                'Messina',
                'Siracusa',
                'Ragusa',
                'Trapani',
                'Agrigento',
                'Caltanissetta',
                'Enna',
                'Cagliari',
                'Sassari',
                'Nuoro',
                'Oristano',
                'Olbia-Tempio',
                'Ogliastra',
                'Medio Campidano',
                'Carbonia-Iglesias',
            ];

            /** @var string $provinceName */
            $provinceName = $this->faker->randomElement($provinceSud);

            return array_merge($attributes, [
                'name' => $provinceName,
            ]);
        });
    }

    /**
     * Create a specific province by name.
     */
    public function named(string $name): static
    {
        return $this->state(fn (array $attributes) => array_merge($attributes, [
            'name' => $name,
        ]));
    }

    /**
     * Create a province with a specific region.
     */
    public function forRegion(Region $region): static
    {
        return $this->state(fn (array $attributes) => array_merge($attributes, [
            'region_id' => $region->id,
        ]));
    }
}
