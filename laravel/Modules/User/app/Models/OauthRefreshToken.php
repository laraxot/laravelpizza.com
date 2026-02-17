<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Laravel\Passport\RefreshToken as PassportRefreshToken;

/**
 * Modules\User\Models\OauthRefreshToken.
 *
 * @property OauthAccessToken|null $accessToken
 *
 * @method static Builder|OauthRefreshToken newModelQuery()
 * @method static Builder|OauthRefreshToken newQuery()
 * @method static Builder|OauthRefreshToken query()
 *
 * @property string $id
 * @property string $access_token_id
 * @property bool $revoked
 * @property Carbon|null $expires_at
 *
 * @method static Builder|OauthRefreshToken whereAccessTokenId($value)
 * @method static Builder|OauthRefreshToken whereExpiresAt($value)
 * @method static Builder|OauthRefreshToken whereId($value)
 * @method static Builder|OauthRefreshToken whereRevoked($value)
 *
 * @mixin IdeHelperOauthRefreshToken
 * @mixin \Eloquent
 */
class OauthRefreshToken extends PassportRefreshToken
{
    /*
     * @var string
     */
    protected $connection = 'user';

    // protected $fillable = ['id', 'access_token_id', 'revoked', 'expires_at'];
}
