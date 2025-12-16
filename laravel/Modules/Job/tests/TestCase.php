<?php

declare(strict_types=1);

namespace Modules\Job\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Job\Providers\JobServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Job module tests.
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

        // Load Job module specific configurations
        $this->loadLaravelMigrations();

        // Seed any required data for Job tests
        $this->artisan('module:seed', ['module' => 'Job']);
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
            JobServiceProvider::class,
        ];
    }
}
