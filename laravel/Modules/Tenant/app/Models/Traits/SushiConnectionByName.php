<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;
use Webmozart\Assert\Assert;

/**
 * Trait SushiConnectionByName.
 *
 * Sushi chiama la connessione come la classe del modello (`getConnectionName()`), ma la registra
 * solo nella config come SQLite `:memory:`. Le query del modello usano l'istanza viva
 * (`resolveConnection()`); chi invece risolve la connessione per nome (regole di validazione
 * `unique`/`exists`, anche quelle di Filament, oppure `DB::connection()`) fa costruire a
 * `DatabaseManager` un `:memory:` nuovo e vuoto: "no such table".
 * Qui il nome viene legato all'istanza viva, così tutti vedono lo stesso database.
 *
 * @see https://github.com/calebporzio/sushi
 */
trait SushiConnectionByName
{
    /**
     * Il resolver è pigro: l'istanza Sushi esiste solo dopo il boot del modello, e viene letta
     * al momento della richiesta, non della registrazione.
     */
    protected static function bootSushiConnectionByName(): void
    {
        DB::extend(static::class, static function (): Connection {
            $connection = static::resolveConnection();
            Assert::isInstanceOf($connection, Connection::class);

            return $connection;
        });
    }
}
