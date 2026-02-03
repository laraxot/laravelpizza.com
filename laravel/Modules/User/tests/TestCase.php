<?php

declare(strict_types=1);

namespace Modules\User\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for User module.
 *
 * Uses MySQL from .env.testing (NOT SQLite). Single source of truth: .env.testing.
 * Runs full migrate first, then module migrations.
 *
 * @property \Modules\User\Models\Permission $permission
 * @property \Modules\User\Models\Role       $role
 * @property \Modules\User\Models\Tenant     $tenant
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected static bool $migrated = false;

    protected function setUp(): void
    {
        parent::setUp();

        foreach (['user', 'xot', 'cms', 'geo'] as $connection) {
            $driver = config("database.connections.{$connection}.driver");
            if (! \is_string($driver) || '' === $driver) {
                $this->markTestSkipped('Missing database connection: '.$connection.' (expected from .env.testing)');
            }

            if ('mysql' !== $driver) {
                $this->markTestSkipped('Invalid DB driver for connection '.$connection.': '.$driver.' (expected mysql from .env.testing)');
            }
        }

        if (! self::$migrated) {
            $this->artisan('migrate', ['--force' => true]);
            self::$migrated = true;
        }
    }
}
