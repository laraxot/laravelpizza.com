<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Config;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Gdpr module.
 *
 * ## Why MySQL (never SQLite)
 * The project uses multiple named DB connections (user, gdpr, xot, tenant, etc.).
 * SQLite cannot replicate this multi-connection topology. MySQL from .env.testing
 * guarantees the same engine, charset, collation, and foreign-key behaviour as
 * production, avoiding false positives/negatives.
 *
 * ## Why DatabaseTransactions (never RefreshDatabase)
 * RefreshDatabase drops and recreates every table on each test class, which is
 * extremely slow on MySQL and destroys seed data that other modules may rely on.
 * DatabaseTransactions wraps each test in a transaction and rolls back at the end,
 * giving perfect isolation with near-zero overhead.
 *
 * ## Why we pre-register module connections
 * In testing (APP_ENV=testing), TenantServiceProvider::registerDB() returns early
 * and does NOT dynamically register module connections. But `php artisan migrate`
 * needs ALL module connections (lang, gdpr, xot, user, etc.) because Laraxot
 * auto-discovers migrations from ALL modules. We replicate what registerDB() does:
 * copy the default connection config for each module that needs a connection.
 *
 * ## Why generic `php artisan migrate` (no --database)
 * Laraxot auto-discovers migrations from ALL modules via their ServiceProviders.
 * A generic migrate runs them in the correct dependency order (Xot -> User -> Gdpr ...).
 * Specifying `--database` per module would only run migrations for that single
 * connection and miss cross-module tables.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected static bool $migrated = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ensureModuleConnections();

        if (! self::$migrated) {
            $this->artisan('migrate');
            self::$migrated = true;
        }
    }

    /**
     * Register module database connections that TenantServiceProvider would normally create.
     *
     * In production, TenantServiceProvider::registerDB() copies the default connection
     * for each module. During testing (APP_ENV=testing), it skips this step.
     * We replicate that behaviour here so that `php artisan migrate` can find all connections.
     */
    private function ensureModuleConnections(): void
    {
        $default = config('database.default');
        $defaultConfig = config("database.connections.{$default}");

        if (! is_array($defaultConfig)) {
            $this->markTestSkipped("Default database connection [{$default}] not configured in .env.testing");
        }

        // All module connection names that Laraxot may reference during migration
        $moduleConnections = [
            'xot', 'user', 'gdpr', 'lang', 'cms', 'tenant',
            'activity', 'geo', 'job', 'media', 'meetup',
            'notify', 'seo', 'ui',
        ];

        foreach ($moduleConnections as $name) {
            if (config("database.connections.{$name}") === null) {
                Config::set("database.connections.{$name}", $defaultConfig);
            }
        }
    }
}
