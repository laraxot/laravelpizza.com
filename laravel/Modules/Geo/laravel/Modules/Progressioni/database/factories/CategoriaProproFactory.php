<?php

declare(strict_types=1);

namespace Modules\Progressioni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Progressioni\Models\CategoriaPropro;

/**
 * Factory per la generazione di dati di test per il modello CategoriaPropro.
 *
 * @extends Factory<CategoriaPropro>
 */
class CategoriaProproFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<CategoriaPropro>
     */
    protected $model = CategoriaPropro::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categorie = ['A', 'B', 'C', 'D'];
        /** @var string $categoria */
        $categoria = $this->faker->randomElement($categorie);

        return [
            'categoria' => $categoria,
            'propro' => $this->faker->numberBetween(1, 8),
            'anno' => $this->faker->numberBetween(2020, 2025),
            'descrizione' => 'Categoria '.$categoria.' - Progressione economica',
            'created_by' => 'system',
            'updated_by' => 'system',
        ];
    }
}
