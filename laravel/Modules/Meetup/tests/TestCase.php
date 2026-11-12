<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Meetup\Providers\MeetupServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Meetup module.
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
        'meetup',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        // Stessa configurazione della produzione (config/local/laravelpizza/xra.php): main_module "Meetup", quindi
        // il profilo è Modules\Meetup\Models\Profile (database dati). Con "User" i test usavano un'altra tabella profiles
        // (database utenti, con colonne diverse) e non vedevano i bug del profilo reale.
        config(['xra.pub_theme' => 'Meetup']);
        config(['xra.main_module' => 'Meetup']);

        XotData::make()->update([
            'pub_theme' => 'Meetup',
            'main_module' => 'Meetup',
        ]);

        // NOTE: Migrations are NOT run in setUp()
        // They must be run ONCE externally: php artisan migrate --env=testing
        // DatabaseTransactions trait handles rollback automatically between tests
    }

    protected function getPackageProviders(): array
    {
        return [
            XotServiceProvider::class,
            UserServiceProvider::class,
            MeetupServiceProvider::class,
        ];
    }
}
