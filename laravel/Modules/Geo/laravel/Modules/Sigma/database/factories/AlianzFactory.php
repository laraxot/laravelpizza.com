<?php

namespace Modules\Sigma\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Sigma\Models\Alianz;

/**
 * @extends Factory<Alianz>
 */
class AlianzFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Alianz::class;

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
