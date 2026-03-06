<?php

declare(strict_types=1);

namespace Modules\Geo\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Geo\Tests\Support\EnsuresGeoDatabaseSchema;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Geo module.
 *
 * Extends XotBaseTestCase (DRY + KISS + Laraxot).
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;
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
