<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\OauthDeviceCode;

/**
 * @extends Factory<OauthDeviceCode>
 */
class OauthDeviceCodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = OauthDeviceCode::class;

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
