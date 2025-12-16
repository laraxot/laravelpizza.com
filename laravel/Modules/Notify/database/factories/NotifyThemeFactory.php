<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\NotifyTheme;

/**
 * @extends Factory<NotifyTheme>
 */
class NotifyThemeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<NotifyTheme>
     */
    protected $model = NotifyTheme::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'id' => fake()->randomNumber(5, false),
            'lang' => fake()->word,
            'type' => fake()->word,
            'subject' => fake()->word,
            'body' => fake()->text,
            'body_html' => fake()->text,
            'from' => fake()->word,
        ];
    }
}
