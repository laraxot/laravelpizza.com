<?php

declare(strict_types=1);

namespace Modules\Tenant\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Tenant\Actions\Config\GetTenantConfigNamesAction;
use Modules\Tenant\Providers\Filament\AdminPanelProvider;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Laravel\Module as LaravelModule;
use Override;

class TenantServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Tenant';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    #[Override]
    public function boot(): void
    {
        parent::boot();

        // Skip complex configuration during testing
        // if (! $this->app->environment('testing')) {
        $this->mergeConfigs();
        // }

        $this->registerDB();
        $this->registerMorphMap();
        $this->publishConfig();
    }

    public function publishConfig(): void
    {
        // ---
    }

    public function registerMorphMap(): void
    {
        $map = TenantService::config('morph_map');
        if (! \is_array($map)) {
            $map = [];
        }

        /** @var array<string, class-string<Model>> $typedMap */
        $typedMap = [];
        foreach ($map as $alias => $class) {
            if (is_string($alias) && is_string($class) && class_exists($class)) {
                /** @var class-string<Model> $modelClass */
                $modelClass = $class;
                $typedMap[$alias] = $modelClass;
            }
        }

        /* @var array<string, class-string<Model>> $typedMap */
        Relation::morphMap($typedMap);
    }

    public function registerDB(): void
    {
        // Skip database purge/reconnect during testing to preserve test DB mappings
        if ($this->app->environment('testing')) {
            return;
        }

        Schema::defaultStringLength(191);

        if (Request::has('act') && Request::input('act') === 'migrate') {
            DB::purge('mysql'); // Call to a member function prepare() on null
            DB::reconnect('mysql');
        }

        $raw = TenantService::config('database');



        /** @var array<string, array|float|int|string|null> $data */
        $data = is_array($raw) ? $raw : [];

        /** @var array<string, array|float|int|string|null> $connections */
        $connections = [];

        $defaultRaw = Arr::get($data, 'default', 'mysql');
        /** @var string $default */
        $default = is_string($defaultRaw) ? $defaultRaw : 'mysql';

        if (Arr::get($data, 'connections.user', null) === null) {
            Arr::set($data, 'connections.user', Arr::get($data, 'connections.user_'.$default));
        }



        /** @var array|float|int|string|null $connectionsRaw */
        $connectionsRaw = Arr::get($data, 'connections', []);
        $connections = is_array($connectionsRaw) ? $connectionsRaw : [];

        $modules = Module::getOrdered();
        foreach ($modules as $module) {
            if (! $module instanceof LaravelModule) {
                continue;
            }

            $name = $module->getSnakeName();
            // *
            if (isset($connections[$default]) && ! isset($connections[$name])) {
                // @var array|float|int|string|null $defaultConnection
                $defaultConnection = $connections[$default];
                $connections[$name] = $defaultConnection;
            }
            // */
        }

        $data = Arr::set($data, 'connections', $connections);


        Config::set('database', $data);


        // Call to a member function prepare() on null
        // Database connection [mysql] not configured.
        DB::purge('mysql');
        DB::reconnect();
    }

    #[Override]
    public function register(): void
    {
        parent::register();
        // $this->app->register(AdminPanelProvider::class);
    }

    public function mergeConfigs(): void
    {

        $configs = app(GetTenantConfigNamesAction::class)->execute();

        foreach ($configs as $config) {
            if (! is_array($config) || ! isset($config['name'])) {
                continue;
            }

            $configName = $config['name'];
            if (is_string($configName)) {
                $tmp = TenantService::config($configName);
            }
        }
    }
}
