<?php

declare(strict_types=1);

namespace Modules\User\Models;

// use Laravel\Passport\AccessToken as PassportAccessToken;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Laravel\Passport\Token as PassportToken;
use Modules\Xot\Contracts\UserContract;

/**
 * Modules\User\Models\OauthAccessToken.
 *
 * @property string            $id
 * @property string|null       $user_id
 * @property string            $client_id
 * @property string|null       $name
 * @property array|null        $scopes
 * @property bool              $revoked
 * @property Carbon|null       $created_at
 * @property Carbon|null       $updated_at
 * @property Carbon|null       $expires_at
 * @property OauthClient|null  $client
 * @property UserContract|null $user
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
 *
 * @property OauthRefreshToken|null $refreshToken
 * @property string|null            $updated_by
 * @property string|null            $created_by
 * @property string|null            $deleted_at
 * @property string|null            $deleted_by
 *
 * @method static Builder<static>|OauthAccessToken whereCreatedBy($value)
 * @method static Builder<static>|OauthAccessToken whereDeletedAt($value)
 * @method static Builder<static>|OauthAccessToken whereDeletedBy($value)
 * @method static Builder<static>|OauthAccessToken whereUpdatedBy($value)
 * @method static static                           create(array $attributes = [])
 * @method static static                           firstOrCreate(array $attributes, array $values = [])
 * @method static static                           updateOrCreate(array $attributes, array $values = [])
 *
 * @mixin IdeHelperOauthAccessToken
 * @mixin \Eloquent
 */
class OauthAccessToken extends PassportToken
{
    /** @var string */
    protected $connection = 'user';

    // protected $fillable = ['id', 'user_id', 'client_id', 'name', 'scopes', 'revoked', 'expires_at'];
}
