<?php

declare(strict_types=1);

namespace Modules\Gdpr\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\Gdpr\Models\Treatment;

/**
 * @extends Factory<Treatment>
 */
class TreatmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Treatment>
     */
    protected $model = Treatment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
