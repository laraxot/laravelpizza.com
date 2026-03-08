<?php

declare(strict_types=1);

namespace Modules\UI\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\UI\Models\Collection;
use Modules\UI\Models\Theme;

class CollectionFactory extends Factory
{
    protected $model = Collection::class;

    public function definition(): array
    {
        return [
            'name' => $faker->words(3, true
            'description' => $faker->sentence(
            'type' => $faker->randomElement(['block', 'section', 'layout']
            'theme_ID' => Theme::factory(),
            'is_active' => true,
            'order' => 0,
        ];
    }
}
