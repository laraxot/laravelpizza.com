<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\GeoNamesCap;

class GeoNamesCapFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = GeoNamesCap::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
