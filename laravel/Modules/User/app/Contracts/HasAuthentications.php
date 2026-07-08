<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\User\Models\AuthenticationLog;
use Modules\User\Models\BaseUser;

/**
 * Marker: il modello usa {@see \Modules\User\Models\Traits\HasAuthenticationLogTrait}.
 *
 * @phpstan-require-extends BaseUser
 */
interface HasAuthentications extends Authenticatable
{
    /**
     * Ottiene tutti i log di autenticazione associati all'utente.
     */
    /** @return MorphMany<AuthenticationLog, BaseUser&$this> */
    public function authentications(): MorphMany;
}
