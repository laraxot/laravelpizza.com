<?php

declare(strict_types=1);

namespace Modules\User\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;
use Modules\Xot\Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Boot theme for pub_theme:: view resolution
        config(['xra.pub_theme' => 'Meetup']);
        config(['xra.register_pub_theme' => true]);

        // Unifichiamo le connessioni per usare lo stesso database in memoria condiviso.
        // Questo permette alle asserzioni (default) di vedere i dati dei modelli (user).
        $dbName = 'file:memdb_'.Str::random(10).'?mode=memory&cache=shared';
        
        $this->app['config']->set('database.connections.sqlite.database', $dbName);
        $this->app['config']->set('database.connections.user.database', $dbName);
        $this->app['config']->set('database.connections.user.driver', 'sqlite');

        // Specific module migrations
        try {
            $this->artisan('module:migrate', ['module' => 'User', '--force' => true]);
            $this->artisan('module:migrate', ['module' => 'Xot', '--force' => true]); // Spesso necessario per Profile/etc
        } catch (\Throwable $e) {
            // Ignored as per base project requirements
        }
    }
}
