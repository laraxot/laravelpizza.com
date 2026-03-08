<?php

declare(strict_types=1);

namespace Modules\UI\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\UI\Models\Theme;

class ThemeFactory extends Factory
{
    protected $model = Theme::class;

    public function definition(): array
    {
        return [
            'name' => // @var mixed faker->words(3, true
            'description' => // @var mixed faker->sentence(
            'is_active' => // @var mixed faker->boolean(
            'config' => [
                'primary_color' => '#007bff',
                'secondary_color' => '#6c757d',
                'font_family' => 'Arial, sans-serif',
            ],
            'needs_compilation' => false,
        ];
    }
}
