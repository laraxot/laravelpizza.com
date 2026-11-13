<?php

declare(strict_types=1);

namespace Modules\Activity\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Xot\Contracts\UserContract;

abstract class ActivityBasePolicy
{
    use HandlesAuthorization;

    public function before(UserContract $user): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Il ruolo che apre il pannello del modulo gestisce tutto il modulo (ADR Xot module-admin-role-policy-bypass).
        if ($user->hasRole('activity::admin')) {
            return true;
        }

        return null;
    }
}
