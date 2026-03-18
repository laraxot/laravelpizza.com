<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\OauthClient;
use Modules\User\Models\OauthToken;
use Modules\User\Models\User;

/**
 * OauthToken Factory.
 *
 * Factory for creating OauthToken (Passport Access Token) model instances.
 *
 * @extends Factory<OauthToken>
 */
class OauthTokenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<OauthToken>
     */
    protected $model = OauthToken::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'user_id' => User::factory(),
            'client_id' => OauthClient::factory(),
            'name' => $this->faker->sentence(3),
            'scopes' => $this->faker->randomElements(
                ['read', 'write', 'admin', 'user'],
                $this->faker->numberBetween(0, 3),
            ),
            'revoked' => $this->faker->boolean(5),
            'expires_at' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
        ];
    }

    /**
     * Indicate that the token has been revoked.
     */
    public function revoked(): static
    {
        return $this->state(fn (): array => [
            'revoked' => true,
        ]);
    }

    /**
     * Indicate that the token has not been revoked.
     */
    public function notRevoked(): static
    {
        return $this->state(fn (): array => [
            'revoked' => false,
        ]);
    }

    /**
     * Indicate that the token is expired.
     */
    public function expired(): static
    {
        return $this->state(fn (): array => [
            'expires_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Indicate that the token is still valid.
     */
    public function valid(): static
    {
        return $this->state(fn (): array => [
            'revoked' => false,
            'expires_at' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
        ]);
    }

    /**
     * Create a token for a specific user.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (): array => [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Create a token for a specific client.
     */
    public function forClient(OauthClient $client): static
    {
        return $this->state(fn (): array => [
            'client_id' => $client->id,
        ]);
    }

    /**
     * Create a token with specific scopes.
     *
     * @param array<string> $scopes
     */
    public function withScopes(array $scopes): static
    {
        return $this->state(fn (): array => [
            'scopes' => $scopes,
        ]);
    }
}
