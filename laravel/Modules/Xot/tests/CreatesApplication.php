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

        // Explicitly set the base path before requiring bootstrap/app.php
        $_ENV['APP_BASE_PATH'] = $basePath;

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
