<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Schema;

use Illuminate\Support\Facades\Schema;
use Spatie\QueueableAction\QueueableAction;

final class CheckActivityLogWritableAction
{
    use QueueableAction;

    public function execute(): bool
    {
        if (! config('activitylog.enabled', true)) {
            return false;
        }

        $connection = $this->resolveConnection();
        $table = $this->resolveTable();
        $schema = Schema::connection($connection);

        return $schema->hasTable($table)
            && $schema->hasColumn($table, 'attribute_changes');
    }

    private function resolveConnection(): string
    {
        $connection = config('activitylog.database_connection');
        if (is_string($connection) && $connection !== '') {
            return $connection;
        }

        $default = config('database.default');

        return is_string($default) && $default !== '' ? $default : 'mysql';
    }

    private function resolveTable(): string
    {
        $table = config('activitylog.table_name', 'activity_log');

        return is_string($table) && $table !== '' ? $table : 'activity_log';
    }
}
