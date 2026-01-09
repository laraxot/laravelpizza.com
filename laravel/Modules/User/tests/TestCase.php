<?php

declare(strict_types=1);

namespace Modules\User\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
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

        // Forza la connessione 'user' a usare SQLite in memoria durante i test
        $this->app['config']->set('database.connections.user', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Specific module migrations if memory database is used
        try {
            $this->artisan('module:migrate', ['module' => 'User']);
        } catch (\Throwable $e) {
            // Ignored as per base project requirements
        }
    }
}
