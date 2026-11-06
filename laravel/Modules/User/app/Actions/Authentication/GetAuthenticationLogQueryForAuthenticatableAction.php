<?php

declare(strict_types=1);

namespace Modules\User\Actions\Authentication;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\AuthenticationLog;
use Spatie\QueueableAction\QueueableAction;

final class GetAuthenticationLogQueryForAuthenticatableAction
{
    use QueueableAction;

    /**
     * @phpstan-return Builder<AuthenticationLog>
     */
    public function execute(Model $authenticatable): Builder
    {
        return AuthenticationLog::query()
            ->where('authenticatable_type', $authenticatable->getMorphClass())
            ->where('authenticatable_id', $authenticatable->getKey());
    }
}
