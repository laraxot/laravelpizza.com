<?php

declare(strict_types=1);

namespace Modules\Seo\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Modules\User\Models\User;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Seo module.
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    /** @var list<string> */
    protected $connectionsToTransact = [
        'sqlite',
        'user',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $database = self::sharedSqlitePath();

        /** @var array<string, array<string, mixed>> $connections */
        $connections = config('database.connections', []);

        foreach (array_keys($connections) as $connection) {
            $driver = config("database.connections.{$connection}.driver");

            if ($driver === 'sqlite') {
                $this->app['config']->set("database.connections.{$connection}.database", $database);
                DB::purge($connection);

                continue;
            }

            if ($driver === 'mysql') {
                $this->app['config']->set("database.connections.{$connection}.driver", 'sqlite');
                $this->app['config']->set("database.connections.{$connection}.database", $database);
                $this->app['config']->set("database.connections.{$connection}.prefix", '');
                DB::purge($connection);
            }
        }

        config(['auth.providers.users.model' => User::class]);
        config(['xra.pub_theme' => 'Meetup']);
        config(['xra.main_module' => 'Seo']);
    }
}
