<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\IndennitaResponsabilita\Models\Rating;

/**
 * @extends Factory<\Modules\IndennitaResponsabilita\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Rating::class;

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
