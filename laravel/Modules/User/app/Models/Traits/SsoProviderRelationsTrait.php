<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\User\Models\User;

/**
 * Eloquent relationships for SsoProvider.
 */
trait SsoProviderRelationsTrait
{
    /**
     * @return HasMany<User, $this>
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'sso_provider_id');
    }
}
