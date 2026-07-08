<?php

namespace Modules\Sigma\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Sigma\Models\Coco1base;

/**
 * @extends Factory<Coco1base>
 */
class Coco1baseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Coco1base::class;

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
