<?php

declare(strict_types=1);

namespace Modules\Ptv\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Ptv\Models\CriteriValutazione;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Ptv\Models\CriteriValutazione> */
class CriteriValutazioneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = CriteriValutazione::class;

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
