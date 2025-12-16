<?php

declare(strict_types=1);

namespace Modules\Lang\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Lang\Providers\LangServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Lang module tests.
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

        // Load Lang module specific configurations
        $this->loadLaravelMigrations();

        // Seed any required data for Lang tests
        $this->artisan('module:seed', ['module' => 'Lang']);
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
            LangServiceProvider::class,
        ];
    }
}
