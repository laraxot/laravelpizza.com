<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Modules\Xot\Contracts\UserContract;

/**
 * Policy della classe utente (e delle sue sottoclassi, registrata in `UserServiceProvider::registerPolicies()`).
 * Le regole stanno in {@see BaseUserPolicy}: qui resta solo l'abilita' `superadmin`.
 */
class UserPolicy extends BaseUserPolicy
{
    /**
     * Nessuno e' super-admin per policy: lo e' per ruolo, e `before()` lo concede prima di arrivare qui.
     */
    public function superadmin(UserContract $_user, UserContract $_post): bool
    {
        return false;
    }
}
