<?php

namespace Modules\Sigma\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Sigma\Models\Alidatum;

/**
 * @extends Factory<Alidatum>
 */
class AlidatumFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Alidatum::class;

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
