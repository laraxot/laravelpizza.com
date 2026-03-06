<?php

declare(strict_types=1);

namespace Modules\Activity\Tests;

use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Activity module.
 *
 * Uses MySQL from .env.testing (carbon copy of .env with _test DB names).
 * All module connections are mapped dynamically by TenantServiceProvider.
 * Migrations are run ONCE automatically via XotBaseTestCase.
 */
abstract class TestCase extends XotBaseTestCase
{
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
        $app['config']->set('activitylog.database_connection', 'mysql');
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->forgetInstance(\Modules\Activity\Models\Activity::class);
    }
}
