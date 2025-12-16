<?php

declare(strict_types=1);

namespace Modules\Meetup\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Meetup\Actions\Event\CreateEventAction;
use Modules\Meetup\Actions\Event\UpdateEventAction;
use Modules\Meetup\Actions\Event\DeleteEventAction;
use Modules\Xot\Interfaces\Actions\IndexDataActionInterface;
use Modules\Xot\Interfaces\Actions\ShowDataActionInterface;
use Modules\Xot\Interfaces\Actions\CreateDataActionInterface;
use Modules\Xot\Interfaces\Actions\UpdateDataActionInterface;
use Modules\Xot\Interfaces\Actions\DeleteDataActionInterface;

class MeetupServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            IndexDataActionInterface::class . '.meetup.event',
            CreateEventAction::class
        );
        
        $this->app->bind(
            CreateDataActionInterface::class . '.meetup.event',
            CreateEventAction::class
        );
        
        $this->app->bind(
            UpdateDataActionInterface::class . '.meetup.event',
            UpdateEventAction::class
        );
        
        $this->app->bind(
            DeleteDataActionInterface::class . '.meetup.event',
            DeleteEventAction::class
        );
        
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../database/migrations/' => database_path('migrations'),
        ], 'migrations');
    }

    protected function registerConfig(): void
    {
        $configPath = __DIR__ . '/../../config/config.php';
        if (file_exists($configPath)) {
            $this->mergeConfigFrom(
                $configPath,
                'meetup'
            );
        }
    }

    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/meetup');

        $sourcePath = __DIR__ . '/../../resources/views';

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/meetup';
        }, \Config::get('view.paths', [])), [$sourcePath]), 'meetup');
    }

    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/meetup');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'meetup');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'meetup');
        }
    }
}