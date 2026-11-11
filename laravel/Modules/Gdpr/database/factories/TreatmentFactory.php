<?php

declare(strict_types=1);

namespace Modules\Gdpr\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Gdpr\Models\Treatment;

/**
 * @extends Factory<Treatment>
 */
class TreatmentFactory extends Factory
{
    protected $model = Treatment::class;

    /**
     * @return array<string, bool|int|string>
     */
    public function definition(): array
    {
        return [
            'name' => 'treatment-'.fake()->unique()->uuid(),
            'description' => fake()->sentence(),
            'weight' => fake()->numberBetween(1, 10),
            'active' => true,
            'required' => false,
        ];
    }
}
