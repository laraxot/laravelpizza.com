<?php

declare(strict_types=1);

namespace Modules\User\Actions\Database;

use Illuminate\Support\Facades\Config;
use Modules\User\Actions\Auth\RecordAuthenticationLogAction;
use Modules\User\Listeners\LoginListener;
use Spatie\QueueableAction\QueueableAction;

/**
 * Vero se la connessione `user` ha un database configurato.
 *
 * La connessione è opzionale: senza `DB_DATABASE_USER` il nome del database è vuoto e ogni
 * `Schema::connection('user')->hasTable()` interroga information_schema senza database
 * (MySQL: "Access denied for user ''@'localhost'"). I chiamanti ({@see LoginListener},
 * {@see RecordAuthenticationLogAction}) saltano allora le scritture
 * di audit invece di far fallire il login.
 *
 * Legge solo la configurazione: non apre la connessione.
 */
final class IsUserDatabaseConfiguredAction
{
    use QueueableAction;

    public function execute(): bool
    {
        $database = Config::get('database.connections.user.database');

        return is_string($database) && trim($database) !== '';
    }
}
