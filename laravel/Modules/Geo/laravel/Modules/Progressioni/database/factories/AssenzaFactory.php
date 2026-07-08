<?php

declare(strict_types=1);

namespace Modules\Progressioni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Progressioni\Models\Assenza;

/**
 * Factory per la generazione di dati di test per il modello Assenza.
 *
 * Gestisce la creazione di codici assenze per le progressioni di carriera,
 * includendo tipi di assenza, codici identificativi e descrizioni.
 *
 * @extends Factory<Assenza>
 */
class AssenzaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Assenza>
     */
    protected $model = Assenza::class;

    /**
     * Define the model's default state.
     *
     * Genera dati realistici per codici assenze utilizzati nelle progressioni:
     * - Tipi di assenza comuni (malattia, ferie, permessi, ecc.)
     * - Codici numerici identificativi
     * - Descrizioni appropriate
     * - Unità di misura (giorni/ore)
     * - Durate tipiche
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $anno = $this->faker->numberBetween(2020, 2025);

        // Tipi di assenza comuni nel sistema pubblico
        $tipiAssenza = [
            ['tipo' => 1, 'descr' => 'Malattia ordinaria'],
            ['tipo' => 2, 'descr' => 'Ferie'],
            ['tipo' => 3, 'descr' => 'Permessi retribuiti'],
            ['tipo' => 4, 'descr' => 'Aspettativa non retribuita'],
            ['tipo' => 5, 'descr' => 'Congedo parentale'],
            ['tipo' => 6, 'descr' => 'Congedo matrimoniale'],
            ['tipo' => 7, 'descr' => 'Permessi sindacali'],
            ['tipo' => 8, 'descr' => 'Formazione professionale'],
        ];

        /** @var array{tipo: int, descr: string} $assenza */
        $assenza = $this->faker->randomElement($tipiAssenza);

        return [
            'tipo' => $assenza['tipo'],
            'codice' => $this->faker->numberBetween(1, 99),
            'descr' => $assenza['descr'],
            'anno' => $anno,
            'umi' => $this->faker->randomElement(['G', 'O']), // G=Giorni, O=Ore
            'dur' => $this->faker->numberBetween(1, 365), // Durata in giorni/ore
            'created_by' => 'system',
            'updated_by' => 'system',
        ];
    }

    /**
     * State per assenze di malattia.
     */
    public function malattia(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo' => 1,
            'descr' => 'Malattia ordinaria',
            'umi' => 'G',
        ]);
    }

    /**
     * State per ferie.
     */
    public function ferie(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo' => 2,
            'descr' => 'Ferie',
            'umi' => 'G',
        ]);
    }

    /**
     * State per permessi retribuiti.
     */
    public function permessi(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo' => 3,
            'descr' => 'Permessi retribuiti',
            'umi' => 'O',
        ]);
    }

    /**
     * State per un anno specifico.
     */
    public function forAnno(int $anno): static
    {
        return $this->state(fn (array $attributes) => [
            'anno' => $anno,
        ]);
    }
}
