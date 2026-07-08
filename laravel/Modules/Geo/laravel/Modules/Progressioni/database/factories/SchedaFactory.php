<?php

declare(strict_types=1);

namespace Modules\Progressioni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Progressioni\Models\Scheda;

/**
 * Factory per la generazione di dati di test per il modello Scheda.
 *
 * Gestisce la creazione di schede di progressione per il personale,
 * includendo dati anagrafici, posizioni funzionali e criteri di valutazione.
 *
 * @extends Factory<Scheda>
 */
class SchedaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Scheda>
     */
    protected $model = Scheda::class;

    /**
     * Define the model's default state.
     *
     * Genera dati realistici per schede di progressione:
     * - Dati anagrafici del dipendente
     * - Posizioni funzionali e categorie
     * - Giorni di presenza e assenza
     * - Criteri di valutazione
     * - Punteggi e valutazioni
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $anno = $this->faker->numberBetween(2020, 2025);

        // Categorie contrattuali
        $categorie = ['A', 'B', 'C', 'D'];
        /** @var string $categoria */
        $categoria = $this->faker->randomElement($categorie);

        // Posizioni funzionali per categoria
        $posizioniFunzionali = [
            'A' => [1, 2, 3],
            'B' => [1, 2, 3, 4],
            'C' => [1, 2, 3, 4, 5],
            'D' => [1, 2, 3, 4, 5, 6],
        ];

        /** @var int $posfun */
        $posfun = $this->faker->randomElement($posizioniFunzionali[$categoria]);

        // Giorni lavorativi annuali (circa 250 giorni)
        $giorniLavorativi = 250;
        $ggPresenza = $this->faker->numberBetween(200, $giorniLavorativi);
        $ggAssenza = $giorniLavorativi - $ggPresenza;

        return [
            'post_type' => 'scheda_progressione',
            'scheda_type' => 'progressione_'.$anno,
            'ente' => 90, // Ente Provincia
            'matr' => $this->faker->unique()->numberBetween(10000, 99999),
            'cognome' => $this->faker->lastName(),
            'nome' => $this->faker->firstName(),
            'email' => $this->faker->safeEmail(),
            'propro' => $this->faker->numberBetween(1, 8),
            'posfun' => $posfun,
            'categoria_eco' => $categoria,
            'posiz' => $this->faker->numberBetween(1, 10),
            'posiz_txt' => 'Posizione '.$this->faker->numberBetween(1, 10),
            'clafun' => $this->faker->numberBetween(1, 5),
            'stabi' => $this->faker->numberBetween(1, 20),
            'stabi_txt' => 'Stabilimento '.$this->faker->numberBetween(1, 20),
            'repar' => $this->faker->numberBetween(1, 100),
            'repar_txt' => 'Reparto '.$this->faker->numberBetween(1, 100),
            'stabival' => $this->faker->numberBetween(1, 20),
            'reparval' => $this->faker->numberBetween(1, 100),
            'indir' => $this->faker->randomElement(['DIR', 'IND']),
            'gg_in_sede' => $this->faker->numberBetween(180, 230),
            'n_gg_in_sede' => $this->faker->numberBetween(180, 230),
            'gg_fuori_sede' => $this->faker->numberBetween(0, 50),
            'n_gg_fuori_sede' => $this->faker->numberBetween(0, 50),
            'gg_aspettative_in_sede' => $this->faker->numberBetween(0, 10),
            'gg_aspettative_fuori_sede' => $this->faker->numberBetween(0, 10),
            'gg_posiz_1_in_sede' => $this->faker->numberBetween(150, 220),
            'gg_presenza_anno' => $ggPresenza,
            'gg_assenza_anno' => $ggAssenza,
            'gg_asz_tip_cod_escluso_subito' => $this->faker->numberBetween(0, 30),
            'gg_anno' => $giorniLavorativi,
            'gg_cateco_posfun' => $this->faker->numberBetween(200, 250),
            'rep003' => $this->faker->numberBetween(1, 5),
            'disci1' => $this->faker->numberBetween(1, 10),
            'disci1_txt' => 'Disciplina '.$this->faker->numberBetween(1, 10),
            'rep2kd' => (int) ($anno.'0101'),
            'rep2ka' => (int) ($anno.'1231'),
            'qua2kd' => (int) ($anno.'0101'),
            'qua2ka' => (int) ($anno.'1231'),
            'dal' => (int) ($anno.'0101'),
            'al' => (int) ($anno.'1231'),
            'anno' => $anno,
            'valutatore_id' => $this->faker->numberBetween(1, 100),
            'ha_diritto' => $this->faker->boolean(80), // 80% hanno diritto
            'perf_ind_media' => $this->faker->randomFloat(2, 1.0, 4.0),
            'totale' => $this->faker->randomFloat(2, 50.0, 100.0),
            'totale_pond' => $this->faker->randomFloat(2, 40.0, 80.0),
            'punt_progressione_finale' => $this->faker->randomFloat(2, 30.0, 70.0),
            'excellences_count_last_3_years' => $this->faker->numberBetween(0, 3),
            'eta' => $this->faker->numberBetween(25, 65),
            'created_by' => 'system',
            'updated_by' => 'system',
        ];
    }

    /**
     * State per schede con diritto alla progressione.
     */
    public function conDiritto(): static
    {
        return $this->state(fn (array $attributes) => [
            'ha_diritto' => true,
        ]);
    }

    /**
     * State per schede senza diritto alla progressione.
     */
    public function senzaDiritto(): static
    {
        return $this->state(fn (array $attributes) => [
            'ha_diritto' => false,
        ]);
    }

    /**
     * State per una categoria specifica.
     */
    public function categoria(string $categoria): static
    {
        return $this->state(fn (array $attributes) => [
            'categoria_eco' => $categoria,
        ]);
    }

    /**
     * State per un anno specifico.
     */
    public function forAnno(int $anno): static
    {
        return $this->state(fn (array $attributes) => [
            'anno' => $anno,
            'rep2kd' => (int) ($anno.'0101'),
            'rep2ka' => (int) ($anno.'1231'),
            'qua2kd' => (int) ($anno.'0101'),
            'qua2ka' => (int) ($anno.'1231'),
            'dal' => (int) ($anno.'0101'),
            'al' => (int) ($anno.'1231'),
        ]);
    }

    /**
     * State per performance elevate.
     */
    public function performanceElevata(): static
    {
        return $this->state(fn (array $attributes) => [
            'perf_ind_media' => $this->faker->randomFloat(2, 3.5, 4.0),
            'totale' => $this->faker->randomFloat(2, 80.0, 100.0),
            'punt_progressione_finale' => $this->faker->randomFloat(2, 60.0, 70.0),
            'excellences_count_last_3_years' => $this->faker->numberBetween(2, 3),
        ]);
    }
}
