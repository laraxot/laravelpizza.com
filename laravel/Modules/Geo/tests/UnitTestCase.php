<?php

declare(strict_types=1);

namespace Modules\Geo\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Geo\Providers\GeoServiceProvider;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Lightweight TestCase for pure unit tests in the Geo module.
 * No database connections — uses SQLite in-memory from phpunit.xml env.
 */
abstract class UnitTestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getPackageProviders($app): array
    {
        return [
            XotServiceProvider::class,
            GeoServiceProvider::class,
        ];
    }
}
