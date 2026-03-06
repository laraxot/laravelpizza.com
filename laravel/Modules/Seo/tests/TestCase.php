<?php

declare(strict_types=1);

namespace Modules\Seo\Tests;

use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Seo module.
 */
abstract class TestCase extends XotBaseTestCase
{
    /** @var array<int, string> */
    protected $connectionsToTransact = ['mysql', 'activity', 'user', 'seo'];

    protected function setUp(): void
    {
        parent::setUp();
        config(['xra.main_module' => 'Seo']);
    }

    /**
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            ...parent::getPackageProviders($app),
            \Modules\Seo\Providers\SeoServiceProvider::class,
        ];
    }
}
