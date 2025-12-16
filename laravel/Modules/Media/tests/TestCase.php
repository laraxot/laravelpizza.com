<?php

declare(strict_types=1);

namespace Modules\Media\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Media\Providers\MediaServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Media module tests.
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

        // Load Media module specific configurations
        $this->loadLaravelMigrations();

        // Seed any required data for Media tests
        $this->artisan('module:seed', ['module' => 'Media']);
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
            MediaServiceProvider::class,
        ];
    }
}
