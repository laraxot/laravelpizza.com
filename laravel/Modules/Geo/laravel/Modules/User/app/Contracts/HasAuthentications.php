<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Marker: il modello usa {@see \Modules\User\Models\Traits\HasAuthenticationLogTrait}.
 */
interface HasAuthentications extends Authenticatable
{
}
