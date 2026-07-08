<?php

declare(strict_types=1);

namespace Modules\Progressioni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Progressioni\Models\MaxCatecoPosfunAnno;

/**
 * @extends Factory<MaxCatecoPosfunAnno>
 */
class MaxCatecoPosfunAnnoFactory extends Factory
{
    protected $model = MaxCatecoPosfunAnno::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Business logic: rappresenta i limiti massimi per categoria economica e posizione funzionale
        // Questi dati definiscono quanti dipendenti possono essere promossi per ogni categoria/posizione
        $categorie = ['A', 'B', 'C', 'D'];
        $posizioni = ['F1', 'F2', 'F3', 'F4', 'F5'];

        return [
            'cateco' => $this->faker->randomElement($categorie),
            'posfun' => $this->faker->randomElement($posizioni),
            'anno' => $this->faker->numberBetween(2020, 2025),
            'max_gg_tot_pond' => $this->faker->numberBetween(1000, 10000).'.00',
            'aventi_diritto' => $this->faker->numberBetween(10, 100),
            'aventi_diritto_perc' => $this->faker->numberBetween(10, 30), // % di promozioni consentite
            'aventi_diritto_eff' => $this->faker->numberBetween(1, 20), // numero effettivo calcolato
        ];
    }
}
