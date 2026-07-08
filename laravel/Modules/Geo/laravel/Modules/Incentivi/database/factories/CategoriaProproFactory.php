<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Incentivi\Models\CategoriaPropro;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Incentivi\Models\CategoriaPropro>
 */
class CategoriaProproFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\Incentivi\Models\CategoriaPropro>
     */
    protected $model = CategoriaPropro::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'anno' => $this->faker->year(),
            'matr' => $this->faker->randomNumber(5),
            'propro' => $this->faker->randomNumber(2),
        ];
    }
}
