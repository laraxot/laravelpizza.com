<?php

declare(strict_types=1);

namespace Modules\Geo\Tests;

use Modules\Geo\Tests\Support\EnsuresGeoDatabaseSchema;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Geo module.
 *
 * Extends XotBaseTestCase (DRY + KISS + Laraxot).
 *
 * NOTE: DatabaseTransactions trait is already included in XotBaseTestCase.
 * Do NOT add it again - it would be redundant.
 */
abstract class TestCase extends XotBaseTestCase
{
    use EnsuresGeoDatabaseSchema;

    /** @var array<int, string> */
    protected array $connectionsToTransact = [
        'mysql',
        'user',
        'geo',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->ensureGeoSchema();
    }

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
