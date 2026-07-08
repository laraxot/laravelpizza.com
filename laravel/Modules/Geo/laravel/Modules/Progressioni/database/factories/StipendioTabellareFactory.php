<?php

declare(strict_types=1);

namespace Modules\Progressioni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Progressioni\Models\StipendioTabellare;

/**
 * Factory per la generazione di dati di test per il modello StipendioTabellare.
 *
 * Gestisce la creazione di stipendi tabellari per le diverse categorie
 * e posizioni funzionali del personale.
 *
 * @extends Factory<StipendioTabellare>
 */
class StipendioTabellareFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<StipendioTabellare>
     */
    protected $model = StipendioTabellare::class;

    /**
     * Define the model's default state.
     *
     * Genera dati realistici per stipendi tabellari:
     * - Categorie contrattuali del settore pubblico
     * - Posizioni funzionali appropriate
     * - Importi stipendiali coerenti
     * - Codici propro validi
     * - Percentuali part-time
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $anno = $this->faker->numberBetween(2020, 2025);

        // Categorie contrattuali del settore pubblico
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

        // Importi base per categoria (euro annui)
        $importiBase = [
            'A' => $this->faker->numberBetween(18000, 22000),
            'B' => $this->faker->numberBetween(22000, 28000),
            'C' => $this->faker->numberBetween(28000, 35000),
            'D' => $this->faker->numberBetween(35000, 45000),
        ];

        /** @var int $importoBase */
        $importoBase = $importiBase[$categoria];
        $incrementoPosizione = $posfun * 1000; // Incremento per posizione funzionale
        $importoStipendioAnnuo = $importoBase + $incrementoPosizione;

        $ptime = $this->faker->randomElement(['100', '75', '50']); // Percentuale part-time
        $euroPond = (string) round($importoStipendioAnnuo * (float) $ptime / 100, 2);

        return [
            'categoria' => $categoria,
            'lista_propro' => implode(',', range(1, $this->faker->numberBetween(3, 8))),
            'posfun' => $posfun,
            'dal' => $anno.'0101',
            'al' => $anno.'1231',
            'propro' => $this->faker->numberBetween(1, 8),
            'euro_pond' => $euroPond,
            'ptime' => $ptime,
            'euro' => (string) $importoStipendioAnnuo,
            'importo_stipendio_annuo' => (string) $importoStipendioAnnuo,
            'anno' => $anno,
            'created_by' => 'system',
            'updated_by' => 'system',
        ];
    }

    /**
     * State per categoria A.
     */
    public function categoriaA(): static
    {
        return $this->state(fn (array $attributes) => [
            'categoria' => 'A',
            'posfun' => $this->faker->numberBetween(1, 3),
        ]);
    }

    /**
     * State per categoria B.
     */
    public function categoriaB(): static
    {
        return $this->state(fn (array $attributes) => [
            'categoria' => 'B',
            'posfun' => $this->faker->numberBetween(1, 4),
        ]);
    }

    /**
     * State per categoria C.
     */
    public function categoriaC(): static
    {
        return $this->state(fn (array $attributes) => [
            'categoria' => 'C',
            'posfun' => $this->faker->numberBetween(1, 5),
        ]);
    }

    /**
     * State per categoria D.
     */
    public function categoriaD(): static
    {
        return $this->state(fn (array $attributes) => [
            'categoria' => 'D',
            'posfun' => $this->faker->numberBetween(1, 6),
        ]);
    }

    /**
     * State per un anno specifico.
     */
    public function forAnno(int $anno): static
    {
        return $this->state(fn (array $attributes) => [
            'anno' => $anno,
            'dal' => $anno.'0101',
            'al' => $anno.'1231',
        ]);
    }

    /**
     * State per tempo pieno.
     */
    public function tempoPieno(): static
    {
        return $this->state(fn (array $attributes) => [
            'ptime' => '100',
        ]);
    }

    /**
     * State per part-time 50%.
     */
    public function partTime50(): static
    {
        return $this->state(fn (array $attributes) => [
            'ptime' => '50',
        ]);
    }
}
