<?php

namespace Modules\Sigma\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Sigma\Models\Comuni;

/**
 * @extends Factory<Comuni>
 */
class ComuniFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Comuni::class;

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
