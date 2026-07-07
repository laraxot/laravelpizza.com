<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\MorphMany;
=======
use Illuminate\Contracts\Auth\Authenticatable;
>>>>>>> 6d3760fe (.)

/**
 * Marker: il modello usa {@see \Modules\User\Models\Traits\HasAuthenticationLogTrait}.
 */
interface HasAuthentications extends Authenticatable
{
<<<<<<< HEAD
    /**
     * Ottiene tutti i log di autenticazione associati all'utente.
     */
    public function authentications(): MorphMany;
=======
>>>>>>> 6d3760fe (.)
}
