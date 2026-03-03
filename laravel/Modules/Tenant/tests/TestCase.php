<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests;

use Modules\Tenant\Providers\TenantServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Tenant module.
 *
 * Extends XotBaseTestCase (DRY + KISS + Laraxot).
 */
abstract class TestCase extends XotBaseTestCase
{
    /**
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            TenantServiceProvider::class,
        ];
    }
}
