<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\OauthAccessToken;
use Modules\User\Models\OauthClient;
use Modules\User\Models\User;

/**
 * OauthAccessToken Factory.
 *
 * Factory for creating OauthAccessToken model instances for testing and seeding.
 */
class OauthAccessTokenFactory extends Factory
{
    /** @phpstan-ignore-next-line Passport access token is an Eloquent model at runtime, but PHPStan loses that type here. */
    protected $model = OauthAccessToken::class;

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
            'name' => $this->faker->optional()->words(2, true),
            'scopes' => $this->faker->randomElements(
                ['read', 'write', 'admin', 'user'],
                $this->faker->numberBetween(1, 3),
            ),
            'revoked' => $this->faker->boolean(10),
            'expires_at' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }

    /**
     * Create a revoked token.
     */
    public function revoked(): static
    {
        return $this->state(fn (): array => [
            'revoked' => true,
        ]);
    }

    /**
     * Create an active token.
     */
    public function active(): static
    {
        return $this->state(fn (): array => [
            'revoked' => false,
            'expires_at' => $this->faker->dateTimeBetween('+1 day', '+1 year'),
        ]);
    }

    /**
     * Create token for a specific user.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (): array => [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Create token for a specific client.
     */
    public function forClient(OauthClient $client): static
    {
        return $this->state(fn (): array => [
            'client_id' => $client->id,
        ]);
    }

    /**
     * Create token with specific scopes.
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
