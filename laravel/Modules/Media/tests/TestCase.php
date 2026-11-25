<?php

declare(strict_types=1);

namespace Modules\Media\Tests;

use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Mockery\Expectation;
use Mockery\MockInterface;
use Modules\Media\Providers\MediaServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBasePest;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;
use Spatie\QueueableAction\QueueableAction;

/**
 * Base test case for Media module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 * Migrations must be run ONCE externally: php artisan migrate --env=testing
 * DatabaseTransactions handles rollback between tests.
 */
abstract class TestCase extends XotBaseTestCase
{
    protected function setUp(): void
    {
        // Prima di parent::setUp(): DatabaseTransactions apre le transazioni subito; senza questo la
        // connessione `user` (mysql) va in "Connection refused" dove non c'e' MariaDB (vedi XotBaseTestCase).
        $this->prepareSharedSqliteForTesting();

        parent::setUp();
    }

    use DatabaseTransactions;

    /**
     * Le connessioni che la transazione di test deve coprire.
     *
     * `DatabaseTransactions` da solo avvolge **soltanto la connessione
     * predefinita**: tutto cio' che un test scrive sulle altre viene
     * **committato** e resta per la corsa successiva. Il sintomo e'
     * `UniqueConstraintViolationException` su un test che il giorno prima
     * passava — il modo peggiore di fallire, perche' sembra una regressione del
     * codice e invece e' sporcizia della corsa precedente. Nel modulo Tenant
     * erano 20 fallimenti su 62 (base_quaeris_fila5#228).
     *
     * Solo le connessioni su cui il modulo scrive, non tutte le 27 configurate:
     * avvolgerle tutte vorrebbe dire transazioni parallele sulle stesse righe,
     * cioe' attese di lock fra connessioni dello stesso test.
     *
     * Se un test nuovo scrive su un'altra connessione e lascia righe dietro, va
     * aggiunta qui.
     *
     * @var list<string>
     */
    protected $connectionsToTransact = [
        'mysql',
        'media',
        'user',
        'quaeris_data',
    ];

    /**
     * Le connessioni dell'elenco che questo progetto configura davvero, una sola volta per istanza.
     *
     * L'elenco e' condiviso fra i progetti: `quaeris_data` esiste solo in base_quaeris_fila5. Altrove
     * `DatabaseManager::connection()` lanciava «not configured» dentro `setUp()` e ogni test del modulo
     * moriva prima della prima asserzione. Le connessioni di modulo senza database proprio (`media`)
     * sono alias della default (`TenantServiceProvider::aliasModuleConnectionsToDefault()`): una sola
     * transazione per istanza, come nel TestCase del modulo User.
     *
     * @see Modules/Media/docs/stories/0009-media-sync-marker-repair.story.md
     *
     * @return list<string>
     */
    protected function connectionsToTransact()
    {
        $database = $this->app?->make('db');
        if (! $database instanceof DatabaseManager) {
            return $this->connectionsToTransact;
        }

        /** @var array<string, mixed> $configured */
        $configured = config('database.connections', []);

        $names = [];
        $seen = [];
        foreach ($this->connectionsToTransact as $name) {
            if (! \array_key_exists($name, $configured)) {
                continue;
            }

            $id = spl_object_id($database->connection($name));
            if (isset($seen[$id])) {
                continue;
            }
            $seen[$id] = true;
            $names[] = $name;
        }

        return $names;
    }

    public static function mockExpectation(MockInterface $mock, string $method): Expectation
    {
        return self::singleExpectation($mock, $method);
    }

    /**
     * @param  array<string, mixed>  $where
     */
    public function assertMediaTableHas(string $table, array $where, string $connection = 'media'): void
    {
        $this->assertDatabaseHas($table, $where, $connection);
    }

    /**
     * Controparte di {@see self::assertMediaTableHas()}: la riga non deve esistere.
     *
     * @param  array<string, mixed>  $where
     */
    public function assertMediaTableMissing(string $table, array $where, string $connection = 'media'): void
    {
        $this->assertDatabaseMissing($table, $where, $connection);
    }

    /**
     * Colonne della tabella `media`, filtrate e riindicizzate per l'inferenza PHPStan.
     *
     * @return array<int, string>
     */
    public static function mediaTableColumns(): array
    {
        $columns = Schema::getColumnListing('media');

        return array_values(array_filter(
            $columns,
            static fn (mixed $column): bool => is_string($column) && $column !== '', // mixed: getColumnListing() non dichiara value type
        ));
    }

    /**
     * Aggiunge `$column` al payload solo se la tabella `media` ha davvero quella colonna:
     * lo schema varia fra installazioni e un insert cieco fallirebbe.
     *
     * @param  array<string, mixed>  $payload
     * @param  array<int, string>  $columns
     * @param  mixed  $value  Valore di colonna eterogeneo (string, int, Carbon, null)
     * @return array<string, mixed>
     */
    public static function mediaPayloadSet(array $payload, array $columns, string $column, mixed $value): array
    {
        if (in_array($column, $columns, true)) {
            $payload[$column] = $value;
        }

        return $payload;
    }

    /**
     * @param  class-string  $class
     */
    public static function assertMediaUsesQueueableAction(string $class): void
    {
        XotBasePest::assertListContains(
            QueueableAction::class,
            (new ReflectionClass($class))->getTraitNames(),
        );
    }

    /**
     * @param  class-string  $class
     */
    public static function assertMediaDeclaresStrictTypes(string $class): void
    {
        Assert::assertStringContainsString(
            'declare(strict_types=1);',
            XotBasePest::reflectionSource($class),
        );
    }

    /**
     * @template T of object
     *
     * @param  class-string<T>  $class
     * @return T&MockObject
     */
    public function makeTestMock(string $class): object
    {
        return $this->createMock($class);
    }

    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders(Application $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            MediaServiceProvider::class,
        ];
    }
}
