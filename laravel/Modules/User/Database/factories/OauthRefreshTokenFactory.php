<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\OauthRefreshToken;

/**
 * OauthRefreshToken Factory.
 *
 * @extends Factory<OauthRefreshToken>
 */
class OauthRefreshTokenFactory extends Factory
{
    protected $model = OauthRefreshToken::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->sha256(),
            'access_token_id' => fn (): string => $this->faker->sha256(),
            'revoked' => $this->faker->boolean(5),
            'expires_at' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
        ];
    }

    public function revoked(): static
    {
        return $this->state(['revoked' => true]);
    }

    public function expired(): static
    {
        return $this->state(['expires_at' => $this->faker->dateTimeBetween('-1 month', 'now')]);
    }
}
