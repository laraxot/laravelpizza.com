<?php

declare(strict_types=1);

namespace Modules\Lang\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Xot\Contracts\UserContract;

abstract class LangBasePolicy
{
    use HandlesAuthorization;

    public function before(UserContract $user, string $ability): ?bool
    {
        unset($ability);
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Il ruolo che apre il pannello del modulo gestisce tutto il modulo (ADR Xot module-admin-role-policy-bypass).
        if ($user->hasRole('lang::admin')) {
            return true;
        }

        return null;
    }
}
