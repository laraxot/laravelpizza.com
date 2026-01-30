<?php

declare(strict_types=1);

namespace Modules\Lang\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Lang\Providers\LangServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Lang module.
 *
 * Uses MySQL from .env.testing (NOT SQLite). Single source of truth: .env.testing.
 * Runs full migrate first, then module migrations.
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

        $this->artisan('module:migrate', ['module' => 'Xot', '--force' => true]);
        $this->artisan('module:migrate', ['module' => 'User', '--force' => true]);
        $this->artisan('module:migrate', ['module' => 'Lang', '--force' => true]);
    }

    /**
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
