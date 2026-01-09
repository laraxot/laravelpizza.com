<?php

declare(strict_types=1);

namespace Modules\Job\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Config;
use Modules\Job\Providers\JobServiceProvider;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Job module tests.
 * 
 * Follows Laraxot architecture rules:
 * - Uses DatabaseTransactions for isolation
 * - Configures all necessary database connections
 * - Runs migrations for specific module connection
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Configure database connections for testing
        $this->configureTestConnections();

        // Run migrations for the job database
        $this->runModuleMigrations();
    }

    /**
     * Configure database connections for testing.
     */
    protected function configureTestConnections(): void
    {
        // Configure the module-specific connection
        Config::set('database.connections.job', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Configure other common connections that might be used
        $commonConnections = ['mysql', 'user', 'tenant', 'notify', 'activity', 'media', 'cms', 'geo'];
        foreach ($commonConnections as $connection) {
            if (!Config::has("database.connections.{$connection}")) {
                Config::set("database.connections.{$connection}", [
                    'driver' => 'sqlite',
                    'database' => ':memory:',
                    'prefix' => '',
                ]);
            }
        }
    }

    /**
     * Run module-specific migrations.
     */
    protected function runModuleMigrations(): void
    {
        $this->artisan('migrate', [
            '--database' => 'job',
            '--path' => 'Modules/Job/database/migrations'
        ]);
    }

    /**
     * Get package providers.
     *
     * @param Application $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            JobServiceProvider::class,
        ];
    }
}
