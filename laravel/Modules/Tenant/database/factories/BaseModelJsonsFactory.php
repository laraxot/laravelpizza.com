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
            'created_at' => \Carbon\Carbon::now()->subDays(random_int(1, 365)),
            'updated_at' => \Carbon\Carbon::now()->subDays(random_int(0, 30)),
            'created_by' => (string) random_int(1000000000000000, 9999999999999999),
            'updated_by' => (string) random_int(1000000000000000, 9999999999999999),
        ];
    }
}
