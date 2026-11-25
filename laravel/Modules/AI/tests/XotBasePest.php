<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Assert;

/**
 * Helper di test condivisi da tutti i moduli.
 *
 * Raggiungibile per **autoload PSR-4** (`Modules\Xot\Tests\` => `Modules/Xot/tests`):
 * un modulo che ne ha bisogno importa la classe, non include un file.
 *
 *     use Modules\Xot\Tests\XotBasePest;
 *
 *     XotBasePest::assertThrows(fn () => $action->execute(), InvalidArgumentException::class);
 *
 * Perché una classe di metodi statici e non funzioni globali in un bootstrap:
 *
 * - niente `require_once` con path relativo che risale due livelli di filesystem e si rompe
 *   se un modulo cambia posto;
 * - niente guardie `function_exists()`: nella run full-suite Pest carica il `Pest.php` di
 *   ogni modulo nello stesso processo, e due dichiarazioni della stessa funzione globale
 *   sarebbero un fatal `cannot redeclare`. Una classe non ha quel problema;
 * - niente voci in `composer.json` → `autoload.files`: quel contratto resta chiuso, dopo che
 *   una voce rimasta a puntare a un file cancellato ha ucciso il boot dell'intero progetto.
 *
 * Il binding del TestCase: preferire `pest()->extend(TestCase::class)->in('.')` in `Pest.php`
 * del modulo **dopo gate PHPStan verde** (ADR-017; richiede pest-plugin-phpstan v5 + neon pulito).
 * Fallback LOCKED: `uses(\Modules\<Mod>\Tests\TestCase::class);` nuda in ogni file test.
 * **Vietato** `uses()->in()` e bind su `XotBaseTestCase` abstract.
 *
 * I test girano su MySQL (repliche `*_test`), mai su SQLite: stesso dialetto del runtime,
 * nessuna sorpresa fra ambiente di test e produzione.
 */
final class XotBasePest
{
    /**
     * Riga presente sulla connessione indicata.
     *
     * @param  array<string, mixed>  $where
     */
    public static function assertTableHas(string $connection, string $table, array $where): void
    {
        Assert::assertTrue(self::tableQueryExists($connection, $table, $where));
    }

    /**
     * Riga assente sulla connessione indicata.
     *
     * @param  array<string, mixed>  $where
     */
    public static function assertTableMissing(string $connection, string $table, array $where): void
    {
        Assert::assertFalse(self::tableQueryExists($connection, $table, $where));
    }

    /**
     * @param  array<string, mixed>  $where
     */
    public static function tableQueryExists(string $connection, string $table, array $where): bool
    {
        $query = DB::connection($connection)->table($table);

        foreach ($where as $column => $value) {
            $query->where($column, $value);
        }

        return $query->exists();
    }

    /**
     * Rilegge il model dal database e ne garantisce il tipo.
     *
     * @template T of Model
     *
     * @param  T  $model
     * @param  class-string<T>  $class
     * @return T
     */
    public static function assertFreshModel(Model $model, string $class)
    {
        $fresh = $model->fresh();
        Assert::assertInstanceOf($class, $fresh);

        return $fresh;
    }

    /**
     * @template T of Model
     *
     * @param  EloquentCollection<int, T>|Collection<int, T>  $collection
     * @param  class-string<T>  $class
     * @return T
     */
    public static function assertFirstModel(EloquentCollection|Collection $collection, string $class)
    {
        Assert::assertNotEmpty($collection);
        $first = $collection->first();
        Assert::assertInstanceOf($class, $first);

        return $first;
    }

    /**
     * Narrowing di un `mixed` ad array tipizzato, senza cast ciechi.

     *
     * Stesso schema di `assertString()`: `Assert::fail()` è dichiarato `never`, quindi
     * PHPStan restringe davvero il tipo. `assertNotEmpty()` non restringe niente e in
     * più **rifiuta un array vuoto legittimo**: un `flattenArray([])` che torna `[]` è
     * il risultato giusto, non un fallimento.
     *
     * @return array<string, mixed>
     */
    public static function assertArray(mixed $value, string $message = ''): array
    {
        if (! \is_array($value)) {
            Assert::fail($message !== '' ? $message : 'Expected array, got '.get_debug_type($value).'.');
        }

        // Le chiavi intere diventano stringhe: il tipo di ritorno e' array<string, mixed>.
        $normalized = [];
        foreach ($value as $key => $item) {
            $normalized[(string) $key] = $item;
        }

        return $normalized;
    }

    /**
     * Narrowing di un `mixed` a stringa, senza cast ciechi.
     *
     * Serve dove il framework restituisce `mixed` per contratto — `Model::getKey()`,
     * `ReflectionProperty::getValue()`, le colonne di una riga `stdClass` del query
     * builder — e un `(string) $valore` sposterebbe il problema a runtime invece di
     * risolverlo. `Assert::fail()` è dichiarato `never`, quindi PHPStan restringe
     * davvero il tipo: nessun `@var` che scavalchi l'inferenza.
     */
    public static function assertString(mixed $value, string $message = ''): string
    {
        if (! \is_string($value)) {
            Assert::fail($message !== '' ? $message : 'Expected string, got '.get_debug_type($value).'.');
        }

        return $value;
    }

    /**
     * Narrowing di un `mixed` a chiave di modello (int o string).
     *
     * `Model::getKey()` è tipizzato `mixed` in Eloquent: questo è il punto unico dove
     * la chiave torna utilizzabile senza cast.
     */
    public static function assertModelKey(mixed $value, string $message = ''): int|string
    {
        if (! \is_int($value) && ! \is_string($value)) {
            Assert::fail($message !== '' ? $message : 'Expected model key (int|string), got '.get_debug_type($value).'.');
        }

        return $value;
    }

    /**
     * @param  class-string<\Throwable>  $exceptionClass
     */
    public static function assertThrows(callable $callback, string $exceptionClass): void
    {
        try {
            $callback();
        } catch (\Throwable $exception) {
            Assert::assertInstanceOf($exceptionClass, $exception);

            return;
        }

        Assert::fail(\sprintf('Expected exception %s was not thrown.', $exceptionClass));
    }

    /**
     * @param  list<string>|array<int, string>  $haystack
     */
    public static function assertListContains(string $needle, array $haystack): void
    {
        Assert::assertTrue(\in_array($needle, $haystack, true));
    }

    public static function assertReflectionNamedType(?\ReflectionType $type): \ReflectionNamedType
    {
        Assert::assertNotNull($type);
        Assert::assertInstanceOf(\ReflectionNamedType::class, $type);

        return $type;
    }

    public static function assertReflectionTypeName(?\ReflectionType $type, string $expected): void
    {
        Assert::assertSame($expected, self::assertReflectionNamedType($type)->getName());
    }

    /**
     * Path del file che dichiara la classe: `getFileName()` può tornare `false`
     * per le classi interne, quindi l'assert è parte del contratto.
     *
     * @param  class-string  $class
     */
    public static function reflectionFilename(string $class): string
    {
        $filename = (new \ReflectionClass($class))->getFileName();
        Assert::assertIsString($filename);
        Assert::assertNotSame('', $filename);

        return $filename;
    }

    /**
     * Sorgente della classe, per gli assert "il codice non contiene X".
     *
     * @param  class-string  $class
     */
    public static function reflectionSource(string $class): string
    {
        return \Safe\file_get_contents(self::reflectionFilename($class));
    }
}
