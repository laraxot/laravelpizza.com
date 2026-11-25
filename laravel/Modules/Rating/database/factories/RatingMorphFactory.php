<?php

declare(strict_types=1);

namespace Modules\Rating\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Rating\Models\RatingMorph;

/** @extends Factory<RatingMorph> */
class RatingMorphFactory extends Factory
{
    protected $model = RatingMorph::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
