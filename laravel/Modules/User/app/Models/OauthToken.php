<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Support\Carbon;
use Laravel\Passport\Token as PassportToken;
use Modules\User\Traits\ResolvesPassportTokenUserRelation;

/**
 * @property bool $revoked
 * @property int|string|null $user_id
 * @property string $id
 * @property string $client_id
 * @property string|null $name
 * @property array<array-key, mixed>|null $scopes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $expires_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property OauthClient|null $client
 * @property OauthRefreshToken|null $refreshToken
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken existsIn(array<int, string> $haystack)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken whereRevoked($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken whereScopes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken whereUserId($value)
 *
 * @mixin \Eloquent
 */
class OauthToken extends PassportToken
{
    use ResolvesPassportTokenUserRelation;

    protected $connection = 'user';
}
