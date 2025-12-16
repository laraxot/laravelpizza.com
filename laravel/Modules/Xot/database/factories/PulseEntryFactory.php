<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Xot\Models\PulseEntry;

/**
 * @extends Factory<PulseEntry>
 */
class PulseEntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<PulseEntry>
     */
    protected $model = PulseEntry::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
