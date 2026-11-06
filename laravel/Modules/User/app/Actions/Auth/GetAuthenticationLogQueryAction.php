<?php

declare(strict_types=1);

namespace Modules\User\Actions\Auth;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\AuthenticationLog;
use Spatie\QueueableAction\QueueableAction;

/**
 * Restituisce la query builder per i log di autenticazione di un modello autenticabile.
 */
final class GetAuthenticationLogQueryAction
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
