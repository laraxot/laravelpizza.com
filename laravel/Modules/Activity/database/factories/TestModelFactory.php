<?php

declare(strict_types=1);

namespace Modules\Activity\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Activity\Models\TestModel;

/** @extends Factory<TestModel> */
final class TestModelFactory extends Factory
{
    /** @var class-string<TestModel> */
    protected $model = TestModel::class;

    /** @return array{name: string} */
    public function definition(): array
    {
        return ['name' => fake()->name()];
    }
}
