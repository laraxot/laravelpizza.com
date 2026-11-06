<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\Authentication;

/**
 * @extends Factory<Authentication>
 */
class AuthenticationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Authentication::class;

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
