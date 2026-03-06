<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

<<<<<<< HEAD
=======
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
>>>>>>> 998c8857 (Remove deprecated files and update project structure, including the deletion of workspace configuration, documentation files, and changelogs. Update composer.json for module name and dependencies.)
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Providers\XotServiceProvider;

/**
 * Class XotBaseTestCase.
 *
 * Base test case for all Laraxot modules.
 * Centralizes application bootstrapping, common bindings, and test helpers.
 * DRY + KISS + Laraxot: un solo posto per setup, mai estendere Illuminate\Foundation\Testing\TestCase.
 */
abstract class XotBaseTestCase extends BaseTestCase
{
<<<<<<< HEAD
    use CreatesApplication;
=======
    use CreatesApplication {
        createApplication as protected createBaseApplication;
    }
    use DatabaseTransactions;

    /**
     * Shared transactional connections for module tests.
     *
     * @var array<int, string>
     */
    protected $connectionsToTransact = ['mysql', 'activity', 'user'];

    /**
     * Flag to ensure migrations run only once per test process.
     */
    protected static bool $migrated = false;
>>>>>>> 998c8857 (Remove deprecated files and update project structure, including the deletion of workspace configuration, documentation files, and changelogs. Update composer.json for module name and dependencies.)

    /**
     * Package providers for module tests (Orchestra Testbench compatibility).
     * I moduli che usano parent::getPackageProviders() ricevono XotServiceProvider.
     *
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            XotServiceProvider::class,
        ];
    }

    /**
<<<<<<< HEAD
=======
     * Create and bootstrap the Laravel app for tests.
     * Must run migrate BEFORE DatabaseTransactions starts transactions.
     */
    public function createApplication(): Application
    {
        $app = $this->createBaseApplication();

        if (! static::$migrated) {
            $this->ensureTestDatabasesExist();

            $kernel = $app->make(Kernel::class);
            $migrationPaths = [
                'Modules/Xot/database/migrations',
                'Modules/User/database/migrations',
                'Modules/Activity/database/migrations',
            ];

            foreach ($migrationPaths as $path) {
                $exitCode = $kernel->call('migrate', [
                    '--env' => 'testing',
                    '--path' => $path,
                ]);
                if (0 !== $exitCode) {
                    throw new \RuntimeException('Testing database migrate failed in XotBaseTestCase (env=testing, path='.$path.'): '.$kernel->output());
                }
            }

            static::$migrated = true;
        }

        return $app;
    }

    /**
>>>>>>> 998c8857 (Remove deprecated files and update project structure, including the deletion of workspace configuration, documentation files, and changelogs. Update composer.json for module name and dependencies.)
     * Setup the test environment.
     * Binds common dependencies required by tests.
     */
    protected function setUp(): void
    {
<<<<<<< HEAD
=======
        $this->forceSqliteEnvWhenMysqlUnavailable();
        if ('sqlite' === (string) env('DB_CONNECTION', 'mysql')) {
            $this->connectionsToTransact = ['mysql'];
        }

>>>>>>> 998c8857 (Remove deprecated files and update project structure, including the deletion of workspace configuration, documentation files, and changelogs. Update composer.json for module name and dependencies.)
        parent::setUp();

        // Bind translator only if not already resolved (needed for some Filament tests).
        // This ensures the application is in a consistent state for unit tests.
        if (! $this->app->bound('translator')) {
            $this->app->singleton('translator', function ($app) {
                return new \Illuminate\Translation\Translator(
                    new \Illuminate\Translation\ArrayLoader(),
                    'en'
                );
            });
        }
    }

<<<<<<< HEAD
=======
    protected function forceSqliteEnvWhenMysqlUnavailable(): void
    {
        if ('sqlite' === (string) env('DB_CONNECTION', 'mysql')) {
            return;
        }

        $host = (string) env('DB_HOST', '127.0.0.1');
        $port = (string) env('DB_PORT', '3306');
        $username = (string) env('DB_USERNAME', 'root');
        $password = (string) env('DB_PASSWORD', '');

        if ($this->canConnectToMysql($host, $port, $username, $password)) {
            return;
        }

        $sqliteBase = 'testing';
        $basePath = realpath(__DIR__.'/../../../');
        $sqlitePath = $basePath.'/database/'.$sqliteBase.'.sqlite';
        if (! file_exists($sqlitePath)) {
            @touch($sqlitePath);
        }

        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE='.$sqliteBase);
        putenv('DB_DATABASE_USER='.$sqliteBase);
        putenv('DB_DATABASE_ACTIVITY='.$sqliteBase);

        $_ENV['DB_CONNECTION'] = 'sqlite';
        $_ENV['DB_DATABASE'] = $sqliteBase;
        $_ENV['DB_DATABASE_USER'] = $sqliteBase;
        $_ENV['DB_DATABASE_ACTIVITY'] = $sqliteBase;

        $_SERVER['DB_CONNECTION'] = 'sqlite';
        $_SERVER['DB_DATABASE'] = $sqliteBase;
        $_SERVER['DB_DATABASE_USER'] = $sqliteBase;
        $_SERVER['DB_DATABASE_ACTIVITY'] = $sqliteBase;
    }

