<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Laravel\Passport\Client as PassportClient;
use Modules\User\Database\Factories\OauthClientFactory;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Traits\HasRoles;

/**
 * OAuth Client wrapper con Authorizable e HasRoles per permessi a livello client.
 *
 * @property string            $id
 * @property string|null       $name
 * @property string|null       $secret
 * @property string|null       $provider
 * @property string|null       $redirect
 * @property bool              $personal_access_client
 * @property bool              $password_client
 * @property bool              $revoked
 * @property string|null       $user_id
 * @property UserContract|null $user
 *
 * @see https://github.com/aurmich/sample_passport/blob/develop/app/Models/Client.php
 */
final class OauthClient extends PassportClient implements AuthorizableContract
{
    use Authorizable;
    use HasFactory;
    use HasRoles;

    /**
     * Guard per Spatie Permission (client API, non web).
     *
     * @var string
     */
    public $guard_name = 'api';

    /** @var string */
    protected $connection = 'user';

    /**
     * Get the user that the client belongs to.
     *
     * Override: usa XotData::getUserClass() invece di config() per compatibilita Laraxot.
     */
    public function user(): BelongsTo
    {
        /** @var class-string<\Illuminate\Database\Eloquent\Model> $userClass */
        $userClass = XotData::make()->getUserClass();

        return $this->belongsTo($userClass, 'user_id'); // @phpstan-ignore return.type
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): OauthClientFactory
    {
        return OauthClientFactory::new();
    }

    /**
     * Determine if the entity has a given ability.
     *
     * @param iterable<string>|string $ability
     * @param array<mixed>            $arguments
     */
    #[\Override]
    public function can($ability, mixed $arguments = []): bool
    {
        if (is_string($ability)) {
            return $this->checkPermission($ability);
        }

        return $this->hasAnyPermission($ability);
    }

    /**
     * Determine if the entity does not have a given ability.
     *
     * @param iterable<string>|string $ability
     * @param array<mixed>            $arguments
     */
    public function cant($ability, $arguments = []): bool
    {
        return ! $this->can($ability, $arguments);
    }

    /**
     * Determine if the entity does not have a given ability.
     *
     * @param iterable<string>|string $ability
     * @param array<mixed>            $arguments
     */
    public function cannot($ability, $arguments = []): bool
    {
        return $this->cant($ability, $arguments);
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
            if ($this->can($ability, $arguments)) {
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
