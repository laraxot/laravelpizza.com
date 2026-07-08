<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\Extra;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\User\Models\Extra>
 */
class ExtraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Extra::class;

    /**
     * Define the model's default state.
     */
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }
}
