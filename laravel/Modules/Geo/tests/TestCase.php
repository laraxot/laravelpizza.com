<?php

declare(strict_types=1);

namespace Modules\Geo\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Geo module tests — schema is provisioned outside the suite.
 * Never RefreshDatabase / module:migrate here: they mutate shared `*_test` DBs.
 */
abstract class TestCase extends XotBaseTestCase
{
    protected function setUp(): void
    {
        // Prima di parent::setUp(): DatabaseTransactions apre le transazioni subito; senza questo la
        // connessione `user` (mysql) va in "Connection refused" dove non c'e' MariaDB (vedi XotBaseTestCase).
        $this->prepareSharedSqliteForTesting();

        parent::setUp();
    }

    use DatabaseTransactions;

    /** @var list<string> */
    protected $connectionsToTransact = ['sqlite', 'geo'];
}
