<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\User\Models\AuthenticationLog;
use Modules\User\Models\Traits\HasAuthenticationLogTrait;

/**
 * Marker: il modello usa {@see HasAuthenticationLogTrait}.
 *
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
interface HasAuthentications extends Authenticatable
{
    /**
     * @return MorphMany<AuthenticationLog, covariant Model>
     */
    public function authentications(): MorphMany;
}
