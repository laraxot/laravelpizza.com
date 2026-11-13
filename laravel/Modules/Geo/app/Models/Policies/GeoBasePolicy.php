<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Xot\Contracts\UserContract;

abstract class GeoBasePolicy
{
    use HandlesAuthorization;

    public function before(UserContract $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Il ruolo che apre il pannello del modulo gestisce tutto il modulo (ADR Xot module-admin-role-policy-bypass).
        if ($user->hasRole('geo::admin')) {
            return true;
        }

        return null;
    }
}
