<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Throwable;

/**
 * Crea sul database di test le tabelle che il modulo dichiara nelle proprie migration,
 * e solo quelle che mancano.
 *
 * ## Perche' esiste
 *
 * `XotBaseTestCase::refreshApplication()` punta ogni connessione su
 * il file sqlite condiviso in `database/`. Quel file non e' un database di test: e' uno scratch
 * condiviso, che contiene le tabelle lasciate li' dall'ultima suite che ha migrato per
 * conto suo. Alla misura del 2026-08-19 conteneva sette tabelle — `assets`, `collections`,
 * `components`, `migrations`, `sqlite_sequence`, `test_index_table`, `themes` — e nessuna
 * di `users`, `media`, `activity_log`. Di conseguenza centinaia di test morivano con
 * `no such table`, che non e' un difetto del codice ne' del test: e' assenza di schema.
 *
 * ## Cosa fa, e cosa deliberatamente non fa
 *
 * Esegue lo `up()` delle migration del modulo **solo per le tabelle che non esistono**.
 * Non cancella, non svuota, non riesegue: non e' `RefreshDatabase`, non e' `migrate:fresh`,
 * non e' `migrate --force`. E' additivo, quindi non puo' distruggere dati — il vincolo che
 * quelle tre forme violano e per cui l'architettura le vieta.
 *
 * Se una migration fallisce viene ignorata: una tabella in meno significa che i test che la
 * usano si salteranno per precondizione, che e' il comportamento voluto. Non deve mai essere
 * questa classe a far fallire una suite.
 *
 * ## Uso
 *
 * Nel `TestCase` del modulo, dopo il `parent::refreshApplication()` — cioe' quando le
 * connessioni sono gia' rimappate ma `DatabaseTransactions` non e' ancora partito, altrimenti
 * il `CREATE TABLE` verrebbe annullato dal rollback a fine test:
 *
 * ```php
 * protected function refreshApplication(): void
 * {
 *     parent::refreshApplication();
 *     XotModuleSchema::ensure('Media');
 * }
 * ```
 */
final class XotModuleSchema
{
    /**
     * Moduli gia' processati in questo processo: le migration si eseguono una volta sola
     * per run, non a ogni test.
     *
     * @var array<string, true>
     */
    private static array $done = [];

    /**
     * @param  string  $module  nome del modulo in PascalCase, come la directory sotto Modules/
     */
    public static function ensure(string $module): void
    {
        if (isset(self::$done[$module])) {
            return;
        }

        self::$done[$module] = true;

        foreach (self::migrationFiles($module) as $file) {
            self::runIfTableMissing($file);
        }
    }

    /**
     * Sposta ogni connessione su un file sqlite privato di **questo processo**.
     *
     * Senza isolamento tutte le suite — quelle degli altri moduli e quelle degli altri
     * agenti — scrivono sullo stesso il file sqlite condiviso in `database/`, e due conseguenze
     * arrivano insieme: `SQLSTATE[HY000]: General error: 5 database is locked` appena due
     * run si sovrappongono, e percentuali non riproducibili, perche' lo schema visto da una
     * suite dipende da quale altra suite ha migrato per ultima. Misurato: la suite di Pdnd
     * passa da 29 verdi a 5 rossi solo perche' in parallelo giravano altre 47 istanze di
     * Pest sullo stesso file.
     *
     * Il file vive sotto `build/`, che e' gia' ignorato da git, e porta il PID nel nome:
     * due processi non si incontrano mai, e il contenuto e' irrilevante fra una run e
     * l'altra perche' lo schema viene ricostruito da `ensure()`.
     *
     * Va chiamata **prima** di `ensure()` e prima che parta `DatabaseTransactions`.
     */
    public static function isolate(string $label): void
    {
        $dir = base_path('build/testing-sqlite');

        if (! is_dir($dir)) {
            \Safe\mkdir($dir, 0o775, true);
        }

        $file = $dir.'/'.$label.'-'.\Safe\getmypid().'.sqlite';

        if (! file_exists($file)) {
            \Safe\touch($file);
        }

        /** @var array<string, mixed> $connections */
        $connections = (array) config('database.connections', []);

        foreach (array_keys($connections) as $name) {
            config()->set('database.connections.'.$name.'.database', $file);
            DB::purge((string) $name);
        }

        // Lo schema del file privato e' vuoto: quello del file condiviso non vale piu'.
        self::$done = [];
    }

    /**
     * Le migration dell'applicazione, non di un modulo: `cache`, `jobs`, `sessions` e le
     * altre tabelle di framework che un modulo non dichiara ma che il runtime usa lo stesso.
     *
     * Serve perche' senza `cache` il flush della permission cache di Spatie fa fallire ogni
     * test che assegna un ruolo, con un errore che sembra di autorizzazione e invece e' di
     * schema.
     */
    public static function ensureApp(): void
    {
        if (isset(self::$done['@app'])) {
            return;
        }

        self::$done['@app'] = true;

        foreach (self::filesIn(base_path('database/migrations')) as $file) {
            self::runIfTableMissing($file);
        }
    }

    /**
     * Azzera la memoria dei moduli gia' processati. Serve solo ai test di questa classe.
     */
    public static function reset(): void
    {
        self::$done = [];
    }

    /**
     * File di migration del modulo, in ordine di nome — che per convenzione e' l'ordine
     * cronologico con cui vanno applicate.
     *
     * @return list<string>
     */
    private static function migrationFiles(string $module): array
    {
        return self::filesIn(base_path('Modules/'.$module.'/database/migrations'));
    }

    /**
     * @return list<string>
     */
    private static function filesIn(string $dir): array
    {
        if (! is_dir($dir)) {
            return [];
        }

        /** @var list<string> $files */
        $files = \Safe\glob($dir.'/*.php');

        sort($files);

        return $files;
    }

    private static function runIfTableMissing(string $file): void
    {
        try {
            $migration = require $file;

            if (! $migration instanceof Migration) {
                return;
            }

            $table = self::tableOf($migration);

            if ($table !== null && Schema::hasTable($table)) {
                return;
            }

            // `Migration` non dichiara `up()`: e' una convenzione, non un contratto, quindi
            // va invocato come callable dopo averne verificato l'esistenza.
            if (! is_callable([$migration, 'up'])) {
                return;
            }

            /** @var callable(): void $up */
            $up = [$migration, 'up'];
            $up();
        } catch (Throwable) {
            // Una migration che non gira lascia semplicemente la tabella assente: i test
            // che la richiedono si salteranno per precondizione. Vedi il docblock.
        }
    }

    /**
     * Nome della tabella dichiarato dalla migration, quando la migration lo espone.
     * `XotBaseMigration::getTable()` lo ricava dal model; le migration che non estendono
     * quella base non hanno il metodo, e in quel caso si tenta comunque lo `up()`.
     */
    private static function tableOf(Migration $migration): ?string
    {
        if (! $migration instanceof XotBaseMigration) {
            return null;
        }

        try {
            $table = $migration->getTable();

            return $table !== '' ? $table : null;
        } catch (Throwable) {
            return null;
        }
    }
}
