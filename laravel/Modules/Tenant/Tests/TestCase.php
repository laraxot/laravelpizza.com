<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Tenant\Providers\TenantServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Tenant module tests.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Load Tenant module specific configurations
        $this->loadLaravelMigrations();

        // Seed any required data for Tenant tests
        $this->artisan('module:seed', ['module' => 'Tenant']);
    }

    /**
     * Get package providers.
     *
     * @param  Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            TenantServiceProvider::class,
        ];
    }
}
