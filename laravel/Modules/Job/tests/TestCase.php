<?php

declare(strict_types=1);

namespace Modules\Job\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;
use Modules\Job\Providers\JobServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Job module tests.
 *
 * Philosophy: RESPECT .env.testing - DON'T override it!
 *
 * This TestCase follows the unified testing philosophy:
 * - Trusts .env.testing configuration (single source of truth)
 * - Uses migrations instead of manual Schema::create()
 * - Minimal code - inherits behavior from XotBase
 * - DRY + KISS principles
 *
 * @see Modules/Xot/docs/testing-philosophy-unified.md
 * @see Modules/Job/docs/testing-philosophy-refactor.md
 *
 * Database Configuration:
 * - .env.testing defines JOB_DB_* variables
 * - config/database.php defines 'job' connection
 * - This TestCase just runs migrations - no hardcoded config!
 *
 * From 192 lines to 39 lines. This is the way.
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
            $this->artisan('migrate', ['--force' => true]);
            self::$migrated = true;
        }

        foreach (['job', 'xot'] as $connection) {
            $driver = config("database.connections.{$connection}.driver");
            if (! \is_string($driver) || $driver === '') {
                $this->markTestSkipped('Missing database connection: '.$connection.' (expected from .env.testing)');
            }

            if ($driver !== 'mysql') {
                $this->markTestSkipped('Invalid DB driver for connection '.$connection.': '.$driver.' (expected mysql from .env.testing)');
            }
        }

        if (! Schema::connection('job')->hasTable('jobs')) {
            $this->markTestSkipped('Missing jobs table on connection job. Run migrations on test DBs configured in .env.testing.');
        }

        if (! Schema::connection('xot')->hasTable('tasks') || ! Schema::connection('xot')->hasTable('results')) {
            $this->markTestSkipped('Missing Job module tables (tasks/results) on connection xot. Run module migrations on test DBs configured in .env.testing.');
        }
    }

    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders(Application $app): array
    {
        return [JobServiceProvider::class];
    }
}
