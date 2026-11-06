<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Mockery\Expectation;
use Mockery\ExpectationDirector;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use Modules\User\Database\Factories\TenantFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Tenant;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Database\Factories\ModuleFactory;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Models\Module;
use Modules\Xot\Providers\XotServiceProvider;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class XotBaseTestCase.
 *
 * Shared bootstrap base test case for module tests.
 * DatabaseTransactions belongs in each module TestCase when that module needs transactional isolation.
 *
 * @property object|null $action
 * @property Model|null $model
 * @property object|null $service
 * @property object|null $widget
 * @property string|null $tempDir
 * @property object|null $record
 * @property object|null $transition
 * @property object|null $resource
 * @property Model|null $testModel
 * @property object|null $extraClass
 * @property Model|null $baseModel
 * @property string|null $testDir
 * @property string|null $workDir
 * @property mixed $saved
 * @property mixed $extra_attributes
 */
abstract class XotBaseTestCase extends BaseTestCase
{
    use CreatesApplication;

    public mixed $action = null;

    public mixed $model = null;

    public mixed $service = null;

    public mixed $widget = null;

    public mixed $tempDir = null;

    public mixed $record = null;

    public mixed $transition = null;

    public mixed $resource = null;

    public mixed $testModel = null;

    public mixed $extraClass = null;

    public mixed $baseModel = null;

    public ?string $testDir = null;

    public ?string $workDir = null;

    public mixed $saved = null;

    public mixed $extra_attributes = null;

