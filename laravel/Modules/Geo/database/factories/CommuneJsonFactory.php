<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

/**
 * ComuneJson is a GeoJsonModel reader, not an Eloquent model,
 * so the Factory generic is specified as base Model for PHPStan compatibility.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Illuminate\Database\Eloquent\Model>
 */
class CommuneJsonFactory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    public function definition(): array
    {
        return ['name' => $this->faker->word()];
    }
}
