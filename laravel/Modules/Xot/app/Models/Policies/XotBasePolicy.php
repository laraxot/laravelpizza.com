<?php

declare(strict_types=1);
/**
 * ----------------------------------------------------------------.
 */

namespace Modules\Xot\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\Concerns\DeniesUndeclaredFilamentAbilities;

// use Modules\Xot\Datas\XotData;

abstract class XotBasePolicy
{
    use DeniesUndeclaredFilamentAbilities;
    use HandlesAuthorization;

    public function before(UserContract $user, string $_ability): ?bool
    {
        return once(function () use ($user) {
            if ($user->hasRole('super-admin')) {
                return true;
            }

            // Chi ha il ruolo `{modulo}::admin` (lo stesso che apre il pannello del modulo)
            // gestisce tutto il modulo. Senza questa regola le policy con `hasPermissionTo`
            // lanciavano PermissionDoesNotExist (pannelli cms/media/lang in 500) e quelle
            // con ruoli di altri progetti (Rating: hr-manager, evaluator) nascondevano tutto.
            // ADR: Modules/Xot/docs/wiki/decisions/module-admin-role-policy-bypass.md
            $moduleAdminRole = static::moduleAdminRole();
            if ($moduleAdminRole !== null && $user->hasRole($moduleAdminRole)) {
                return true;
            }

            return null;
        });
    }

    /**
     * Ruolo `{modulo}::admin` ricavato dal namespace della policy (`Modules\{Modulo}\...`).
     */
    protected static function moduleAdminRole(): ?string
    {
        $parts = explode('\\', static::class);
        if (\count($parts) < 3 || $parts[0] !== 'Modules') {
            return null;
        }

        return strtolower($parts[1]).'::admin';
    }

    public function viewAny(UserContract $user): Response|bool
    {
        return false;
    }
}
