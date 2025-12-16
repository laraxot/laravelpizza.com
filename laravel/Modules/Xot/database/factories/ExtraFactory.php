<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Xot\Models\Extra;

/**
 * @extends Factory<Extra>
 */
class ExtraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Extra>
     */
    protected $model = Extra::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
