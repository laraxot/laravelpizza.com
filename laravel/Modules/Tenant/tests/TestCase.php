<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests;

use Illuminate\Foundation\Application;
use Modules\Tenant\Providers\TenantServiceProvider;
use Modules\Xot\Tests\CreatesApplication;
use Modules\Xot\Tests\TestCase as XotTestCase;

/**
 * Base test case for Tenant module tests.
 *
 * Uses MySQL from .env.testing (NOT SQLite). Single source of truth: .env.testing.
 * Runs full migrate first, then module migrations.
 *
 * @property \Modules\Tenant\Models\TestSushiModel $model
 * @property string $testDirectory
 * @property string $testJsonPath
 * @property \Closure $createTestData
 */
abstract class TestCase extends XotTestCase
{
    use CreatesApplication;

    protected static bool $migrated = false;

    protected function setUp(): void
    {
        parent::setUp();

        if (! self::$migrated) {
            $this->artisan('migrate', ['--force' => true]);
            self::$migrated = true;
        }

        $this->artisan('module:migrate', ['module' => 'Xot', '--force' => true]);
        $this->artisan('module:migrate', ['module' => 'User', '--force' => true]);
        $this->artisan('module:migrate', ['module' => 'Tenant', '--force' => true]);
    }

    /**
     * @param  Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            TenantServiceProvider::class,
        ];
    }
}
