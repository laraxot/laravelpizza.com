<?php

declare(strict_types=1);

namespace Modules\Rating\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Modules\Rating\Providers\RatingServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Rating module.
 *
 * Uses shared sqlite from database.sqlite (no migrate:fresh / RefreshDatabase).
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    /** @var list<string> */
    protected $connectionsToTransact = ['rating', 'sqlite', 'xot'];

    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders(Application $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            RatingServiceProvider::class,
        ];
    }

    /**
     * Lo sqlite condiviso (`database/database.sqlite`) non contiene per forza le tabelle
     * del modulo: le migration non vengono lanciate dai test (mai `RefreshDatabase`).
     * I test che toccano il DB vanno saltati, non falliti: è un blocco d'ambiente.
     */
    public static function ratingDbUnavailable(): bool
    {
        try {
            DB::connection('rating')->getPdo();

            return ! DB::connection('rating')->getSchemaBuilder()->hasTable('ratings');
        } catch (\Throwable) {
            return true;
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        $database = self::sharedSqlitePath();

        /** @var array<string, array<string, mixed>> $connections */
        $connections = config('database.connections', []);

        foreach (array_keys($connections) as $connection) {
            if (config("database.connections.{$connection}.driver") !== 'sqlite') {
                continue;
            }

            $this->app['config']->set("database.connections.{$connection}.database", $database);
            DB::purge($connection);
        }
    }
}
