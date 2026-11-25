<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Traits;

use Filament\Facades\Filament;
use Modules\Xot\Contracts\UserContract;

/**
 * Pagine operative (Artisan, .env, health, invio di prova) riservate al super-admin.
 *
 * Filament consente l'accesso alla pagina se `canAccess()` non è ridefinito: senza questo
 * trait basta entrare nel pannello per aprirla.
 */
trait SuperAdminOnlyTrait
{
    public static function canAccess(): bool
    {
        $user = Filament::auth()->user();

        return $user instanceof UserContract && $user->hasRole('super-admin');
    }
}
