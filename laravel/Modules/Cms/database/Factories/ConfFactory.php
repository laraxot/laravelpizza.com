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
            'key' => // @var mixed faker->unique(
            'value' => // @var mixed faker->sentence(
            'type' => // @var mixed faker->randomElement(['string', 'integer', 'boolean', 'json']
            'group' => // @var mixed faker->randomElement(['general', 'email', 'social', 'seo']
            'description' => // @var mixed faker->optional(
        ];
    }

    public function string(): static
    {
        return // @var mixed state(['type' => 'string'];
    }

    public function boolean(): static
    {
        return // @var mixed state([
            'type' => 'boolean',
            'value' => // @var mixed faker->boolean(
        ]);
    }
}
