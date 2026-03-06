<?php

declare(strict_types=1);

namespace Modules\User\Tests;

use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for User module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 * Migrations are run ONCE automatically via XotBaseTestCase.
 * DatabaseTransactions handles rollback between tests.
 */
abstract class TestCase extends XotBaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }
}
