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
        // Set default connection to xot to match the models
        $this->app['config']->set('database.default', 'xot');
        
        // Configure the module-specific connections
        $this->app['config']->set('database.connections.xot', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        
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
        
        // Run the xot tables migrations on the xot connection
        $this->artisan('migrate', [
            '--database' => 'xot',
            '--path' => database_path('migrations'),
        ]);
        
        // Run the module migrations on xot connection (where Task and Result tables should be)
        $this->artisan('migrate', [
            '--database' => 'xot',
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
        
        // Create the tasks and results tables if they don't exist
        if (!Schema::connection('xot')->hasTable('tasks')) {
            Schema::connection('xot')->create('tasks', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('description');
                $table->string('command');
                $table->text('parameters')->nullable();
                $table->string('expression')->nullable();
                $table->string('timezone');
                $table->boolean('is_active')->default(false);
                $table->boolean('dont_overlap')->default(false);
                $table->boolean('run_in_maintenance')->default(false);
                $table->string('notification_email_address')->nullable();
                $table->string('notification_phone_number')->nullable();
                $table->string('notification_slack_webhook'); // Not nullable as per the error
                $table->integer('auto_cleanup_num')->default(0);
                $table->string('auto_cleanup_type')->nullable();
                $table->boolean('run_on_one_server')->default(false);
                $table->boolean('run_in_background')->default(false);
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
            });
        }
        
        if (!Schema::connection('xot')->hasTable('results')) {
            Schema::connection('xot')->create('results', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('task_id');
                $table->timestamp('ran_at');
                $table->string('duration');
                $table->string('result');
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                
                $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
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