<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests;

use Modules\Xot\Tests\TestCase as XotTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends XotTestCase
{
    use DatabaseTransactions;

    /**
     * The database connections that should have transactions rolled back.
     *
     * MANDATORY: must include every connection used by this module's models.
     * Incentivi models use $connection = 'incentivi' (separate PDO handle).
     * Without this, Incentivi data is NEVER rolled back between tests.
     *
     * @var array<int, string>
     */
    protected array $connectionsToTransact = ['mysql', 'incentivi', 'user'];
}
