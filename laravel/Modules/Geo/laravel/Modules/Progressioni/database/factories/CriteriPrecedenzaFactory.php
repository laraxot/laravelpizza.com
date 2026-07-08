<?php

declare(strict_types=1);

namespace Modules\Progressioni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Progressioni\Models\CriteriPrecedenza;

/**
 * @extends Factory<CriteriPrecedenza>
 */
class CriteriPrecedenzaFactory extends Factory
{
    protected $model = CriteriPrecedenza::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $criteriNames = [
            'anzianita_servizio' => 'Anzianità di servizio',
            'performance_media' => 'Performance media triennio',
            'eccellenze_ultimo_triennio' => 'Eccellenze ultimo triennio',
            'giorni_sede' => 'Giorni in sede',
            'eta_anagrafica' => 'Età anagrafica',
        ];

        /** @var string $criterio */
        $criterio = $this->faker->randomElement(array_keys($criteriNames));

        return [
            'parent_id' => 0,
            'name' => $criterio,
            'order_direction' => $this->faker->randomElement(['ASC', 'DESC']),
            'label' => $criteriNames[$criterio],
            'descr' => 'Criterio per la valutazione delle progressioni: '.$criteriNames[$criterio],
            'post_type' => 'criterio',
            'posizione' => $this->faker->numberBetween(1, 10),
            'anno' => $this->faker->numberBetween(2020, 2025),
        ];
    }
}
