<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * GeoJsonModel is not an Eloquent model, so the Factory
 * generic is specified as base Model for PHPStan compatibility.
 *
 * @extends Factory<Model>
 */
class GeoJsonModelFactory extends Factory
{
    public function definition(): array
    {
        return ['name' => $this->faker->word()];
    }
}
