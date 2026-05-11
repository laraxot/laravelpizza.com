<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Passport\PersonalAccessTokenResult;
use Laravel\Passport\Token;
use Laravel\Passport\TransientToken;

/**
 * @phpstan-require-extends Model
 */
interface PassportHasApiTokensContract
{
    /**
     * Get all of the user's registered OAuth clients.
     */
    public function clients(): HasMany;

    /**
     * Get all of the access tokens for the user.
     */
    public function tokens(): HasMany;

    /**
     * Get the current access token being used by the user.
     */
    public function token(): Token|TransientToken|null;

    /**
     * Determine if the current API token has a given scope.
     */
    public function tokenCan(string $scope): bool;

    /**
     * Create a new personal access token for the user.
     *
     * @param array<int, string> $scopes
     */
    public function createToken(string $name, array $scopes = []): PersonalAccessTokenResult;

    /**
     * Set the current access token for the user.
     *
     * @return $this
     */
    public function withAccessToken(Token|TransientToken|null $accessToken): static;
}
