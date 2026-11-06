<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Notify\Models\Theme;

/** @extends Factory<Theme> */
class ThemeFactory extends Factory
{
    protected $model = Theme::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'colors' => [
                'primary' => $this->faker->hexColor(),
                'secondary' => $this->faker->hexColor(),
            ],
            'fonts' => [
                'primary' => 'Arial',
                'secondary' => 'Georgia',
            ],
            'version' => 1,
            'is_active' => true,
        ];
    }
}