<?php

namespace Modules\Performance\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\Modules\Performance\Models\CategoriaPropro>
 */
class CategoriaProproFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Performance\Models\CategoriaPropro::class;

    /**
     * Define the model's default state.
     */
    /**
     * @return array{}
     */
    public function definition(): array
    {
        return [];
    }
}

