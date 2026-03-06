<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

/**
 * Trait CreatesApplication.
 *
 * Provides the createApplication method for test cases.
 * This trait is used by all module test cases to bootstrap the Laravel application.
 */
trait CreatesApplication
{
    /**
     * Creates the application.
     */
    public function createApplication(): Application
    {
        // Get base path (assuming tests are in Modules/{Module}/tests/)
        $basePath = realpath(__DIR__.'/../../../');

        // Explicitly set the base path before requiring bootstrap/app.php
        $_ENV['APP_BASE_PATH'] = $basePath;

        // CRITICAL: Load .env.testing BEFORE app bootstrap so TenantServiceProvider
        // and all module connections (activity, user, etc.) use laravelpizza_data_test
        $envTesting = $basePath.'/.env.testing';
        if (file_exists($envTesting)) {
            $dotenv = \Dotenv\Dotenv::createMutable($basePath, '.env.testing');
            $dotenv->safeLoad();
        }

<<<<<<< HEAD
=======
        $this->fallbackToSqliteIfMysqlUnavailable($basePath);

>>>>>>> 998c8857 (Remove deprecated files and update project structure, including the deletion of workspace configuration, documentation files, and changelogs. Update composer.json for module name and dependencies.)
        $app = require $basePath.'/bootstrap/app.php';

        // Bind essential paths if they are not correctly resolved
        $app->instance('path.base', $basePath);
        $app->bind('path.public', fn () => $basePath.'/public_html');
        $app->bind('path.storage', fn () => $basePath.'/storage');

        // Bootstrap kernel to ensure all service providers and aliases are registered
        $app->make(Kernel::class)->bootstrap();
        $app->boot(); // Ensure all service providers are booted

<<<<<<< HEAD
=======
        if ('sqlite' === (string) ($_ENV['DB_CONNECTION'] ?? 'mysql')) {
            $sqlitePath = $basePath.'/database/testing.sqlite';
            if (! file_exists($sqlitePath)) {
                @touch($sqlitePath);
            }

            $sqliteConnection = [
                'driver' => 'sqlite',
                'database' => $sqlitePath,
                'prefix' => '',
                'foreign_key_constraints' => true,
            ];

            /** @var array<string, mixed> $connections */
            $connections = (array) $app['config']->get('database.connections', []);
            foreach (array_keys($connections) as $connectionName) {
                $app['config']->set("database.connections.{$connectionName}", $sqliteConnection);
            }
        }

>>>>>>> 998c8857 (Remove deprecated files and update project structure, including the deletion of workspace configuration, documentation files, and changelogs. Update composer.json for module name and dependencies.)
        // CRITICAL: Force purge of connections to ensure they pick up the
        // test database configuration from .env.testing mapped by TenantServiceProvider
        \Illuminate\Support\Facades\DB::purge('mysql');
        \Illuminate\Support\Facades\DB::purge('activity');
        \Illuminate\Support\Facades\DB::purge('user');

        return $app;
    }

    /**
     * Force sqlite testing env when MySQL is unreachable.
     */
    protected function fallbackToSqliteIfMysqlUnavailable(string $basePath): void
    {
        $connection = (string) ($_ENV['DB_CONNECTION'] ?? env('DB_CONNECTION', 'mysql'));
        if ('mysql' !== $connection) {
            return;
        }

        $host = (string) ($_ENV['DB_HOST'] ?? env('DB_HOST', '127.0.0.1'));
        $port = (string) ($_ENV['DB_PORT'] ?? env('DB_PORT', '3306'));
        $username = (string) ($_ENV['DB_USERNAME'] ?? env('DB_USERNAME', 'root'));
        $password = (string) ($_ENV['DB_PASSWORD'] ?? env('DB_PASSWORD', ''));

        try {
            new \PDO('mysql:host='.$host.';port='.$port, $username, $password);

            return;
        } catch (\Throwable) {
            // Fallback below.
        }

        $sqliteBase = 'testing';
        $sqlitePath = $basePath.'/database/'.$sqliteBase.'.sqlite';
        if (! file_exists($sqlitePath)) {
            @touch($sqlitePath);
        }

        $_ENV['DB_CONNECTION'] = 'sqlite';
        $_ENV['DB_DATABASE'] = $sqliteBase;
        $_ENV['DB_DATABASE_USER'] = $sqliteBase;
        $_ENV['DB_DATABASE_ACTIVITY'] = $sqliteBase;

        $_SERVER['DB_CONNECTION'] = 'sqlite';
        $_SERVER['DB_DATABASE'] = $sqliteBase;
        $_SERVER['DB_DATABASE_USER'] = $sqliteBase;
        $_SERVER['DB_DATABASE_ACTIVITY'] = $sqliteBase;

        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE='.$sqliteBase);
        putenv('DB_DATABASE_USER='.$sqliteBase);
        putenv('DB_DATABASE_ACTIVITY='.$sqliteBase);
    }
}
