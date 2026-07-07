<?php

declare(strict_types=1);

namespace Modules\Job\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Modules\User\Models\User;
use Modules\Job\Providers\JobServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;

/**
 * Base test case for Job module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 * Migrations must be run ONCE externally: php artisan migrate --env=testing
 * DatabaseTransactions handles rollback between tests.
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    /** @var list<string> */
    protected $connectionsToTransact = ['job', 'sqlite', 'xot', 'user'];

    public mixed $action = null;

    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders(Application $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            JobServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $database = database_path('fixcity_data.sqlite');

        /** @var array<string, array<string, mixed>> $connections */
        $connections = config('database.connections', []);

        foreach (array_keys($connections) as $connection) {
            if (config("database.connections.{$connection}.driver") !== 'sqlite') {
                continue;
            }

            $this->app['config']->set("database.connections.{$connection}.database", $database);
            DB::purge($connection);
        }

        config(['auth.providers.users.model' => User::class]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function assertDatabaseHasRow(string $table, array $data, ?string $connection = null): void
    {
        $this->assertDatabaseHas($table, $data, $connection);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function assertDatabaseMissingRow(string $table, array $data, ?string $connection = null): void
    {
        $query = DB::connection($connection)->table($table);

        foreach ($data as $column => $value) {
            $query->where((string) $column, $value);
        }

        Assert::assertFalse($query->exists());
    }

    /**
     * @template T of object
     *
     * @param  class-string<T>  $class
     * @return T
     */
    public function getAction(string $class): object
    {
        Assert::assertInstanceOf($class, $this->action);

        return $this->action;
    }

    /**
     * @param  class-string<\Throwable>  $exceptionClass
     */
    public function expectApplicationException(string $exceptionClass, ?string $message = null): void
    {
        $this->expectException($exceptionClass);
        if ($message !== null) {
            $this->expectThrowableMessage($message);
        }
    }
}
