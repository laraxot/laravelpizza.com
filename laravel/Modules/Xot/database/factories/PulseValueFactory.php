<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Xot\Models\PulseValue;

/**
 * @extends Factory<PulseValue>
 */
class PulseValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<PulseValue>
     */
    protected $model = PulseValue::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
