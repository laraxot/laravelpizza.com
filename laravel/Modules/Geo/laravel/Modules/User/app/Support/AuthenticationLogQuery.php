<?php

declare(strict_types=1);

namespace Modules\User\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\AuthenticationLog;

final class AuthenticationLogQuery
{
    /**
     * @phpstan-return Builder<AuthenticationLog>
     */
    public static function forAuthenticatable(Model $authenticatable): Builder
    {
        return AuthenticationLog::query()
            ->where('authenticatable_type', $authenticatable->getMorphClass())
            ->where('authenticatable_id', $authenticatable->getKey());
    }
}
