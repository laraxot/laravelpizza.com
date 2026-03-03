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

        $app = require $basePath.'/bootstrap/app.php';

        // Bind essential paths if they are not correctly resolved
        $app->instance('path.base', $basePath);
        $app->bind('path.public', fn () => $basePath.'/public_html');
        $app->bind('path.storage', fn () => $basePath.'/storage');

        // Bootstrap kernel to ensure all service providers and aliases are registered
        $app->make(Kernel::class)->bootstrap();
        $app->boot(); // Ensure all service providers are booted

        // CRITICAL: DO NOT force database connections!
        // TenantServiceProvider automatically configures module connections
        // by reading DB_DATABASE from .env.testing
        // Forcing connections here destroys the dynamic configuration system

        return $app;
    }
}
