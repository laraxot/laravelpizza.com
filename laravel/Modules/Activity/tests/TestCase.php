<?php

declare(strict_types=1);

namespace Modules\Activity\Tests;

<<<<<<< HEAD
use Illuminate\Foundation\Testing\DatabaseTransactions;
=======
>>>>>>> a21dc33d (.)
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Activity module.
 *
 * Uses MySQL from .env.testing (carbon copy of .env with _test DB names).
 * All module connections are mapped dynamically by TenantServiceProvider.
<<<<<<< HEAD
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

=======
 * Migrations are run ONCE automatically via XotBaseTestCase.
 */
abstract class TestCase extends XotBaseTestCase
{
>>>>>>> a21dc33d (.)
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
<<<<<<< HEAD
        // Use mysql for Activity to ensure test DB has the table
=======
>>>>>>> a21dc33d (.)
        $app['config']->set('activitylog.database_connection', 'mysql');
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

<<<<<<< HEAD
        // Reset the model to ensure it uses the correct connection
        // This is needed because Activity has $connection = 'activity' by default
=======
>>>>>>> a21dc33d (.)
        $this->app->forgetInstance(\Modules\Activity\Models\Activity::class);
    }
}
