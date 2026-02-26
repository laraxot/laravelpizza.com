<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AuthenticationLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\User\Models\AuthenticationLog::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
