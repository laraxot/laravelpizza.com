<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case applicazione.
 *
 * Usa MySQL da .env.testing — MAI RefreshDatabase / migrate:fresh / migrate --force.
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    /** @var array<int, string> */
    protected $connectionsToTransact = [
        'mysql',
        'user',
    ];
}
