<?php

declare(strict_types=1);

namespace Modules\UI\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\UI\Models\Collection;

/**
 * @extends Factory<Collection>
 */
class CollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Collection::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'type' => 'block',
            'theme_id' => 1,
            'is_active' => true,
            'order' => 0,
        ];
    }
}
