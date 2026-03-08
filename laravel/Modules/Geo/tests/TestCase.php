<?php

declare(strict_types=1);

namespace Modules\Geo\Tests;

use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Geo module.
 *
 * Extends XotBaseTestCase (DRY + KISS + Laraxot).
 */
abstract class TestCase extends XotBaseTestCase
{
    /** @var array<int, string> */
    protected array $connectionsToTransact = [
        'mysql',
        'user',
    ];

    /**
     * @return array<int, class-string<"Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            ...parent::getPackageProviders($app),
            GeoServiceProvider::class,
        ];
    }
}
