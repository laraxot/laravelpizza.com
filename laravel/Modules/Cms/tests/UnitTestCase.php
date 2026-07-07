<?php

declare(strict_types=1);

namespace Modules\Cms\Tests;

<<<<<<< HEAD
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Cms\Providers\CmsServiceProvider;
use Modules\Tenant\Providers\TenantServiceProvider;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Lightweight TestCase for pure unit tests in the Cms module.
 * No database connections — uses SQLite in-memory from phpunit.xml env.
 */
abstract class UnitTestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getPackageProviders($app): array
    {
        return [
            XotServiceProvider::class,
            TenantServiceProvider::class,
            CmsServiceProvider::class,
        ];
    }
=======
/**
 * Lightweight TestCase alias for pure unit tests in the Cms module.
 */
abstract class UnitTestCase extends TestCase
{
>>>>>>> 40b96bcd6 (.)
}
