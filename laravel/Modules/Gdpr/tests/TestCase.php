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
 * All module connections are mapped by TenantServiceProvider.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected $connectionsToTransact = [
        'mysql',
        'user',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        config(['xra.pub_theme' => 'Meetup']);
        config(['xra.main_module' => 'User']);
        config(['xra.register_pub_theme' => true]);

        \Modules\Xot\Datas\XotData::make()->update([
            'pub_theme' => 'Meetup',
            'main_module' => 'User',
            'register_pub_theme' => true,
        ]);

        // NOTE: Migrations are NOT run in setUp()
        // They must be run ONCE externally: php artisan migrate --env=testing
        // DatabaseTransactions trait handles rollback automatically between tests
    }

    protected function getPackageProviders($app): array
    {
        return [
            XotServiceProvider::class,
            UserServiceProvider::class,
            GdprServiceProvider::class,
        ];
    }
}
