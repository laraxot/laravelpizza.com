<?php

declare(strict_types=1);

namespace Modules\User\Support;

use Illuminate\Support\Facades\Schema;
use Modules\User\Models\Notification;

/**
 * Verifica che la tabella `notifications` esista sulla connection User prima di query FO.
 */
final class NotificationSchema
{
    public static function isReadable(): bool
    {
        $model = new Notification();

        $connection = $model->getConnectionName();
        if (! is_string($connection) || '' === $connection) {
            $default = config('database.default');
            $connection = is_string($default) ? $default : 'mysql';
        }

        return Schema::connection($connection)->hasTable($model->getTable());
    }
}
