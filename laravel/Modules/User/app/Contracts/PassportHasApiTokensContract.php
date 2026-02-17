<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\User\Contracts;

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
     *
     * @return HasMany
     */
    public function clients();

    /**
     * Get all of the access tokens for the user.
     *
     * @return HasMany
     */
    public function tokens();

    /**
     * Get the current access token being used by the user.
     *
     * @return Token|TransientToken|null
     */
    public function token();

    /**
     * Determine if the current API token has a given scope.
     *
     * @param  string  $scope
     * @return bool
     */
    public function tokenCan($scope);

    /**
     * Create a new personal access token for the user.
     *
     * @param  array<int, string>  $scopes
     */
    public function createToken(string $name, array $scopes = []): PersonalAccessTokenResult;

    /**
     * Set the current access token for the user.
     */
    public function withAccessToken(Token|TransientToken|null $accessToken): static;
}
