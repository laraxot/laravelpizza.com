<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\IndennitaCondizioniLavoro\Models\StabiDirigente;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\IndennitaCondizioniLavoro\Models\StabiDirigente>
 */
class StabiDirigenteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = StabiDirigente::class;

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
