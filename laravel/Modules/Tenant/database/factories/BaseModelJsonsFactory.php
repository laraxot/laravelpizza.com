<?php

declare(strict_types=1);

namespace Modules\Tenant\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenant\Models\BaseModelJsons;

/**
 * @extends Factory<BaseModelJsons>
 */
class BaseModelJsonsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<BaseModelJsons>
     */
    protected $model = BaseModelJsons::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'created_by' => $this->faker->uuid(),
            'updated_by' => $this->faker->uuid(),
        ];
    }
}
