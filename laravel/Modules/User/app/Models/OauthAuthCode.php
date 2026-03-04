<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Laravel\Passport\AuthCode as PassportAuthCode;

/**
 * Modules\User\Models\OauthAuthCode.
 *
 * @property OauthClient|null $client
 *
 * @method static Builder|OauthAuthCode newModelQuery()
 * @method static Builder|OauthAuthCode newQuery()
 * @method static Builder|OauthAuthCode query()
 *
 * @property string $id
 * @property string|null $user_id
 * @property string|null $client_id
 * @property string|null $scopes
 * @property bool $revoked
 * @property Carbon|null $expires_at
 *
 * @method static Builder|OauthAuthCode whereClientId($value)
 * @method static Builder|OauthAuthCode whereExpiresAt($value)
 * @method static Builder|OauthAuthCode whereId($value)
 * @method static Builder|OauthAuthCode whereRevoked($value)
 * @method static Builder|OauthAuthCode whereScopes($value)
 * @method static Builder|OauthAuthCode whereUserId($value)
 *
 * @mixin IdeHelperOauthAuthCode
 * @mixin \Eloquent
 */
class OauthAuthCode extends PassportAuthCode
{
    /** @var string */
    protected $connection = 'user';

    // protected $fillable = ['id', 'user_id', 'client_id', 'scopes', 'revoked', 'expires_at'];
}
