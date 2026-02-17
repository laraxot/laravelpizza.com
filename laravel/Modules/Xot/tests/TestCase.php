<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Providers\XotServiceProvider;

/**
 * Base test case for Xot module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 */
abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions;

    protected $connectionsToTransact = [
        'mysql',
        'user',
        'media',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        config(['xra.pub_theme' => 'Meetup']);
        config(['xra.main_module' => 'User']);

        \Modules\Xot\Datas\XotData::make()->update([
            'pub_theme' => 'Meetup',
            'main_module' => 'User',
        ]);

        // NOTE: Migrations are NOT run in setUp()
        // They must be run ONCE externally: php artisan migrate --env=testing
        // DatabaseTransactions trait handles rollback automatically between tests
    }

    protected function getPackageProviders($app): array
    {
        return [
            XotServiceProvider::class,
        ];
    }
}
