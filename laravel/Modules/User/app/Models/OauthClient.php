<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Laravel\Passport\Client as PassportClient;

/**
 * @property string $id
 * @property string|null $name
 * @property string|null $secret
 * @property string|null $provider
 * @property string|null $redirect
 * @property bool $personal_access_client
 * @property bool $password_client
 * @property bool $revoked
 * @property string|null $user_id
 * @property User|null $user
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $owner_type
 * @property string|null $owner_id
 * @property array<int, string> $redirect_uris
 * @property array<string, bool> $grant_types
 * @property Collection<int, OauthAuthCode> $authCodes
 * @property int|null $auth_codes_count
 * @property \Illuminate\Foundation\Auth\User|null $owner
 * @property string|null $plain_secret
 * @property Collection<int, OauthToken> $tokens
 * @property int|null $tokens_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient existsIn(array<int, string> $haystack)
 * @method static \Laravel\Passport\Database\Factories\ClientFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient whereGrantTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient whereOwnerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient wherePasswordClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient wherePersonalAccessClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient whereRedirect($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient whereRedirectUris($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient whereRevoked($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthClient whereUserId($value)
 *
 * @mixin \Eloquent
 */
class OauthClient extends PassportClient
{
    protected $connection = 'user';
}
