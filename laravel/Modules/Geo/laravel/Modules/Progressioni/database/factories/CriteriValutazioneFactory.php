<?php

declare(strict_types=1);

namespace Modules\Progressioni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Progressioni\Models\CriteriValutazione;

/**
 * Factory per la generazione di dati di test per il modello CriteriValutazione.
 *
 * Gestisce la creazione di criteri di valutazione per le progressioni,
 * includendo criteri gerarchici e strutturati.
 *
 * @extends Factory<CriteriValutazione>
 */
class CriteriValutazioneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<CriteriValutazione>
     */
    protected $model = CriteriValutazione::class;

    /**
     * Define the model's default state.
     *
     * Genera dati realistici per criteri di valutazione:
     * - Criteri di valutazione delle progressioni
     * - Struttura gerarchica parent/child
     * - Posizioni ordinate per la visualizzazione
     * - Descrizioni dettagliate
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $anno = $this->faker->numberBetween(2020, 2025);

        // Criteri di valutazione comuni per progressioni
        $criteriComuni = [
            [
                'name' => 'anzianita_servizio',
                'label' => 'Anzianità di Servizio',
                'descr' => 'Valutazione basata sui anni di servizio presso l\'ente',
            ],
            [
                'name' => 'performance_individuale',
                'label' => 'Performance Individuale',
                'descr' => 'Valutazione delle performance individuali negli ultimi anni',
            ],
            [
                'name' => 'formazione_professionale',
                'label' => 'Formazione Professionale',
                'descr' => 'Attività formative e aggiornamento professionale',
            ],
            [
                'name' => 'presenza_servizio',
                'label' => 'Presenza in Servizio',
                'descr' => 'Giorni di presenza effettiva in servizio',
            ],
            [
                'name' => 'titolo_studio',
                'label' => 'Titolo di Studio',
                'descr' => 'Livello di istruzione e titoli di studio posseduti',
            ],
            [
                'name' => 'competenze_specifiche',
                'label' => 'Competenze Specifiche',
                'descr' => 'Competenze specifiche relative al ruolo',
            ],
        ];

        /** @var array{name: string, label: string, descr: string} $criterio */
        $criterio = $this->faker->randomElement($criteriComuni);

        return [
            'parent_id' => 0, // Default no parent
            'name' => $criterio['name'],
            'label' => $criterio['label'],
            'descr' => $criterio['descr'],
            'post_type' => 'criterio_valutazione',
            'posizione' => $this->faker->numberBetween(1, 100),
            'anno' => $anno,
            'created_by' => 'system',
            'updated_by' => 'system',
        ];
    }

    /**
     * State per criterio principale (senza parent).
     */
    public function principale(): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => 0,
            'posizione' => $this->faker->numberBetween(1, 10),
        ]);
    }

    /**
     * State per sottocriterio (con parent).
     */
    public function sottocriterio(int $parentId): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => $parentId,
            'posizione' => $this->faker->numberBetween(1, 5),
        ]);
    }

    /**
     * State per criterio di anzianità.
     */
    public function anzianita(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'anzianita_servizio',
            'label' => 'Anzianità di Servizio',
            'descr' => 'Valutazione basata sui anni di servizio presso l\'ente',
        ]);
    }

    /**
     * State per criterio di performance.
     */
    public function performance(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'performance_individuale',
            'label' => 'Performance Individuale',
            'descr' => 'Valutazione delle performance individuali negli ultimi anni',
        ]);
    }

    /**
     * State per criterio di formazione.
     */
    public function formazione(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'formazione_professionale',
            'label' => 'Formazione Professionale',
            'descr' => 'Attività formative e aggiornamento professionale',
        ]);
    }

    /**
     * State per criterio di presenza.
     */
    public function presenza(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'presenza_servizio',
            'label' => 'Presenza in Servizio',
            'descr' => 'Giorni di presenza effettiva in servizio',
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

    /**
     * State per una posizione specifica.
     */
    public function posizione(int $posizione): static
    {
        return $this->state(fn (array $attributes) => [
            'posizione' => $posizione,
        ]);
    }
}
