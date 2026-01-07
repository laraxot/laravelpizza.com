<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests;

use Illuminate\Foundation\Application;
use Modules\Tenant\Providers\TenantServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * Base test case for Tenant module tests.
 */
abstract class TestCase extends BaseTestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Load Laravel migrations for testing
        $this->loadLaravelMigrations();
    }

    /**
     * Get package providers.
     *
     * @param  Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            TenantServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     */
    protected function defineEnvironment($app): void
    {
        // Setup default environment variables
        $app['config']->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');
    }
}
