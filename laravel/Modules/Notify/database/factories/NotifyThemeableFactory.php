<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Notify\Models\NotifyTheme;
use Modules\Notify\Models\NotifyThemeable;

/**
 * NotifyThemeable Factory
 *
 * @extends Factory<NotifyThemeable>
 */
class NotifyThemeableFactory extends Factory
{
    protected $model = NotifyThemeable::class;

    public function definition(): array
    {
        return [
            'notify_theme_id' => NotifyTheme::factory(),
            'themeable_type' => $faker->randomElement([
                'Modules\\User\\Models\\User',
                'Modules\\User\\Models\\User', // Generic fallback instead of project-specific
                'Modules\\User\\Models\\User', // Generic fallback instead of project-specific
            ]),
            'themeable_id' => $faker->randomNumber()
        ];
    }

    public function forUser(): static
    {
        return $this->state(fn (array $_attributes
            'themeable_type' => 'Modules\\User\\Models\\User',
        ]);
    }

    public function forPatient(): static
    {
        return $this->state(fn (array $_attributes
            'themeable_type' => 'Modules\\User\\Models\\User', // Generic fallback
        ]);
    }
}