    /**
     * @param  array<string, mixed>  $data
     */
    public function assertDatabaseHasRow(string $table, array $data, ?string $connection = null): void
    {
        $this->assertDatabaseHas($table, $data, $connection);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function assertDatabaseMissingRow(string $table, array $data, ?string $connection = null): void
    {
        $this->assertDatabaseMissing($table, $data, $connection);
    }

    public function assertDatabaseCountRow(string $table, int $count, ?string $connection = null): void
    {
        $this->assertDatabaseCount($table, $count, $connection);
    }

    /**
     * @template T of object
     *
     * @param  class-string<T>  $class
     * @return MockObject&T
     */
    public function createUnitMock(string $class): MockObject
    {
        return $this->createMock($class);
    }

    /**
     * @template T of object
     *
     * @param  class-string<T>  $abstract
     * @param  (\Closure(MockInterface&T): void)|null  $callback
     * @return MockInterface&T
     */
    public function mockService(string $abstract, ?\Closure $callback = null): MockInterface
    {
        /** @var MockInterface&T $mock */
        $mock = $this->mock($abstract, $callback);

        return $mock;
    }

    /**
     * Mockery 1.6 shouldReceive() always returns a CompositeExpectation, whatever its docblock says, so a
     * wrapper with a native `Expectation` return type throws TypeError at runtime. The director holds the real
     * Expectation that shouldReceive() just registered, which keeps chained with()/once()/andReturn() typed.
     */
    public static function singleExpectation(LegacyMockInterface $mock, string $method): Expectation
    {
        $mock->shouldReceive($method);
        $director = $mock->mockery_getExpectationsFor($method);
        self::assertInstanceOf(ExpectationDirector::class, $director);
        $expectations = $director->getExpectations();
        $expectation = end($expectations);
        self::assertInstanceOf(Expectation::class, $expectation);

        return $expectation;
    }

    public function skipTest(string $message = ''): never
    {
        $this->markTestSkipped($message);
    }

    /**
     * @param  class-string<\Throwable>  $exceptionClass
     */
    public function expectApplicationException(string $exceptionClass, ?string $message = null): void
    {
        $this->expectException($exceptionClass);
        if ($message !== null) {
            $this->expectExceptionMessageIsOrContains($message);
        }
    }

    /**
     * @return array<int, class-string<ServiceProvider>>
     */
    protected function getPackageProviders(Application $app): array
    {
        return [
            XotServiceProvider::class,
        ];
    }

    /**
     * Dati sacri: nessun TestCase modulo puo' lanciare migrate:fresh.
     * I figli che `use RefreshDatabase` lo riattivano — quel trait e' vietato
     * (vedi Fixcity REGOLA_DATI_SACRI / TestDatabaseGuard).
     */
    protected function refreshDatabase(): void
    {
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Nei test non esiste una build Vite (public_html/build/manifest.json):
        // i blade con @vite renderizzano senza asset invece di lanciare ViewException.
        $this->withoutVite();

        if (! $this->app->bound('translator')) {
            $this->app->singleton('translator', function (Application $app) {
                return new Translator(
                    new ArrayLoader,
                    'en'
                );
            });
        }
    }

    protected function tearDown(): void
    {
        try {
            if ($this->app instanceof Application) {
                /** @var DatabaseManager $db */
                $db = $this->app->make('db');

                /** @var array<string, mixed> $connections */
                $connections = (array) config('database.connections', []);
                foreach (array_keys($connections) as $name) {
                    $db->disconnect((string) $name);
                }

                $db->disconnect();
                $db->purge();
            }
        } catch (\Throwable) {
            // Ignore teardown disconnection issues to avoid masking test failures.
        }

        parent::tearDown();
    }

    protected static function generateUniqueEmail(): string
    {
        return 'test-'.uniqid((string) mt_rand(), true).'@example.com';
    }

    /**
     * @return class-string<Model&UserContract>
     */
    protected static function getUserClass(): string
    {
        return XotData::make()->getUserClass();
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    protected static function createTestUser(array $attributes = []): UserContract
    {
        /** @var Factory<Model&UserContract> $factory */
        $factory = UserFactory::new();
        /** @var UserContract $user */
        $user = $factory->create($attributes);

        return $user;
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    protected static function createTestTenant(array $attributes = []): Tenant
    {
        /** @var Tenant $tenant */
        $tenant = TenantFactory::new()->createOne($attributes);

        return $tenant;
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    protected static function createTestModule(array $attributes = []): Module
    {
        return ModuleFactory::new()->createOne($attributes);
    }

    /**
     * Path of the shared SQLite database used by module tests.
     *
     * I moduli sono condivisi fra piu' progetti: il nome del file non puo' essere
     * cablato qui, altrimenti il framework porta con se' il nome del progetto in cui e'
     * nato. Si risolve in tre passi, dal piu' esplicito al piu' neutro:
     *
     * 1. `config('xot.testing.sqlite_file')` — il progetto dichiara il proprio file;
     * 2. l'unico `*.sqlite` presente in `database/` — il caso normale, funziona senza
     *    configurare niente e qualunque sia il nome scelto dal progetto;
     * 3. `test_data.sqlite` — default neutro quando la cartella e' vuota o ambigua.
     *
     * Single source of truth per `prepareSharedSqliteForTesting()` e per
     * `xot:build-test-sqlite`, che ha bisogno dello stesso path per costruire il file.
     */
    public static function sharedSqlitePath(): string
    {
        return app(\Modules\Xot\Actions\Testing\ResolveSharedSqlitePathAction::class)->execute();
    }

    /**
     * Punta ogni connessione sqlite al file condiviso e condivide un solo PDO.
     *
     * Multiple named connections (activity, user, gdpr, …) on the same SQLite file
     * each opening their own transaction causes "database is locked". Sharing the
     * primary PDO lets DatabaseTransactions roll back all module writes together.
     *
     * Call before parent::setUp() when the test case uses DatabaseTransactions.
     */
    protected function prepareSharedSqliteForTesting(): void
    {
        if ($this->app === null) {
            $this->refreshApplication();
        }

        $database = self::sharedSqlitePath();

        // La connessione opzionale 'user' (driver mysql) senza database configurato
        // (DB_DATABASE_USER vuoto) ripiega su sqlite condiviso: stesso fallback di
        // XotBaseMigration::resolveConnectionName(), altrimenti ogni insert su users
        // fallisce con "No database selected" sulle macchine senza il DB dedicato.
        $userDatabase = config('database.connections.user.database');
        if (! is_string($userDatabase) || $userDatabase === '') {
            $this->app['config']->set('database.connections.user', [
                'driver' => 'sqlite',
                'database' => $database,
                'prefix' => '',
                'foreign_key_constraints' => true,
            ]);
        }

        /** @var array<string, array<string, mixed>> $connections */
        $connections = config('database.connections', []);

        /** @var list<string> $sqliteConnections */
        $sqliteConnections = [];

        foreach (array_keys($connections) as $connection) {
            if (config("database.connections.{$connection}.driver") !== 'sqlite') {
                continue;
            }

            $sqliteConnections[] = $connection;
            $this->app['config']->set("database.connections.{$connection}.database", $database);
            $this->app['config']->set("database.connections.{$connection}.busy_timeout", 10000);
        }

        foreach ($sqliteConnections as $connection) {
            DB::purge($connection);
        }

        if ($sqliteConnections === []) {
            return;
        }

        $primaryName = in_array('sqlite', $sqliteConnections, true)
            ? 'sqlite'
            : $sqliteConnections[0];

        /** @var DatabaseManager $database */
        $database = $this->app->make('db');
        $primaryConnection = $database->connection($primaryName);

        $managerReflection = new \ReflectionClass($database);
        $connectionsProperty = $managerReflection->getProperty('connections');
        $connectionsProperty->setAccessible(true);

        /** @var array<string, mixed> $resolved */
        $resolved = $connectionsProperty->getValue($database);

        foreach ($sqliteConnections as $connection) {
            $resolved[$connection] = $primaryConnection;
        }

        $connectionsProperty->setValue($database, $resolved);
    }

    public function bindInstance(string $abstract, object $instance): void
    {
        $this->instance($abstract, $instance);
    }

    public function disableExceptionHandling(): void
    {
        $this->withoutExceptionHandling();
    }

    public function enableExceptionHandling(): void
    {
        $this->withExceptionHandling();
    }

    /**
     * @param  class-string<\Throwable>  $exception
     */
    public function expectThrowable(string $exception): void
    {
        $this->expectException($exception);
    }

    public function expectThrowableMessage(string $message): void
    {
        $this->expectExceptionMessageIsOrContains($message);
    }

    public function expectThrowableMessageMatches(string $pattern): void
    {
        $this->expectExceptionMessageMatches($pattern);
    }
}
