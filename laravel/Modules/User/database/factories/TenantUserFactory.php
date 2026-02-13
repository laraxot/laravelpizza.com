<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\TenantUser;

/**
 * @extends Factory<TenantUser>
 */
class TenantUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TenantUser>
     */
    protected $model = TenantUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => fake()->uuid(),
            'user_id' => fake()->uuid(),
        ];
    }
}
