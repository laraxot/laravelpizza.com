<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Passport\Client as PassportClient;

/**
 * Modules\User\Models\OauthClient.
 *
 * @property int                             $id
 * @property string|null                     $user_id
 * @property string                          $name
 * @property string|null                     $secret
 * @property string|null                     $provider
 * @property string                          $redirect
 * @property bool                            $personal_access_client
 * @property bool                            $password_client
 * @property bool                            $revoked
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property User|null                       $user
 *
 * @method static Builder|OauthClient newModelQuery()
 * @method static Builder|OauthClient newQuery()
 * @method static Builder|OauthClient query()
 *
 * @mixin \Eloquent
 */
class OauthClient extends PassportClient
{
    /** @var string */
    protected $connection = 'mysql';

    /**
     * Get the user that the client belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Determine if the client has a specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        // Implementation logic for client permissions
        return false;
    }

    /**
     * Determine if the entity has a given ability.
     *
     * @param string $ability
     * @param array  $arguments
     */
    public function can($ability, $arguments = []): bool
    {
        return false;
    }

    /**
     * Determine if the entity does not have a given ability.
     *
     * @param string $ability
     * @param array  $arguments
     */
    public function cant($ability, $arguments = []): bool
    {
        return ! $this->can($ability);
    }

    /**
     * Determine if the entity does not have a given ability.
     *
     * @param string $ability
     * @param array  $arguments
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
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }
}
