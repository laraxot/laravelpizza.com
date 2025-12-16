<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Xot\Models\XotBaseModel;

/**
 * @extends Factory<XotBaseModel>
 */
class XotBaseModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<XotBaseModel>
     */
    protected $model = XotBaseModel::class;

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
        ];
    }
}
