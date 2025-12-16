<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GeoNamesCapFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Geo\Models\GeoNamesCap::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
