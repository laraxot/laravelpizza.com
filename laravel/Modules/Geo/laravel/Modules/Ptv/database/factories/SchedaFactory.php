<?php

namespace Modules\Ptv\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Ptv\Models\Scheda;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Ptv\Models\Scheda> */
class SchedaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Scheda::class;

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