    /**
     * Ensure testing databases exist.
     * Uses env() directly because this runs DURING app bootstrap.
     */
    protected function ensureTestDatabasesExist(): void
    {
        static $databasesCreated = false;
        if ($databasesCreated) {
            return;
        }

        if ('sqlite' === (string) env('DB_CONNECTION', 'mysql') || 'sqlite' === (string) config('database.default', 'mysql')) {
            $databasesCreated = true;

            return;
        }

        $host = (string) env('DB_HOST', '127.0.0.1');
        $port = (string) env('DB_PORT', '3306');
        $username = (string) env('DB_USERNAME', 'root');
        $password = (string) env('DB_PASSWORD', '');

        if (! $this->canConnectToMysql($host, $port, $username, $password)) {
            $databasesCreated = true;

            return;
        }

        $databases = [
            env('DB_DATABASE'),
            env('DB_DATABASE_USER'),
            env('DB_DATABASE_ACTIVITY', env('DB_DATABASE')),
        ];

        foreach ($databases as $dbName) {
            if (empty($dbName)) {
                continue;
            }

            try {
                $pdo = new \PDO(
                    'mysql:host='.$host.';port='.$port,
                    $username,
                    $password
                );
                $pdo->exec('CREATE DATABASE IF NOT EXISTS `'.$dbName.'`');
            } catch (\PDOException) {
                // Database may already exist or connection failed - continue
            }
        }

        $databasesCreated = true;
    }

    protected function canConnectToMysql(string $host, string $port, string $username, string $password): bool
    {
        try {
            new \PDO('mysql:host='.$host.';port='.$port, $username, $password);

            return true;
        } catch (\Throwable) {
            return false;
        }
    }

>>>>>>> 998c8857 (Remove deprecated files and update project structure, including the deletion of workspace configuration, documentation files, and changelogs. Update composer.json for module name and dependencies.)
    protected function tearDown(): void
    {
        // Prevent connection accumulation across a long multi-connection suite.
        try {
            if (isset($this->app)) {
                /** @var \Illuminate\Database\DatabaseManager $db */
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

    /**
     * Generate a unique email for tests.
     */
    protected static function generateUniqueEmail(): string
    {
        return 'test-'.uniqid((string) mt_rand(), true).'@example.com';
    }

    /**
     * Get the user class from XotData.
     *
     * @return class-string<\Illuminate\Database\Eloquent\Model&UserContract>
     */
    protected static function getUserClass(): string
    {
        return XotData::make()->getUserClass();
    }

    /**
     * Create a test user with optional attributes.
     *
     * @param array<string, mixed> $attributes
     */
    protected static function createTestUser(array $attributes = []): UserContract
    {
        $userClass = static::getUserClass();

        return $userClass::factory()->create($attributes);
    }
}
