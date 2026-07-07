<?php

declare(strict_types=1);

namespace Modules\Media\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Media\Providers\MediaServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Media module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 * Migrations must be run ONCE externally: php artisan migrate --env=testing
 * DatabaseTransactions handles rollback between tests.
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    /**
     * @param  array<string, mixed>  $where
     */
    public function assertMediaTableHas(string $table, array $where, string $connection = 'media'): void
    {
        $this->assertDatabaseHas($table, $where, $connection);
    }

    /**
     * @template T of object
     *
     * @param  class-string<T>  $class
     * @return T&\PHPUnit\Framework\MockObject\MockObject
     */
    public function makeTestMock(string $class): object
    {
        return $this->createMock($class);
    }

    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders(Application $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            MediaServiceProvider::class,
        ];
    }
}
