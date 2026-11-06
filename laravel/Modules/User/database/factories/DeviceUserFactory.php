<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\DeviceUser;

/**
 * @extends Factory<DeviceUser>
 */
class DeviceUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = DeviceUser::class;

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
