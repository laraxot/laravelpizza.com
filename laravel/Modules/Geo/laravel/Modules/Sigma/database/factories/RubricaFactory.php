<?php

namespace Modules\Sigma\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Sigma\Models\Rubrica;

/**
 * @extends Factory<Rubrica>
 */
class RubricaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Rubrica::class;

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
