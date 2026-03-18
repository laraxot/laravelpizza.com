<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
<<<<<<< Updated upstream
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
=======
use Illuminate\Foundation\Auth\Access\Authorizable;
use Laravel\Passport\Client as PassportClient;
use Modules\User\Contracts\UserContract;
use Spatie\Permission\Traits\HasRoles;

/**
 * OAuth Client Model with Spatie Permission support.
 *
 * This model extends Laravel Passport's Client and adds the ability
 * to assign permissions/roles to OAuth clients for fine-grained access control.
 *
 * @property string           $id
 * @property string|null      $name
 * @property string|null      $secret
 * @property string|null      $provider
 * @property string|null      $redirect
 * @property bool             $personal_access_client
 * @property bool             $password_client
 * @property bool             $revoked
 * @property string|null       $user_id
 * @property UserContract|null $user
>>>>>>> Stashed changes
 */
final class OauthClient extends PassportClient implements AuthorizableContract
{
    use Authorizable;
<<<<<<< Updated upstream
    use HasFactory;
    use HasRoles;

=======
    use HasRoles;

    /**
     * The name of the guard for Spatie Permission.
     * REQUIRED BY Spatie\Permission\Traits\HasRoles - MUST be public.
     *
     * @var string
     */
    public $guard_name = 'api';

>>>>>>> Stashed changes
    /** @var string */
    protected $connection = 'user';

    /**
<<<<<<< Updated upstream
     * Guard per Spatie Permission (client API, non web).
     *
     * @var string
     */
    public $guard_name = 'api';

    /**
     * Get the user that the client belongs to.
     *
     * Override: usa XotData::getUserClass() invece di config() per compatibilità Laraxot.
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

        /* @var iterable<string> $ability */
        return $this->hasAnyPermission($ability);
=======
     * Determine if the entity has a given ability.
     *
     * @param iterable|string $abilities
     * @param mixed           $arguments
     */
    #[\Override]
    public function can($abilities, $arguments = []): bool
    {
        if (is_string($abilities)) {
            return $this->checkPermission($abilities);
        }

        /** @var iterable<string> $abilities */
        return $this->hasAnyPermission($abilities);
>>>>>>> Stashed changes
    }

    /**
     * Determine if the entity does not have a given ability.
     *
     * @param iterable<string>|string $ability
<<<<<<< Updated upstream
     * @param array<mixed>            $arguments
     */
    public function cant($ability, $arguments = []): bool
    {
        return ! $this->can($ability);
=======
     * @param array<mixed>           $arguments
     */
    public function cant($ability, $arguments = []): bool
    {
        return ! $this->can($ability, $arguments);
>>>>>>> Stashed changes
    }

    /**
     * Determine if the entity does not have a given ability.
     *
     * @param iterable<string>|string $ability
<<<<<<< Updated upstream
     * @param array<mixed>            $arguments
     */
    public function cannot($ability, $arguments = []): bool
    {
        return $this->cant($ability);
=======
     * @param array<mixed>           $arguments
     */
    public function cannot($ability, $arguments = []): bool
    {
        return $this->cant($ability, $arguments);
>>>>>>> Stashed changes
    }

    /**
     * Determine if the entity has any of the given abilities.
     *
     * @param iterable<string> $abilities
<<<<<<< Updated upstream
     * @param array<mixed>     $arguments
=======
     * @param array<mixed>    $arguments
>>>>>>> Stashed changes
     */
    public function canAny($abilities, $arguments = []): bool
    {
        foreach ((array) $abilities as $ability) {
<<<<<<< Updated upstream
            if ($this->can($ability)) {
=======
            if ($this->can($ability, $arguments)) {
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
        } catch (PermissionDoesNotExist) {
=======
        } catch (\Spatie\Permission\Exceptions\PermissionDoesNotExist) {
>>>>>>> Stashed changes
            return false;
        }
    }
}
