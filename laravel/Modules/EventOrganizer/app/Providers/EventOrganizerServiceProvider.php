<?php

namespace Modules\EventOrganizer\Providers;

use Illuminate\Support\ServiceProvider;

class EventOrganizerServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'EventOrganizer';

    protected string $moduleNameLower = 'eventorganizer';

    public function register(): void
    {
        $this->loadTranslationsFrom(module_path($this->moduleName, 'lang'), $this->moduleNameLower);
        $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'lang'));
        $this->loadRoutesFrom(module_path($this->moduleName, 'routes/web.php'));
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
    }

    public function boot(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->publishes([
            module_path($this->moduleName, 'lang') => resource_path('lang/vendor/' . $this->moduleNameLower),
        ], 'lang');
        $this->publishes([
            module_path($this->moduleName, 'database/migrations') => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $this->moduleNameLower),
        ], 'migrations');
        $this->publishes([
            module_path($this->moduleName, 'resources/views') => resource_path('views/vendor/' . $this->moduleNameLower),
        ], 'views');
        $this->publishes([
            module_path($this->moduleName, 'resources/public') => public_path('modules/' . $this->moduleNameLower),
        ], 'public');
    }

    protected function getPublishableFiles(): array
    {
        return [
            'config' => module_path($this->moduleName, 'config/config.php'),
            'lang' => module_path($this->moduleName, 'lang'),
            'migrations' => module_path($this->moduleName, 'database/migrations'),
            'views' => module_path($this->moduleName, 'resources/views'),
            'public' => module_path($this->moduleName, 'resources/public'),
        ];
    }
}