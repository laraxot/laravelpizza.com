<?php

declare(strict_types=1);

namespace Modules\Progressioni\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Modules\Xot\Tests\TestCase as XotTestCase;

abstract class TestCase extends XotTestCase
{
    use DatabaseTransactions;

    /**
     * Connessioni su cui fare rollback tra i test.
     *
     * @var list<string>
     */
    protected $connectionsToTransact = ['mysql', 'progressione', 'user', 'notify'];

    protected function setUp(): void
    {
        parent::setUp();

        $testDatabase = env('DB_DATABASE_PROGRESSIONE', 'progressione_new_test');
        if (! is_string($testDatabase) || $testDatabase === '') {
            return;
        }

        $this->app['config']->set('database.connections.progressione.database', $testDatabase);
        DB::purge('progressione');
    }
}
