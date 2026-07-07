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
use Modules\Tenant\Services\Config\ConfigStringKeyFilter;
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

        Relation::morphMap($this->buildMorphMap($map));
    }

    public function registerDB(): void
    {
        Schema::defaultStringLength(191);

        $preMergeDefaultConn = $this->resolveDefaultConnectionName();
        $this->purgeConnectionWhenMigrating($preMergeDefaultConn);

        /** @var array<string, mixed> $data */
        $data = $this->loadTenantDatabaseConfig($preMergeDefaultConn);
        $data = Arr::set($data, 'connections', $this->mergeModuleConnections($data, $preMergeDefaultConn));

        Config::set('database', $data);
        $this->reconnectDatabaseUnlessTesting();
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
                TenantService::config($configName);
            }
        }
    }

    private function resolveDefaultConnectionName(): string
    {
        $preMergeDefaultRaw = Config::get('database.default');

        return \is_string($preMergeDefaultRaw) && $preMergeDefaultRaw !== '' ? $preMergeDefaultRaw : 'mysql';
    }

    private function purgeConnectionWhenMigrating(string $connectionName): void
    {
        if (Request::has('act') && Request::input('act') === 'migrate') {
            DB::purge($connectionName);
            DB::reconnect($connectionName);
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function loadTenantDatabaseConfig(string $preMergeDefaultConn): array
    {
        $raw = TenantService::config('database');
        /** @var array<string, mixed> $data */
        $data = is_array($raw) ? $raw : [];

        $defaultRaw = Arr::get($data, 'default', $preMergeDefaultConn);
        $default = is_string($defaultRaw) ? $defaultRaw : 'mysql';
        $data = Arr::set($data, 'default', $default);

        if (Arr::get($data, 'connections.user', null) === null) {
            Arr::set($data, 'connections.user', Arr::get($data, 'connections.user_'.$default));
        }

        return ConfigStringKeyFilter::onlyStringKeys($data);
    }

    /**
     * @param  array<string, mixed>  $data
     *
     * @return array<string, mixed>
     */
    private function mergeModuleConnections(array $data, string $defaultConnection): array
    {
        /** @var array<string, mixed> $connectionsRaw */
        $connectionsRaw = Arr::get($data, 'connections', []);
        /** @var array<string, mixed> $connections */
        $connections = is_array($connectionsRaw) ? $connectionsRaw : [];

        foreach (Module::getOrdered() as $module) {
            if (! $module instanceof LaravelModule) {
                continue;
            }

            $name = $module->getSnakeName();
            if (isset($connections[$defaultConnection]) && ! isset($connections[$name])) {
                /** @var array<string, mixed> $moduleConfig */
                $moduleConfig = $connections[$defaultConnection];
                $connections[$name] = $moduleConfig;
            }
        }

        return $connections;
    }

    private function reconnectDatabaseUnlessTesting(): void
    {
        if ($this->app->environment('testing')) {
            return;
        }

        $purgeConnRaw = Config::get('database.default');
        $purgeConnName = \is_string($purgeConnRaw) && $purgeConnRaw !== '' ? $purgeConnRaw : 'mysql';
        DB::purge($purgeConnName);
        DB::reconnect();
    }

    /**
     * @param  array<mixed, mixed>  $map
     *
     * @return array<string, class-string<Model>>
     */
    private function buildMorphMap(array $map): array
    {
        /** @var array<string, class-string<Model>> $typedMap */
        $typedMap = [];

        foreach ($map as $alias => $class) {
            if (! is_string($alias) || ! is_string($class) || ! class_exists($class)) {
                continue;
            }

            /** @var class-string<Model> $modelClass */
            $modelClass = $class;
            $typedMap[$alias] = $modelClass;
        }

        return $typedMap;
    }
}
