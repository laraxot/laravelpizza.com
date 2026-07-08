<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

use function Safe\realpath;

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
        $testingEnvPath = $basePath.'/.env.testing';

        // Explicitly set the base path before requiring bootstrap/app.php
        $_ENV['APP_BASE_PATH'] = $basePath;

        $appEnv = $_ENV['APP_ENV'] ?? getenv('APP_ENV') ?: 'local';
        if ('testing' === $appEnv && ! is_readable($testingEnvPath)) {
            throw new \RuntimeException('laravel/.env.testing mancante. Rigenerare da .env: ./bashscripts/tools/sync-env-testing.sh');
        }

        $app = $this->loadLaravelApplication($basePath.'/bootstrap/app.php');

        if ('testing' === $appEnv && is_readable($testingEnvPath)) {
            $app->loadEnvironmentFrom('.env.testing');
        }

        // Bind essential paths if they are not correctly resolved
        $app->instance('path.base', $basePath);
        $app->bind('path.public', fn () => $basePath.'/public_html');
        $app->bind('path.storage', fn () => $basePath.'/storage');

        // Bootstrap kernel to ensure all service providers and aliases are registered
        $kernel = $app->make(Kernel::class);
        if (! $kernel instanceof Kernel) {
            throw new \RuntimeException('Console kernel must implement Illuminate\Contracts\Console\Kernel.');
        }

        $kernel->bootstrap();
        $app->boot(); // Ensure all service providers are booted

        // CRITICAL: DO NOT force database connections!
        // TenantServiceProvider automatically configures module connections
        // by reading DB_DATABASE from .env.testing
        // Forcing connections here destroys the dynamic configuration system

        return $app;
    }

    private function loadLaravelApplication(string $bootstrapPath): Application
    {
        $app = require $bootstrapPath;
        if (! $app instanceof Application) {
            throw new \RuntimeException('bootstrap/app.php must return an Application instance.');
        }

        return $app;
    }
}
