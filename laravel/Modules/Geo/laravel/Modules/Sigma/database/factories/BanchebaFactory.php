<?php

namespace Modules\Sigma\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Sigma\Models\Bancheba;

/**
 * @extends Factory<Bancheba>
 */
class BanchebaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Bancheba::class;

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
