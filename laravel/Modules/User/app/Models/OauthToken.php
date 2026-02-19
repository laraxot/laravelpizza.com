<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Laravel\Passport\Token as PassportToken;
use Modules\Xot\Contracts\UserContract;

/**
 * Modules\User\Models\OauthAccessToken.
 *
 * @property string                 $id
 * @property string|null            $user_id
 * @property string                 $client_id
 * @property string|null            $name
 * @property array|null             $scopes
 * @property bool                   $revoked
 * @property Carbon|null            $created_at
 * @property Carbon|null            $updated_at
 * @property Carbon|null            $expires_at
 * @property string|null            $updated_by
 * @property string|null            $created_by
 * @property string|null            $deleted_at
 * @property string|null            $deleted_by
 * @property OauthClient|null       $client
 * @property UserContract|null      $user
 * @property OauthRefreshToken|null $refreshToken
 *
 * @method static Builder|OauthAccessToken newModelQuery()
 * @method static Builder|OauthAccessToken newQuery()
 * @method static Builder|OauthAccessToken query()
 * @method static Builder|OauthAccessToken whereClientId($value)
 * @method static Builder|OauthAccessToken whereCreatedAt($value)
 * @method static Builder|OauthAccessToken whereExpiresAt($value)
 * @method static Builder|OauthAccessToken whereId($value)
 * @method static Builder|OauthAccessToken whereName($value)
 * @method static Builder|OauthAccessToken whereRevoked($value)
 * @method static Builder|OauthAccessToken whereScopes($value)
 * @method static Builder|OauthAccessToken whereUpdatedAt($value)
 * @method static Builder|OauthAccessToken whereUserId($value)
 * @method static Builder|OauthAccessToken whereCreatedBy($value)
 * @method static Builder|OauthAccessToken whereDeletedAt($value)
 * @method static Builder|OauthAccessToken whereDeletedBy($value)
 * @method static Builder|OauthAccessToken whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class OauthToken extends PassportToken
{
    /** @var string */
    protected $connection = 'user';
}
