<?php

declare(strict_types=1);

namespace Modules\Cms\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Modules\Xot\Actions\File\FixPathAction;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Webmozart\Assert\Assert;

class CmsServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Cms';

    public XotData $xot;

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    #[\Override]
    public function boot(): void
    {
        parent::boot();

        // @var mixed xot = XotData::make(;

        if (// @var mixed xot->register_pub_theme
            // @var mixed registerNamespaces('pub_theme';

            // // @var mixed registerThemeConfig('pub_theme';
            // // @var mixed registerThemeLivewireComponents(;
        }
    }

    /**
     * Register the service provider.
     */
    #[\Override]
    public function register(): void
    {
        parent::register();

        // @var mixed xot = XotData::make(;

        // Verifica che la configurazione di LaravelLocalization sia caricata
        // NOTA: La configurazione è già gestita dal modulo Lang
        // if (!config()->has('laravellocalization.supportedLocales')) {
        //     // @var mixed mergeConfigFrom(__DIR__.'/../config/laravellocalization.php', 'laravellocalization';
        // }

        if (// @var mixed xot->register_pub_theme
            Assert::isArray($paths = config('view.paths'));
            $theme_path = app(FixPathAction::class)
                ->execute(base_path('Themes/'.// @var mixed xot->pub_theme.'/resources/views';
            $paths = array_merge([$theme_path], $paths);
            Config::set('view.paths', $paths);
            Config::set('livewire.view_path', $theme_path.'/livewire');
            Config::set('livewire.class_namespace', 'Themes\\'.// @var mixed xot->pub_theme.'\Http\Livewire';

            // // @var mixed registerFolio(;
        }
    }

    public function registerNamespaces(string $theme_type): void
    {
        $xot = // @var mixed xot;

        Assert::string($theme = $xot->{$theme_type}, __FILE__.':'.__LINE__.' - '.class_basename(self::class));
        $theme_path = 'Themes/'.$theme;
        $resource_path = $theme_path.'/resources';
        $lang_dir = app(FixPathAction::class)->execute(base_path($theme_path.'/lang'));

        $theme_dir = app(FixPathAction::class)->execute(base_path($resource_path.'/views'));
        $viewFactory = app('view');
        if (is_object($viewFactory) && method_exists($viewFactory, 'addNamespace')) {
            $viewFactory->addNamespace($theme_type, $theme_dir);
        }
        // @var mixed loadTranslationsFrom($lang_dir, $theme_type;

        $componentViewPath = app(FixPathAction::class)
            ->execute(base_path($resource_path.'/views/components'));

        Blade::anonymousComponentPath($componentViewPath);
        Blade::anonymousComponentNamespace(
            $theme_type.'::',
            app(FixPathAction::class)->execute(base_path($resource_path.'/views'))
        );
    }
}
