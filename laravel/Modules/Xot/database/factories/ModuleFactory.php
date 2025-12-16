<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Xot\Models\Module;

/**
 * Module Factory
 *
 * @extends Factory<Module>
 */
class ModuleFactory extends Factory
{
    protected $model = Module::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'version' => $this->faker->semver(),
            'description' => $this->faker->sentence(),
            'is_active' => $this->faker->boolean(80),
            'priority' => $this->faker->numberBetween(1, 100),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'is_active' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'is_active' => false,
        ]);
    }

    public function highPriority(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'priority' => $this->faker->numberBetween(80, 100),
        ]);
    }
}
