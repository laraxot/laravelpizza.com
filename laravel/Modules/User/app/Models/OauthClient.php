<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Carbon;
use Laravel\Passport\Client as PassportClient;
use Laravel\Passport\Database\Factories\ClientFactory;
use Modules\Xot\Contracts\UserContract;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Traits\HasRoles;

/**
 * Modules\User\Models\OauthClient.
 *
 * @property string                                   $id
 * @property string|null                              $user_id
 * @property string                                   $name
 * @property string|null                              $secret
 * @property string|null                              $provider
 * @property string                                   $redirect
 * @property bool                                     $personal_access_client
 * @property bool                                     $password_client
 * @property bool                                     $revoked
 * @property Carbon|null                              $created_at
 * @property Carbon|null                              $updated_at
 * @property Collection<int, OauthAuthCode>           $authCodes
 * @property int|null                                 $auth_codes_count
 * @property array|null                               $grant_types
 * @property string|null                              $plain_secret
 * @property array|null                               $scopes
 * @property Collection<int, OauthAccessToken>        $tokens
 * @property int|null                                 $tokens_count
 * @property UserContract|null                        $user
 * @property \Illuminate\Database\Eloquent\Model|null $owner
 * @property string|null                              $updated_by
 * @property string|null                              $created_by
 *
 * @method static ClientFactory       factory($count = null, $state = [])
 * @method static Builder|OauthClient newModelQuery()
 * @method static Builder|OauthClient newQuery()
 * @method static Builder|OauthClient query()
 * @method static Builder|OauthClient whereCreatedAt($value)
 * @method static Builder|OauthClient whereId($value)
 * @method static Builder|OauthClient whereName($value)
 * @method static Builder|OauthClient wherePasswordClient($value)
 * @method static Builder|OauthClient wherePersonalAccessClient($value)
 * @method static Builder|OauthClient whereProvider($value)
 * @method static Builder|OauthClient whereRedirect($value)
 * @method static Builder|OauthClient whereRevoked($value)
 * @method static Builder|OauthClient whereSecret($value)
 * @method static Builder|OauthClient whereUpdatedAt($value)
 * @method static Builder|OauthClient whereUserId($value)
 * @method static Builder|OauthClient whereCreatedBy($value)
 * @method static Builder|OauthClient whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class OauthClient extends PassportClient implements AuthorizableContract
{
    use Authorizable;
    use HasRoles;

    /**
     * The name of the guard for Spatie Permission.
     * REQUIRED BY Spatie\Permission\Traits\HasRoles - MUST be public.
     *
     * @var string
     */
    public $guard_name = 'api';

    /** @var string */
    protected $connection = 'user';

    /**
     * Determine if the entity has a given ability.
     *
     * @param iterable|string $ability
     */
    #[\Override]
    public function can($ability, mixed $arguments = []): bool
    {
        if (is_string($ability)) {
            return $this->checkPermission($ability);
        }

        /** @var iterable<string> $ability */
        $permissions = $ability;

        return $this->hasAnyPermission($permissions);
    }

    /**
     * Determine if the entity does not have a given ability.
     *
     * @param iterable<string>|string $ability
     * @param array<mixed>            $arguments
     */
    public function cant($ability, $arguments = []): bool
    {
        return ! $this->can($ability);
    }

    /**
     * Determine if the entity does not have a given ability.
     *
     * @param iterable<string>|string $ability
     * @param array<mixed>            $arguments
     */
    public function cannot($ability, $arguments = []): bool
    {
        return $this->cant($ability);
    }

    /**
     * Determine if the entity has any of the given abilities.
     *
     * @param iterable<string> $abilities
     * @param array<mixed>     $arguments
     */
    public function canAny($abilities, $arguments = []): bool
    {
        foreach ((array) $abilities as $ability) {
            if ($this->can($ability)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if client has any of the given permissions.
     *
     * @param iterable<string> $permissions
     */
    private function hasAnyPermission(iterable $permissions): bool
    {
        /** @var iterable<string> $permissions */
        foreach ($permissions as $perm) {
            if ($this->checkPermission($perm)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if client has a single permission.
     */
    private function checkPermission(string $permission): bool
    {
        try {
            return $this->hasPermissionTo($permission);
        } catch (PermissionDoesNotExist) {
            return false;
        }
    }
}
