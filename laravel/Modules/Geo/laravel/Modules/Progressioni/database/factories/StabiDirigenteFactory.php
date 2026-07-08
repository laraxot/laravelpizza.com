<?php

declare(strict_types=1);

namespace Modules\Progressioni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Progressioni\Models\StabiDirigente;

/**
 * @extends Factory<StabiDirigente>
 */
class StabiDirigenteFactory extends Factory
{
    protected $model = StabiDirigente::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Business logic: rappresenta i dirigenti responsabili delle valutazioni di progressione
        $nomiDirigenti = [
            'Dott. Marco Rossi',
            'Dott.ssa Laura Bianchi',
            'Ing. Giuseppe Verdi',
            'Avv. Maria Neri',
            'Dott. Antonio Russo',
        ];

        return [
            'stabi' => $this->faker->numberBetween(1, 50),
            'repar' => $this->faker->numberBetween(1, 20),
            'nome_stabi' => $this->faker->company(),
            'stabi_txt' => $this->faker->company().' - Dipartimento',
            'repar_txt' => $this->faker->randomElement(['Risorse Umane', 'Amministrazione', 'Contabilità', 'Servizi Generali']),
            'ente' => $this->faker->numberBetween(1, 999),
            'matr' => $this->faker->numberBetween(1000, 9999),
            'anno' => $this->faker->numberBetween(2020, 2025),
            'nome_diri' => $this->faker->randomElement($nomiDirigenti),
            'nome_diri_plus' => (string) $this->faker->randomElement($nomiDirigenti).' - Responsabile Valutazioni',
            'budget' => $this->faker->numberBetween(10000, 50000).'.00',
            'valutatore_id' => $this->faker->numberBetween(1, 100),
        ];
    }
}
