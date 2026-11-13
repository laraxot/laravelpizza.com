<?php

declare(strict_types=1);

namespace Modules\User\Actions\Login\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Modules\User\Models\AuthenticationLog;

use function Safe\preg_match;

/**
 * Risolve la sorgente dei log di autenticazione condivisa tra le action
 * di statistics e di history: modello configurabile, colonna timestamp
 * e timezone applicativa.
 */
trait ResolvesLoginLogQuery
{
    /**
     * @return Builder<Model>
     */
    private function authenticationLogQuery(): Builder
    {
        $modelClass = config(
            'user.login-monitoring.model',
            AuthenticationLog::class,
        );

        if (! is_string($modelClass)
            || ! is_subclass_of($modelClass, Model::class)) {
            throw new InvalidArgumentException(
                'Invalid login monitoring model.'
            );
        }

        $column = $this->loginLogColumn();

        $model = new $modelClass;

        return $model->newQuery()
            ->whereNotNull($column);
    }

    private function loginLogColumn(): string
    {
        $column = config(
            'user.login-monitoring.column',
            'login_at',
        );

        if (! is_string($column)
            || ! preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $column)) {
            throw new InvalidArgumentException(
                'Invalid login monitoring column.'
            );
        }

        return $column;
    }

    private function loginMonitoringTimezone(): string
    {
        $timezone = config(
            'user.login-monitoring.timezone',
            'UTC',
        );

        return is_string($timezone) && $timezone !== '' ? $timezone : 'UTC';
    }
}
