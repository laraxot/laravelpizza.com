<?php

declare(strict_types=1);

namespace Modules\Activity\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Activity module.
 *
 * Uses MySQL from .env.testing (carbon copy of .env with _test DB names).
 * All module connections are mapped dynamically by TenantServiceProvider.
 * Migrations must be run ONCE externally: php artisan migrate --env=testing
 * DB lifecycle is managed by dedicated integration tests/configuration.
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    /**
     * The database connections that should have transactions rolled back.
     *
     * @var array<int, string>
     */
    protected array $connectionsToTransact = ['mysql', 'activity', 'user'];

    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            \Modules\Xot\Providers\XotServiceProvider::class,
            \Modules\User\Providers\UserServiceProvider::class,
            \Modules\Activity\Providers\ActivityServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     */
    protected function defineEnvironment($app): void
    {
        // Use mysql for Activity to ensure test DB has the table
        $app['config']->set('activitylog.database_connection', 'mysql');
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Reset the model to ensure it uses the correct connection
        // This is needed because Activity has $connection = 'activity' by default
        $this->app->forgetInstance(\Modules\Activity\Models\Activity::class);
    }
}
