<?php

declare(strict_types=1);

namespace Modules\User\Actions\Auth;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Modules\User\Contracts\HasAuthentications;
use Modules\User\Contracts\UserContract;
use Modules\User\Models\AuthenticationLog;

/**
 * Persist an authentication_logs row on the User connection (`user` / fixcity_user).
 *
 * Skips safely when the table is missing so a misconfigured deploy cannot turn
 * a failed/successful login into a 500 (BMAD: audit must not break auth UX).
 *
 * Identity = {@see UserContract}; capability = {@see HasAuthentications}.
 * Never type-hint {@see \Modules\User\Models\BaseUser}: that is an internal
 * abstract implementation, not the consumer boundary.
 */
final class RecordAuthenticationLogAction
{
    /**
     * @param  array{ip_address: ?string, user_agent: ?string, login_at: mixed, login_successful: bool, location: array<string, mixed>}  $attributes
     */
    public function execute(UserContract&HasAuthentications $user, array $attributes): void
    {
        $log = new AuthenticationLog;
        $connection = $log->getConnectionName() ?? 'user';
        $table = $log->getTable();

        if (! Schema::connection($connection)->hasTable($table)) {
            Log::warning('authentication_logs missing on user connection; skip auth audit write', [
                'connection' => $connection,
                'database' => $log->getConnection()->getDatabaseName(),
                'table' => $table,
                'user_id' => $user->getAuthIdentifier(),
            ]);

            return;
        }

        $user->authentications()->create($attributes);
    }
}
