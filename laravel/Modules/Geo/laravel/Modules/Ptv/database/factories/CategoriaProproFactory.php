<?php

namespace Modules\Ptv\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Ptv\Models\CategoriaPropro;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Ptv\Models\CategoriaPropro> */
class CategoriaProproFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = CategoriaPropro::class;

    /**
     * Define the model's default state.
     */
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }
}
