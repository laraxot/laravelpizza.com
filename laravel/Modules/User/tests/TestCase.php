<?php

declare(strict_types=1);

namespace Modules\User\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for User module.
 *
 * Uses MySQL from .env.testing (NOT SQLite).
 *
 * @property \Modules\User\Models\Permission $permission
 * @property \Modules\User\Models\Role $role
 * @property \Modules\User\Models\Tenant $tenant
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        config(['xra.pub_theme' => 'Meetup']);
        config(['xra.main_module' => 'User']);

        \Modules\Xot\Datas\XotData::make()->update([
            'pub_theme' => 'Meetup',
            'main_module' => 'User',
        ]);

        $this->artisan('migrate', ['--database' => 'user']);
        $this->artisan('migrate', ['--database' => 'xot']);
    }
}
