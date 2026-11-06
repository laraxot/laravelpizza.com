<?php

declare(strict_types=1);

namespace Modules\Geo\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Geo module tests — schema is provisioned outside the suite.
 * Never RefreshDatabase / module:migrate here: they mutate shared `*_test` DBs.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    /** @var list<string> */
    protected $connectionsToTransact = ['fixcity', 'mariadb', 'user', 'geo'];
}
