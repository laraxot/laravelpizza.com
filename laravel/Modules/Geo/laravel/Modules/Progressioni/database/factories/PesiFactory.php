<?php

declare(strict_types=1);

namespace Modules\Progressioni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Progressioni\Models\Pesi;

/**
 * Factory per la generazione di dati di test per il modello Pesi.
 *
 * @extends Factory<Pesi>
 */
class PesiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Pesi>
     */
    protected $model = Pesi::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->word(),
            'valore' => $this->faker->randomFloat(2, 0.1, 1.0),
            'descrizione' => $this->faker->sentence(),
            'anno' => $this->faker->numberBetween(2020, 2025),
            'categoria' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'created_by' => 'system',
            'updated_by' => 'system',
        ];
    }
}
