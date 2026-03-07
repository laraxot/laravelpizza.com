<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Laravel\Passport\Token as PassportToken;
use Modules\Xot\Contracts\UserContract;

/**
 * Modules\User\Models\OauthToken.
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
 * @method static Builder|OauthToken                                       newModelQuery()
 * @method static Builder|OauthToken                                       newQuery()
 * @method static Builder|OauthToken                                       query()
 * @method static Builder|OauthToken                                       whereClientId($value)
 * @method static Builder|OauthToken                                       whereCreatedAt($value)
 * @method static Builder|OauthToken                                       whereExpiresAt($value)
 * @method static Builder|OauthToken                                       whereId($value)
 * @method static Builder|OauthToken                                       whereName($value)
 * @method static Builder|OauthToken                                       whereRevoked($value)
 * @method static Builder|OauthToken                                       whereScopes($value)
 * @method static Builder|OauthToken                                       whereUpdatedAt($value)
 * @method static Builder|OauthToken                                       whereUserId($value)
 * @method static Builder|OauthToken                                       whereCreatedBy($value)
 * @method static Builder|OauthToken                                       whereDeletedAt($value)
 * @method static Builder|OauthToken                                       whereDeletedBy($value)
 * @method static Builder|OauthToken                                       whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthToken existsIn(array $haystack)
 *
 * @mixin \Eloquent
 */
class OauthToken extends PassportToken
{
    /** @var string */
    protected $connection = 'user';

    /**
     * Get the user associated with this token.
     * Override Passport's user() to handle null provider gracefully.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        $provider = $this->getTokenGuardProvider();

        if (null === $provider) {
            return $this->belongsTo(
                config('auth.guards.api.provider') ?? User::class,
                'user_id'
            );
        }

        return $this->belongsTo(
            config("auth.providers.{$provider}.model", User::class),
            'user_id'
        );
    }

    /**
     * Get the token guard provider.
     */
    protected function getTokenGuardProvider(): ?string
    {
        foreach (config('auth.guards', []) as $guard => $config) {
            if (($config['driver'] ?? null) === 'passport') {
                return $config['provider'] ?? null;
            }
        }

        return null;
    }
}
