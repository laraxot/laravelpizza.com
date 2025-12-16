<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Interfaccia che definisce i metodi per gestire i log di autenticazione associati a un utente.
 */
interface HasAuthentications
{
    /**
     * Ottiene tutti i log di autenticazione associati all'utente.
     */
    public function authentications(): MorphMany;
}
