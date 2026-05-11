<?php

declare(strict_types=1);

namespace Modules\Xot\Providers;

use BladeUI\Icons\Exceptions\SvgNotFound;
use BladeUI\Icons\Factory as BladeIconsFactory;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Modules\Xot\Actions\Blade\RegisterBladeComponentsAction;
use Modules\Xot\Actions\File\GetComponentsAction;
use Modules\Xot\Actions\Livewire\RegisterLivewireComponentsAction;
use Modules\Xot\Actions\Module\GetModulePathByGeneratorAction;
use Nwidart\Modules\Traits\PathNamespace;
use Webmozart\Assert\Assert;

/**
 * Class XotBaseServiceProvider.
 */
abstract class XotBaseServiceProvider extends ServiceProvider
{
    use PathNamespace;

    public string $name = '';

    public string $nameLower = '';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    protected string $module_base_ns;

    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom($this->module_dir.'/../../database/migrations');
        $this->registerLivewireComponents();
        $this->registerBladeComponents();
        $this->registerCommands();
    }

    public function register(): void
    {
        $this->nameLower = Str::lower($this->name);
        $this->module_ns = collect(explode('\\', $this->module_ns))->slice(0, -1)->implode('\\');
        $this->app->register($this->module_ns.'\Providers\RouteServiceProvider');
        $this->app->register($this->module_ns.'\Providers\EventServiceProvider');
        $this->registerBladeIcons();
    }

    public function registerBladeIcons(): void
    {
        if ('' === $this->name) {
            throw new \Exception('name is empty on ['.static::class.']');
        }

        // Blade UI Kit default set may already contain prefixes like "geo".
        // Skip registration if the prefix would collide with the default set.
        $this->callAfterResolving(BladeIconsFactory::class, function (BladeIconsFactory $factory): void {
            try {
                $assetsPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'assets');
                $svgPath = $assetsPath.'/../svg';
                if (! File::exists($svgPath)) {
                    return;
                }
                // Check if prefix already registered to avoid collision with default set.
                try {
                    $factory->svg($this->nameLower.'::non-existent-test');
                } catch (SvgNotFound $e) {
                    // Prefix not registered yet — safe to add.
                    $factory->add($this->nameLower, ['path' => $svgPath, 'prefix' => $this->nameLower]);
                }
            } catch (\Throwable $e) {
                // Ignore missing optional assets.
            }
        });
    }

    public function registerViews(): void
    {
        if ('' === $this->name) {
            throw new \Exception('name is empty on ['.static::class.']');
        }

        $viewPath = module_path($this->name, 'resources/views');
        $this->loadViewsFrom($viewPath, $this->nameLower);
    }

    public function registerTranslations(): void
    {
        if ('' === $this->name) {
            throw new \Exception('name is empty on ['.static::class.']');
        }

        $langPath = $this->getLangPath();
        $this->loadTranslationsFrom($langPath, $this->nameLower);
        $this->loadJsonTranslationsFrom($langPath);
    }

    public function registerFactories(): void
    {
        if (! app()->environment('production')) {
            // app(Factory::class)->load($this->module_dir.'/../Database/factories');
        }
    }

    public function registerBladeComponents(): void
    {
        $componentViewPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'component-view');

        try {
            Blade::anonymousComponentPath($componentViewPath);
        } catch (\Exception $e) {
            // Ignore invalid or unavailable anonymous component paths.
        }

        $componentClassPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'component-class');

        $namespace = $this->module_ns.'\View\Components';
        Blade::componentNamespace($namespace, $this->nameLower);

        app(RegisterBladeComponentsAction::class)->execute($componentClassPath, $this->module_ns);
    }

    public function registerLivewireComponents(): void
    {
        $prefix = '';
        app(RegisterLivewireComponentsAction::class)
            ->execute($this->module_dir.'/../Http/Livewire', Str::before($this->module_ns, '\Providers'), $prefix);
    }

    public function registerCommands(): void
    {
        $prefix = '';

        $comps = app(GetComponentsAction::class)
            ->execute(
                $this->module_dir.'/../Console/Commands',
                'Modules\\'.$this->name.'\\Console\\Commands',
                $prefix,
            );
        if (0 === $comps->count()) {
            return;
        }
        $commands = $comps->toArray();
        /** @var array<int, array{ns: string}> $commands */
        $commands = array_map(static function (mixed $item): string {
            Assert::isArray($item);
            Assert::keyExists($item, 'ns');
            Assert::string($item['ns'], __FILE__.':'.__LINE__.' - '.class_basename(self::class));

            return $item['ns'];
        }, $commands);
        $this->commands($commands);
    }

    public function provides(): array
    {
        return [];
    }

    protected function getLangPath(): string
    {
        try {
            return app(GetModulePathByGeneratorAction::class)->execute($this->name, 'lang');
        } catch (\Throwable $e) {
            return base_path('Modules/'.$this->name.'/lang');
        }
    }

    protected function registerConfig(): void
    {
        try {
            $configPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'config');
            $files = File::glob($configPath.'/*.php');

            foreach ($files as $file) {
                if (! is_string($file)) {
                    continue;
                }

                $filename = pathinfo($file, PATHINFO_FILENAME);
                Config::set($this->nameLower.'.'.$filename, require $file);
            }
        } catch (\Throwable $e) {
            // Ignore config registration failures for optional module config.
        }
    }
}
