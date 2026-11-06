<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Log;

use Illuminate\Contracts\Auth\Authenticatable;
use Modules\Xot\Contracts\UserContract;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\QueueableAction\QueueableAction;

/**
 * Chi puo' consultare i file di log: i super-admin e chi ha il permesso `log.viewAny`.
 *
 * Se il permesso non esiste ancora nel database, l'accesso e' negato senza errore.
 * La usano sia la pagina Log sia il download, cosi' la regola e' una sola.
 */
class AuthorizeLogAccessAction
{
    use QueueableAction;

    public function execute(?Authenticatable $user): bool
    {
        if (! $user instanceof UserContract) {
            return false;
        }

        try {
            return $user->hasRole('super-admin') || $user->hasPermissionTo('log.viewAny');
        } catch (PermissionDoesNotExist) {
            return false;
        }
    }
}
