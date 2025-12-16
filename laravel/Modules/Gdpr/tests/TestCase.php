<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Gdpr\Providers\GdprServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Gdpr module tests.
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

        // Load Gdpr module specific configurations
        $this->loadLaravelMigrations();

        // Seed any required data for Gdpr tests
        $this->artisan('module:seed', ['module' => 'Gdpr']);
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
            GdprServiceProvider::class,
        ];
    }
}
