<?php

declare(strict_types=1);

namespace Modules\User\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for User module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 * Migrations must be run ONCE externally: php artisan migrate --env=testing
 * DatabaseTransactions handles rollback between tests.
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
}
