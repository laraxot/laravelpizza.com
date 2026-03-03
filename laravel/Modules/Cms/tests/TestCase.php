<?php

declare(strict_types=1);

namespace Modules\Cms\Tests;

use Modules\Cms\Providers\CmsServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Cms module.
 *
 * Extends XotBaseTestCase (DRY + KISS + Laraxot).
 */
abstract class TestCase extends XotBaseTestCase
{
    /** @var array<int, string> */
    protected $connectionsToTransact = [
        'mysql',
        'user',
    ];

    /**
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            CmsServiceProvider::class,
        ];
    }
}
