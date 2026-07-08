<?php

declare(strict_types=1);

namespace Modules\Progressioni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Progressioni\Models\SchedaCriteri;

/**
 * Factory per la generazione di dati di test per il modello SchedaCriteri.
 *
 * @extends Factory<SchedaCriteri>
 */
class SchedaCriteriFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<SchedaCriteri>
     */
    protected $model = SchedaCriteri::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'scheda_id' => $this->faker->numberBetween(1, 1000),
            'criterio_id' => $this->faker->numberBetween(1, 100),
            'punteggio' => $this->faker->randomFloat(2, 0, 100),
            'note' => $this->faker->optional()->sentence(),
            'created_by' => 'system',
            'updated_by' => 'system',
        ];
    }
}
