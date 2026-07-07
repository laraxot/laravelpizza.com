<?php

declare(strict_types=1);

namespace Modules\Geo\Tests;

<<<<<<< HEAD
=======
use Illuminate\Contracts\Foundation\Application;
>>>>>>> 40b96bcd6 (.)
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

<<<<<<< HEAD
    protected function getPackageProviders($app): array
=======
    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders(Application $app): array
>>>>>>> 40b96bcd6 (.)
    {
        return [
            XotServiceProvider::class,
            GeoServiceProvider::class,
        ];
    }
}
