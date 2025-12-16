<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Xot\Models\PulseAggregate;

/**
 * @extends Factory<PulseAggregate>
 */
class PulseAggregateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<PulseAggregate>
     */
    protected $model = PulseAggregate::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
