<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

/**
 * GeoJsonModel is not an Eloquent model, so the Factory
 * generic is specified as base Model for PHPStan compatibility.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Illuminate\Database\Eloquent\Model>
 */
class GeoJsonModelFactory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    public function definition(): array
    {
        return ['name' => $this->faker->word()];
    }
}
