<?php

declare(strict_types=1);

namespace Modules\User\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;
use Modules\Xot\Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Boot theme for pub_theme:: view resolution
        config(['xra.pub_theme' => 'Meetup']);
        config(['xra.main_module' => 'User']); 
        config(['xra.register_pub_theme' => true]);
        config(['app.key' => 'base64:Z/I+QUCmk9w7XQogD8eDwZdO5TM2sT7JPCiji05hrn8=']);

        // Reset XotData singleton to ensure it picks up the new config
        \Modules\Xot\Datas\XotData::make()->update([
            'pub_theme' => 'Meetup',
            'main_module' => 'User',
            'register_pub_theme' => true,
        ]);

        // Unifichiamo le connessioni per usare lo stesso database in memoria condiviso.
        $dbName = 'file:memdb_'.Str::random(10).'?mode=memory&cache=shared';
        
        $connections = [
            'sqlite',
            'user',
            'xot',
            'activity',
            'geo',
            'cms',
            'notify',
            'lang',
            'tenant',
            'blog',
            'media',
        ];

        foreach ($connections as $conn) {
            $this->app['config']->set("database.connections.{$conn}.database", $dbName);
            $this->app['config']->set("database.connections.{$conn}.driver", 'sqlite');
        }

        // Purge to ensure fresh connection with new config
        foreach ($connections as $conn) {
            \Illuminate\Support\Facades\DB::purge($conn);
        }

        // Register additional providers needed for Folio/Volt
        $this->app->register(\Modules\Xot\Providers\XotServiceProvider::class);
        $this->app->register(\Modules\Tenant\Providers\TenantServiceProvider::class);
        $this->app->register(\Modules\Cms\Providers\CmsServiceProvider::class);
        $this->app->register(\Modules\Cms\Providers\FolioVoltServiceProvider::class);

        // Specific module migrations
        $this->artisan('module:migrate', ['module' => 'Xot', '--force' => true]); 
        $this->artisan('module:migrate', ['module' => 'User', '--force' => true]);
        $this->artisan('module:migrate', ['module' => 'Media', '--force' => true]);
        $this->artisan('module:migrate', ['module' => 'Tenant', '--force' => true]);
        $this->artisan('module:migrate', ['module' => 'Notify', '--force' => true]);
        $this->artisan('module:migrate', ['module' => 'Activity', '--force' => true]);
    }
}
