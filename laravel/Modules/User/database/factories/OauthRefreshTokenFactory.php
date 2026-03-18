<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
<<<<<<< Updated upstream
=======
use Modules\User\Models\OauthToken;
>>>>>>> Stashed changes
use Modules\User\Models\OauthClient;
use Modules\User\Models\OauthRefreshToken;
use Modules\User\Models\OauthToken;

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
            'access_token_id' => fn (): string => $this->newAccessTokenId(),
            'revoked' => $this->faker->boolean(5),
            'expires_at' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
        ];
    }

    protected function newAccessTokenId(): string
    {
<<<<<<< Updated upstream
        /** @var OauthToken $token */
        $token = (new OauthAccessTokenFactory())->create([
            'id' => $this->faker->uuid(),
            'user_id' => null,
            'client_id' => OauthClient::factory(),
            'name' => 'Test Token',
            'scopes' => [],
            'revoked' => false,
            'expires_at' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
        ]);

        return (string) $token->id;
=======
        return $this->faker->uuid();
>>>>>>> Stashed changes
    }

    public function revoked(): static
    {
        return $this->state(['revoked' => true]);
    }

    public function expired(): static
    {
        return $this->state([
            'expires_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }
}
