<?php

declare(strict_types=1);

namespace Modules\\$dir\\Tests;

use Illuminate\\Foundation\\Testing\\DatabaseTransactions;
use Illuminate\\Foundation\\Testing\\TestCase as BaseTestCase;
use Modules\\Xot\\Tests\\CreatesApplication;

/**
 * Base test case for $dir module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected $connectionsToTransact = [
        'mysql',
        'user',
    ];

    protected static bool \$migrated = false;

    protected function setUp(): void
    {
        parent::setUp();

        config(['xra.pub_theme' => 'Meetup']);
        config(['xra.main_module' => 'User']);

        \\Modules\\Xot\\Datas\\XotData::make()->update([
            'pub_theme' => 'Meetup',
            'main_module' => 'User',
        ]);

        if (! self::\$migrated) {
            \$this->artisan('module:migrate');
            self::\$migrated = true;
        }
    }
}
