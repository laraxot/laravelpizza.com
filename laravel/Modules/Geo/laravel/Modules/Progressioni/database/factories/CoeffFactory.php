<?php

declare(strict_types=1);

namespace Modules\Progressioni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Progressioni\Models\Coeff;

/**
 * Factory per la generazione di dati di test per il modello Coeff.
 *
 * @extends Factory<Coeff>
 */
class CoeffFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Coeff>
     */
    protected $model = Coeff::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->word(),
            'valore' => $this->faker->randomFloat(4, 0.0001, 2.0000),
            'descrizione' => $this->faker->sentence(),
            'anno' => $this->faker->numberBetween(2020, 2025),
            'created_by' => 'system',
            'updated_by' => 'system',
        ];
    }
}
