<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Base test case for Xot module.
 *
 * Uses MySQL from .env.testing (NOT SQLite).
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'xot']);
        $this->artisan('migrate', ['--database' => 'user']);
    }
}
