<?php

declare(strict_types=1);

namespace Modules\DbForge\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\DbForge\Providers\DbForgeServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for DbForge module tests.
 *
 * Uses MySQL from .env.testing (NOT SQLite). Runs full migrate first.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected static bool $migrated = false;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (! self::$migrated) {
            $this->artisan('migrate', ['--force' => true]);
            self::$migrated = true;
        }

        $this->loadLaravelMigrations();
        $this->artisan('module:seed', ['module' => 'DbForge']);
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
            DbForgeServiceProvider::class,
        ];
    }
}
