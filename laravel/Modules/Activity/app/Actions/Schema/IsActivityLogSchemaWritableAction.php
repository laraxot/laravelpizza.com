<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Schema;

use Illuminate\Support\Facades\Schema;
use Spatie\QueueableAction\QueueableAction;

/**
 * Verifica che activity_log sia scrivibile (Spatie v4+ richiede attribute_changes).
 */
final class IsActivityLogSchemaWritableAction
{
    use QueueableAction;

    public function execute(): bool
    {
        if (! config('activitylog.enabled', true)) {
            return false;
        }

        $connection = config('activitylog.database_connection');
        if (! is_string($connection) || $connection === '') {
            $default = config('database.default');
            $connection = is_string($default) ? $default : 'mysql';
        }

        $table = config('activitylog.table_name', 'activity_log');
        if (! is_string($table) || $table === '') {
            $table = 'activity_log';
        }

        $schema = Schema::connection($connection);

        return $schema->hasTable($table)
            && $schema->hasColumn($table, 'attribute_changes');
    }
}
