<?php

declare(strict_types=1);

namespace Modules\Media\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Modules\Media\Providers\MediaServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Media module tests.
 *
 * Uses MySQL from .env.testing (NOT SQLite). Runs full migrate first, then module migrations.
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

        if ($this->app['config']->get('database.connections.media') === null) {
            $default = (string) $this->app['config']->get('database.default');
            $fallback = $this->app['config']->get("database.connections.{$default}")
                ?? $this->app['config']->get('database.connections.mysql');

            if (is_array($fallback)) {
                $this->app['config']->set('database.connections.media', $fallback);
            }
        }

        if (! self::$migrated) {
            $this->artisan('migrate', ['--force' => true]);
            self::$migrated = true;
        }

        $this->artisan('module:migrate', ['module' => 'Xot', '--force' => true]);
        $this->artisan('module:migrate', ['module' => 'User', '--force' => true]);
        $this->artisan('module:migrate', ['module' => 'Media', '--force' => true]);

        // Manual DB transaction, started after the "media" connection alias is configured.
        DB::connection('media')->beginTransaction();

        // Ensure a clean state for each test without using RefreshDatabase.
        // We delete rows (instead of TRUNCATE) to keep the operation transactional.
        try {
            DB::connection('media')->table('media_converts')->delete();
        } catch (\Throwable) {
        }

        try {
            DB::connection('media')->table('media')->delete();
        } catch (\Throwable) {
        }
    }

    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        try {
            DB::connection('media')->rollBack();
        } catch (\Throwable) {
        }

        parent::tearDown();
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
