<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Gdpr\Providers\GdprServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Gdpr module.
 *
 * Uses MySQL from .env.testing.
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
            $this->artisan('migrate:fresh', [
                '--force' => true,
            ]);

            $this->artisan('module:migrate', [
                '--force' => true,
            ]);

            self::$migrated = true;
        }
    }

    protected function getPackageProviders($app): array
    {
        return [
            GdprServiceProvider::class,
            UserServiceProvider::class,
            XotServiceProvider::class,
        ];
    }
}
