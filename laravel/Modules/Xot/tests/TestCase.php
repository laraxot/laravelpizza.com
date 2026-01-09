<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('app.env', 'testing');

        $sqliteConnection = [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ];

        $this->app['config']->set('database.default', 'testing');
        $this->app['config']->set('database.connections.testing', $sqliteConnection);
        $this->app['config']->set('database.connections.user', $sqliteConnection);
        $this->app['config']->set('database.connections.xot', $sqliteConnection);
        $this->app['config']->set('database.connections.activity', $sqliteConnection);
        $this->app['config']->set('database.connections.job', $sqliteConnection);

        $this->app['config']->set('cache.default', 'array');
        $this->app['config']->set('session.driver', 'array');
        $this->app['config']->set('queue.default', 'sync');
        $this->app['config']->set('mail.default', 'array');

        if (! \is_string(config('app.key')) || config('app.key') === '') {
            $key = 'base64:'.base64_encode(str_repeat('x', 32));
            $this->app['config']->set('app.key', $key);
            $_ENV['APP_KEY'] = $key;
        }
    }
}
