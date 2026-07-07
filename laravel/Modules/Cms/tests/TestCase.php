<?php

declare(strict_types=1);

namespace Modules\Cms\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Modules\Cms\Providers\CmsServiceProvider;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Cms module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    public static ?self $currentTest = null;

    public string $lang = 'it';

    /**
     * @var array<int, string>
     */
    protected $connectionsToTransact = [
        'sqlite',
        'user',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        self::$currentTest = $this;

        $database = database_path('fixcity_data.sqlite');

        /** @var array<string, array<string, mixed>> $connections */
        $connections = config('database.connections', []);

        foreach (array_keys($connections) as $connection) {
            if ('sqlite' !== config("database.connections.{$connection}.driver")) {
                continue;
            }

            $this->app['config']->set("database.connections.{$connection}.database", $database);
            DB::purge($connection);
        }

        config(['xra.pub_theme' => 'TwentyOne']);
        config(['xra.main_module' => 'User']);

        XotData::make()->update([
            'pub_theme' => 'TwentyOne',
            'main_module' => 'User',
        ]);

        // NOTE: Migrations are NOT run in setUp()
        // They must be run ONCE externally: php artisan migrate --env=testing
        // DatabaseTransactions trait handles rollback automatically between tests
    }

    protected function tearDown(): void
    {
        self::$currentTest = null;
        parent::tearDown();
    }

    /**
     * @return array<int, class-string<ServiceProvider>>
     */
    protected function getPackageProviders(mixed $app): array
    {
        return [
            XotServiceProvider::class,
            UserServiceProvider::class,
            CmsServiceProvider::class,
        ];
    }

    public static function pestGenerateUniqueEmail(): string
    {
        return parent::generateUniqueEmail();
    }

    /**
     * @param array<string, mixed> $attributes
     */
    protected static function createTestUser(array $attributes = []): UserContract
    {
        /** @var UserContract $user */
        $user = UserFactory::new()->createOne($attributes);

        return $user;
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public static function pestCreateTestUser(array $attributes = []): UserContract
    {
        return static::createTestUser($attributes);
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $class
     *
     * @return T&\PHPUnit\Framework\MockObject\MockObject
     */
    public function createPHPUnitMock(string $class): object
    {
        return $this->createUnitMock($class);
    }
}
