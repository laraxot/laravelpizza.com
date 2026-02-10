<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
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
 * ## Why generic `php artisan migrate` (no --force, no --database)
 * Laraxot auto-discovers migrations from ALL modules via their ServiceProviders.
 * A generic migrate runs them in the correct dependency order (Xot → User → Gdpr …).
 * Specifying `--database` per module would only run migrations for that single
 * connection and miss cross-module tables. Omitting `--force` is safe because
 * APP_ENV=testing is not "production", so Laravel allows migrations without it.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected static bool $migrated = false;

    protected function setUp(): void
    {
        parent::setUp();

        if (! self::$migrated) {
            $this->artisan('migrate');
            self::$migrated = true;
        }
    }
}
