<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests;

use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Gdpr module.
 *
 * Extends XotBaseTestCase (DRY + KISS + Laraxot).
 * Migrations: php artisan migrate --env=testing (una volta).
 */
abstract class TestCase extends XotBaseTestCase
{
    /** @var array<int, string> */
    protected array $connectionsToTransact = [
        'mysql',
        'user',
        'gdpr',
    ];

    /**
     * @return array<int, class-string<"Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            ...parent::getPackageProviders($app),
            GdprServiceProvider::class,
        ];
    }
}
