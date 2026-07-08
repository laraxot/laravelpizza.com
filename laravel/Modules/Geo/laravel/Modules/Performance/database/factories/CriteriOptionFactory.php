<?php

declare(strict_types=1);

namespace Modules\Performance\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Performance\Models\CriteriOption;

/** @extends Factory<\Modules\Performance\Models\CriteriOption> */
class CriteriOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = CriteriOption::class;

    /**
     * Define the model's default state.
     */
    /**
     * @return array{}
     */
    public function definition(): array
    {
        return [];
    }
}
