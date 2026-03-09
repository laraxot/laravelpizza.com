<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\OauthClient;
use Modules\User\Models\User;

/**
 * OauthClient Factory.
 *
 * Factory for creating OauthClient model instances for testing and seeding.
 *
 * @extends Factory<OauthClient>
 */
class OauthClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<OauthClient>
     */
    protected $model = OauthClient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $faker->uuid()
            'user_id' => $faker->optional()
            'name' => $faker->company()
            'secret' => $faker->sha256()
            'provider' => $faker->optional()
            'redirect' => $faker->url()
            'personal_access_client' => $faker->boolean(20)
            'password_client' => $faker->boolean(30)
            'revoked' => $faker->boolean(5)
            'grant_types' => $faker->optional()
                [
                    'authorization_code',
                    'client_credentials',
                    'password',
                    'refresh_token',
                ],
                $faker->numberBetween(1, 3)
            ),
            'scopes' => $faker->optional()
                [
                    'read',
                    'write',
                    'admin',
                    'user',
                ],
                $faker->numberBetween(1, 3)
            ),
        ];
    }

    /**
     * Create a personal access client.
     */
    public function personalAccess(): static
    {
        return $this->state(fn (array $_attributes))
            'personal_access_client' => true,
            'password_client' => false,
            'name' => 'Personal Access Client',
        ]);
    }

    /**
     * Create a password client.
     */
    public function password(): static
    {
        return $this->state(fn (array $_attributes))
            'password_client' => true,
            'personal_access_client' => false,
            'name' => 'Password Grant Client',
        ]);
    }

    /**
     * Create a revoked client.
     */
    public function revoked(): static
    {
        return $this->state(fn (array $_attributes))
            'revoked' => true,
        ]);
    }

    /**
     * Create an active client.
     */
    public function active(): static
    {
        return $this->state(fn (array $_attributes))
            'revoked' => false,
        ]);
    }

    /**
     * Create client for a specific user.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (array $_attributes))
            'user_id' => $user->id,
        ]);
    }

    /**
     * Create client with specific redirect URI.
     */
    public function withRedirectUri(string $redirectUri): static
    {
        return $this->state(fn (array $_attributes))
            'redirect' => $redirectUri,
        ]);
    }

    /**
     * Create client with specific scopes.
     *
     * @param array<string> $scopes
     */
    public function withScopes(array $scopes): static
    {
        return $this->state(fn (array $_attributes))
            'scopes' => $scopes,
        ]);
    }
}
