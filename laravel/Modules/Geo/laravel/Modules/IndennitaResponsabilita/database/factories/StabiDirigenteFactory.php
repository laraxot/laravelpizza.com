<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\IndennitaResponsabilita\Models\StabiDirigente;

/**
 * @extends Factory<\Modules\IndennitaResponsabilita\Models\StabiDirigente>
 */
class StabiDirigenteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = StabiDirigente::class;

    /**
     * Define the model's default state.
     *
     * @return array{}
     */
    public function definition(): array
    {
        return [];
    }
}
