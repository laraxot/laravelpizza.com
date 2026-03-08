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
            'name' => // @var mixed faker->words(3, true
            'description' => // @var mixed faker->sentence(
            'type' => // @var mixed faker->randomElement(['block', 'section', 'layout']
            'theme_ID' => Theme::factory(),
            'is_active' => true,
            'order' => 0,
        ];
    }
}
