<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Xot\Models\XotBasePivot;

/**
 * Base Pivot Factory.
 *
 * Factory for XotBasePivot model.
 * This is the base factory for all module-specific Pivot implementations.
 *
 * @extends Factory<XotBasePivot>
 */
class XotBasePivotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<XotBasePivot>
     */
    protected $model = XotBasePivot::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'deleted_at' => fake()->optional(0.1)->dateTime(),
            'created_by' => fake()->optional(0.7)->uuid(),
            'updated_by' => fake()->optional(0.7)->uuid(),
            'deleted_by' => fake()->optional(0.1)->uuid(),
        ];
    }
}
