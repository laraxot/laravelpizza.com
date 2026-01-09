<?php

declare(strict_types=1);

namespace Modules\Job\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\ConnectionResolver;
use Modules\Job\Providers\JobServiceProvider;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Xot\Tests\CreatesApplication;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

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

        // Configure queue system to use the job connection
        $this->configureQueueSystem();

        // Run migrations for the job database
        $this->runModuleMigrations();
    }

    /**
     * Configure database connections for testing.
     */
    protected function configureTestConnections(): void
    {
        // Configure the module-specific connection
        $this->app['config']->set('database.connections.job', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Configure other common connections that might be used
        $commonConnections = ['mysql', 'user', 'tenant', 'notify', 'activity', 'media', 'cms', 'geo'];
        foreach ($commonConnections as $connection) {
            if (!$this->app['config']->has("database.connections.{$connection}")) {
                $this->app['config']->set("database.connections.{$connection}", [
                    'driver' => 'sqlite',
                    'database' => ':memory:',
                    'prefix' => '',
                ]);
            }
        }
    }

    /**
     * Configure the queue system for testing.
     */
    protected function configureQueueSystem(): void
    {
        // Set the database queue connection to use the job connection
        $this->app['config']->set('queue.default', 'database');
        $this->app['config']->set('queue.connections.database', [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
            'after_commit' => false,
            'connection' => 'job', // Use the job connection
        ]);
        
        // Also set the table name config that the Job model uses
        $this->app['config']->set('queue.connections.database.table', 'jobs');
    }

    /**
     * Run module-specific migrations.
     */
    protected function runModuleMigrations(): void
    {
        // Run the jobs table migration on the job connection
        $this->artisan('migrate', [
            '--database' => 'job',
            '--path' => database_path('migrations'),
        ]);
        
        // Run the module migrations
        $this->artisan('migrate', [
            '--database' => 'job',
            '--path' => 'Modules/Job/database/migrations'
        ]);
        
        // Create the jobs table if it doesn't exist
        if (!Schema::connection('job')->hasTable('jobs')) {
            Schema::connection('job')->create('jobs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('queue')->index();
                $table->longText('payload');
                $table->unsignedTinyInteger('attempts');
                $table->unsignedInteger('reserved_at')->nullable();
                $table->unsignedInteger('available_at');
                $table->unsignedInteger('created_at');
                $table->index(['queue', 'reserved_at']);
            });
        }
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