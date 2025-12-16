<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Laravel\Passport\PersonalAccessTokenResult;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
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
     * @param string $scope
     * @return bool
     */
    public function tokenCan($scope);

    /**
     * Create a new personal access token for the user.
     *
     * @param string $name
     * @param array<int, string> $scopes
     * @return PersonalAccessTokenResult
     */
    public function createToken($name, array $scopes = []);

    /**
     * Set the current access token for the user.
     *
     * @param Token|TransientToken $accessToken
     * @return $this
     */
    public function withAccessToken($accessToken);
}
