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
<<<<<<< HEAD
    /**
     * The name of the factory's corresponding model.
     */
=======
>>>>>>> 40b96bcd6 (.)
    protected $model = Treatment::class;

    /**
     * @return array<string, mixed>
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
