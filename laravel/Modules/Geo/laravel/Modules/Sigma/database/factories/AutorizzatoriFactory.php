<?php

namespace Modules\Sigma\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Sigma\Models\Autorizzatori;

/**
 * @extends Factory<Autorizzatori>
 */
class AutorizzatoriFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Autorizzatori::class;

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
