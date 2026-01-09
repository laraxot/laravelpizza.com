<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\User\Database\Factories\SsoProviderFactory;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\Traits\HasXotFactory;

/**
 * Modules\User\Models\SsoProvider.
 *
 * @property int         $id
 * @property string      $name
 * @property string      $display_name
 * @property string      $type
 * @property string|null $entity_id
 * @property string|null $client_id
 * @property string|null $client_secret
 * @property string|null $redirect_url
 * @property string|null $metadata_url
 * @property string|null $scopes
 * @property array|null  $settings
 * @property array|null  $domain_whitelist
 * @property array|null  $role_mapping
 * @property bool        $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @mixin IdeHelperSsoProvider
 *
 * @property Collection<int, User> $users
 * @property int|null              $users_count
 *
 * @method static Builder<static>|SsoProvider newModelQuery()
 * @method static Builder<static>|SsoProvider newQuery()
 * @method static Builder<static>|SsoProvider query()
 * @method static Builder<static>|SsoProvider whereClientId($value)
 * @method static Builder<static>|SsoProvider whereClientSecret($value)
 * @method static Builder<static>|SsoProvider whereCreatedAt($value)
 * @method static Builder<static>|SsoProvider whereCreatedBy($value)
 * @method static Builder<static>|SsoProvider whereDisplayName($value)
 * @method static Builder<static>|SsoProvider whereDomainWhitelist($value)
 * @method static Builder<static>|SsoProvider whereEntityId($value)
 * @method static Builder<static>|SsoProvider whereId($value)
 * @method static Builder<static>|SsoProvider whereIsActive($value)
 * @method static Builder<static>|SsoProvider whereMetadataUrl($value)
 * @method static Builder<static>|SsoProvider whereName($value)
 * @method static Builder<static>|SsoProvider whereRedirectUrl($value)
 * @method static Builder<static>|SsoProvider whereRoleMapping($value)
 * @method static Builder<static>|SsoProvider whereScopes($value)
 * @method static Builder<static>|SsoProvider whereSettings($value)
 * @method static Builder<static>|SsoProvider whereType($value)
 * @method static Builder<static>|SsoProvider whereUpdatedAt($value)
 * @method static Builder<static>|SsoProvider whereUpdatedBy($value)
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $deleter
 * @property ProfileContract|null $updater
 *
 * @method static SsoProviderFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class SsoProvider extends BaseModel
{
    use HasXotFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'type',
        'entity_id',
        'client_id',
        'client_secret',
        'redirect_url',
        'metadata_url',
        'scopes',
        'settings',
        'domain_whitelist',
        'role_mapping',
        'is_active',
    ];

    /**
     * Get all users associated with this SSO provider.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'sso_provider_id');
    }

    /**
     * Check if a given email domain is allowed for this provider.
     */
    public function isAllowedDomain(string $email): bool
    {
        if (empty($this->domain_whitelist)) {
            return true;
        }

        $atPos = strrchr($email, '@');
        if (false === $atPos) {
            return false;
        }

        $domain = substr($atPos, 1);

        return in_array($domain, $this->domain_whitelist, true);
    }

    /**
     * Map SAML/OIDC roles to application roles.
     *
     * @param array<string> $samlRoles
     *
     * @return list<string>
     */
    public function mapRoles(array $samlRoles): array
    {
        $mapping = $this->role_mapping ?? [];
        $roles = [];

        foreach ($samlRoles as $samlRole) {
            if (isset($mapping[$samlRole]) && is_string($mapping[$samlRole])) {
                $roles[] = $mapping[$samlRole];
            }
        }

        return $roles;
    }

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'domain_whitelist' => 'array',
            'role_mapping' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
