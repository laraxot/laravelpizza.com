<?php

declare(strict_types=1);

namespace Modules\Activity\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Activity\Providers\ActivityServiceProvider;
use Spatie\EventSourcing\StoredEvents\EventSubscriber;
use Spatie\EventSourcing\StoredEvents\Repositories\EloquentStoredEventRepository;
use Modules\User\Models\User;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

// Added
/**
 * Base test case for Activity module tests.
 *
 * @property User $user
 * @property mixed $activityData
 * @property mixed $storedEventData
 * @property mixed $snapshotData
 * @property mixed $baseModel
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public ?User $user = null;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Re-configure essential services for testing based on .env.testing
        $this->app['config']->set('database.default', 'testing');
        $this->app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $this->app['config']->set('cache.default', 'array');
        $this->app['config']->set('session.driver', 'array');
        $this->app['config']->set('queue.default', 'sync');

        // Configure other connections if they are explicitly used by models in tests
        // For example, if a model specifically sets $connection = 'user', then 'user' needs to be defined.
        $this->app['config']->set('database.connections.user', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $this->app['config']->set('database.connections.xot', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $this->app['config']->set('database.connections.activity', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $this->app->bind(EventSubscriber::class, function (): EventSubscriber {
            return new EventSubscriber(EloquentStoredEventRepository::class);
        });

        // Run migrations for all relevant modules on their respective connections
        $this->artisan('migrate:fresh', [
            '--database' => 'testing',
            '--path' => 'database/migrations', // Main Laravel migrations
        ]);
        $this->artisan('migrate:fresh', [
            '--database' => 'activity', // Run on 'activity' connection
            '--path' => 'Modules/Activity/database/migrations',
        ]);
        $xotBaseMigrationClass = XotBaseMigration::class;
        $mockModelClass = Model::class;

        // Bind a fallback model to the container for non-existent model classes
        // This attempts to prevent BindingResolutionException during XotBaseMigration construction.
        if (class_exists($xotBaseMigrationClass)) { // Check if XotBaseMigration exists
            $this->app->bind(function ($app, $parameters) use ($mockModelClass) {
                $requestedClass = $parameters[0] ?? null;

                // Check if the requested class name *looks like* a migration-derived model
                // This is a heuristic, adjust as needed.
                if ($requestedClass && str_contains($requestedClass, 'Modules\\') && str_contains($requestedClass, 'Models\\') && is_numeric(substr(class_basename($requestedClass), 0, 1))) {
                    // If it looks like a migration-derived model that would fail, return our mock model.
                    return $app->make($mockModelClass);
                }

                // Otherwise, let the container resolve it normally.
                return null; // Return null to let the container proceed with normal resolution
            });
        }

        $this->artisan('migrate:fresh', [
            '--database' => 'user', // Run on 'user' connection (specific for User module)
            '--path' => 'database/migrations',
        ]);

        Schema::connection('user')->dropIfExists('users');
        Schema::connection('user')->create('users', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->boolean('is_otp')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->string('lang')->nullable();
            $table->timestamp('password_expires_at')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        if (! Schema::connection('user')->hasColumn('users', 'deleted_at')) {
            Schema::connection('user')->table('users', function (Blueprint $table): void {
                $table->timestamp('deleted_at')->nullable();
            });
        }
        $this->artisan('migrate:fresh', [
            '--database' => 'xot', // Run on 'xot' connection (specific for Xot module)
            '--path' => 'Modules/Xot/database/migrations',
        ]);

        // Seed any required data for Activity tests
        $this->artisan('module:seed', ['module' => 'Activity']);
    }

    /**
     * Get package providers.
     *
     * @return array<int, class-string>
     */
    protected function getPackageProviders(mixed $_app): array
    {
        return [
            ActivityServiceProvider::class,
            UserServiceProvider::class,
            XotServiceProvider::class,
        ];
    }
}
