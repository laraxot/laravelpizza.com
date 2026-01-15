<?php

declare(strict_types=1);

namespace Modules\User\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for User module.
 *
 * Uses dedicated testing.sqlite file to ensure connection sharing.
 *
 * @property \Modules\User\Models\Permission $permission
 * @property \Modules\User\Models\Role       $role
 * @property \Modules\User\Models\Tenant     $tenant
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected static bool $migrated = false;

    protected $connectionsToTransact = [
        'mysql',
        'user',
        'notify',
        'geo',
        'media',
        'job',
        'xot',
        'activity',
        'cms',
        'gdpr',
        'lang',
        'meetup',
        'seo',
        'tenant',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        config(['xra.pub_theme' => 'Meetup']);
        config(['xra.main_module' => 'User']);

        \Modules\Xot\Datas\XotData::make()->update([
            'pub_theme' => 'Meetup',
            'main_module' => 'User',
        ]);

        // Always run migrations for the volatile testing connection context
        // This ensures the testing.sqlite file (or memory DB) has the schema
        if (true) {
            $this->artisan('module:migrate', ['module' => 'Xot', '--force' => true]);
            $this->artisan('module:migrate', ['module' => 'User', '--force' => true]);
            $this->artisan('module:migrate', ['module' => 'Cms', '--force' => true]);
            $this->artisan('module:migrate', ['module' => 'Geo', '--force' => true]);
        }
    }

    public function createApplication()
    {
        $app = parent::createApplication();

        // Use persistent file-based SQLite database for testing reliability across connections
        $dbPath = base_path('database/testing.sqlite');
        // Ensure the file exists
        if (! file_exists($dbPath)) {
            touch($dbPath);
        }

        // Force sqlite connection to use this file
        $app['config']->set('database.connections.sqlite.database', $dbPath);

        // Get the updated default config
        $defaultConfig = $app['config']->get('database.connections.sqlite');

        // List of connections to map (same as connectionsToTransact)
        $connectionsToMap = [
            'mysql', 'user', 'notify', 'geo', 'media', 'job', 'xot',
            'activity', 'cms', 'gdpr', 'lang', 'meetup', 'seo', 'tenant',
        ];

        // Map all other connections to use same sqlite file config
        foreach ($connectionsToMap as $connection) {
            $app['config']->set("database.connections.{$connection}", $defaultConfig);
        }

        return $app;
    }
}
