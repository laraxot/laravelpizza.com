<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

/**
 * Base test case for Xot module.
 *
 * Uses MySQL from .env.testing (NOT SQLite).
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected static bool $migrated = false;
    protected static ?string $dbName = null;

    protected function setUp(): void
    {
        parent::setUp();

        if (self::$dbName === null) {
            self::$dbName = 'file:memdb_xot?mode=memory&cache=shared';
        }

        $dbName = self::$dbName;
        $connections = [
            'sqlite',
            'mysql',
            'mariadb',
            'pgsql',
            'activity',
            'cms',
            'gdpr',
            'geo',
            'job',
            'lang',
            'media',
            'meetup',
            'notify',
            'seo',
            'tenant',
            'ui',
            'user',
            'xot',
        ];

        foreach ($connections as $conn) {
            config(["database.connections.{$conn}.driver" => 'sqlite']);
            config(["database.connections.{$conn}.database" => $dbName]);
        }

        foreach ($connections as $conn) {
            DB::purge($conn);
        }

        foreach ($connections as $conn) {
            try {
                $pdo = DB::connection($conn)->getPdo();
                if (method_exists($pdo, 'sqliteCreateFunction')) {
                    $pdo->sqliteCreateFunction('md5', static fn (?string $value): ?string => $value === null ? null : md5($value));
                    $pdo->sqliteCreateFunction('unhex', static fn (?string $value): ?string => $value);
                }
            } catch (\Throwable) {
            }
        }

        if (!self::$migrated) {
            $this->artisan('module:migrate', ['module' => 'Xot', '--force' => true]);
            $this->artisan('module:migrate', ['module' => 'User', '--force' => true]);
            $this->artisan('module:migrate', ['module' => 'Job', '--force' => true]);
            self::$migrated = true;
        }
    }
}
