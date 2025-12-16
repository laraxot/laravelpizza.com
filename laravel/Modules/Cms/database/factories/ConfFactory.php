<?php

declare(strict_types=1);

namespace Modules\Cms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cms\Models\Conf;

/**
 * Conf Factory.
 *
 * @extends Factory<Conf>
 */
class ConfFactory extends Factory
{
    protected $model = Conf::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->slug(),
            'value' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['string', 'integer', 'boolean', 'json']),
            'group' => $this->faker->randomElement(['general', 'email', 'social', 'seo']),
            'description' => $this->faker->optional()->sentence(),
        ];
    }

    public function string(): static
    {
        return $this->state(['type' => 'string']);
    }

    public function boolean(): static
    {
        return $this->state([
            'type' => 'boolean',
            'value' => $this->faker->boolean(),
        ]);
    }
}
