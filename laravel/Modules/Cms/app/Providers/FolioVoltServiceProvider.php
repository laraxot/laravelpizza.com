<?php

declare(strict_types=1);

namespace Modules\Cms\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Laravel\Folio\Folio;
use Laravel\Folio\FolioRoutes;
use Livewire\Volt\Volt;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Modules\Cms\Http\Middleware\SetFolioLocale;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Xot\Datas\XotData;
use Nwidart\Modules\Facades\Module;

use function Safe\preg_replace;
use function Safe\realpath;

use Webmozart\Assert\Assert;

class FolioVoltServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Folio registra una rotta catch-all marcata `fallback`. Laravel, fra piu'
        // fallback, sceglie la PRIMA registrata. Filament marca come fallback la
        // home di un pannello con multi-tenancy (`/{panelPath}/{tenant}`, vedi
        // Filament\Pages\Concerns\HasRoutes): se Folio si registra prima, la home
        // di ogni pannello multi-tenant risponde 404 perche' la catch-all di Folio
        // la precede. Rimandando la registrazione a container gia' avviato, la
        // fallback di Folio finisce in coda e resta l'ultima risorsa, che e' il
        // suo ruolo.
        $this->app->booted(function (): void {
            $this->registerFolioPaths();
        });
    }

    /**
     * Le pagine Folio sono montate una volta per lingua con lo stesso nome di rotta e FolioRoutes tiene
     * l'ultima (`it`): `route('container0.view')` rimandava a `/it/...` anche da `/de` (DCP-123).
     * Il resolver di Folio viene sostituito da uno che sposta il prefisso sulla lingua corrente.
     *
     * @param  list<string>  $supportedLocales
     */
    protected function localizeFolioNamedRoutes(array $supportedLocales): void
    {
        $localePrefix = '#^((?:https?://[^/]+)?)/(?:'.implode('|', array_map(preg_quote(...), $supportedLocales)).')(?=[/?\#]|$)#';

        URL::resolveMissingNamedRoutesUsing(
            static function (string $name, array $parameters, bool $absolute) use ($localePrefix): ?string {
                $routes = app(FolioRoutes::class);

                return $routes->has($name)
                    ? preg_replace($localePrefix, '${1}/'.app()->getLocale(), $routes->get($name, $parameters, $absolute), 1)
                    : null;
            }
        );
    }

    /**
     * Registra i path Folio del tema e dei moduli, e monta i componenti Volt.
     */
    protected function registerFolioPaths(): void
    {
        /*
         * Folio::path(resource_path('views/pages'))->middleware([
         * '*' => [
         * //
         * ],
         * ]);
         */
        // Gestione sicura della configurazione middleware per evitare errori durante bootstrap
        $base_middleware = [];
        try {
            // Verifica se siamo in ambiente console e se il problema "env" è presente
            // In questo caso, usa array vuoto per permettere al server di partire
            if (app()->runningInConsole() && ! app()->environment('testing')) {
                // Durante il bootstrap dei comandi artisan, potrebbe esserci un problema
                // con la risoluzione di "env" come classe. Usiamo array vuoto come fallback.
                $base_middleware = [];
            } else {
                $middleware = app(ResolveTenantConfigValueAction::class)->execute('middleware');
                if (is_array($middleware)) {
                    $base_middleware = Arr::get($middleware, 'base', []);
                    if (! is_array($base_middleware)) {
                        $base_middleware = [];
                    }
                }
            }

            // Assicuriamoci che 'web' sia presente se non siamo in console (o siamo in testing)
            if (! \in_array('web', $base_middleware, true)) {
                array_unshift($base_middleware, 'web');
            }
        } catch (\Exception $e) {
            // Se c'è un errore nel caricamento della configurazione middleware, usa array vuoto
            // Questo evita errori durante il bootstrap quando la configurazione non è disponibile
            $base_middleware = [];
        }

        $base_middleware[] = LaravelLocalizationRoutes::class;
        $base_middleware[] = LocaleSessionRedirect::class;
        $base_middleware[] = LaravelLocalizationRedirectFilter::class;
        // $base_middleware[]=\Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class;
        // $base_middleware[]=\Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class;

        $theme_path = XotData::make()->getPubThemeViewPath('pages');

        // Ottieni tutte le lingue supportate
        $supportedLocalesConfig = config('laravellocalization.supportedLocales', ['it' => []]);
        Assert::isArray($supportedLocalesConfig);
        /** @var array<string, mixed> $supportedLocalesConfig */
        $supportedLocales = array_map('strval', array_keys($supportedLocalesConfig));

        /**
         * @var Collection<int, \Nwidart\Modules\Module> $modules
         */
        $modules = Module::all();
        $paths = [];

        // Verifica che il percorso tema esista e sia una directory prima di passarlo a Folio
        if (File::exists($theme_path) && File::isDirectory($theme_path)) {
            foreach ($supportedLocales as $locale) {
                Folio::path($theme_path)
                    ->uri($locale)
                    ->middleware([
                        '*' => [
                            SetFolioLocale::class,
                            ...$base_middleware,
                        ],
                    ]);
            }
            $paths[] = $theme_path;
        }

        // Theme Livewire block components: livewire/ → blocks.events.detail, components/blocks → events.detail
        $theme_views = \dirname($theme_path);
        $theme_livewire = $theme_views.\DIRECTORY_SEPARATOR.'livewire';
        if (File::exists($theme_livewire) && File::isDirectory($theme_livewire)) {
            $paths[] = realpath($theme_livewire);
        }
        $theme_components_blocks = $theme_views.\DIRECTORY_SEPARATOR.'components'.\DIRECTORY_SEPARATOR.'blocks';
        if (File::exists($theme_components_blocks) && File::isDirectory($theme_components_blocks)) {
            $paths[] = realpath($theme_components_blocks);
        }

        foreach ($modules as $module) {
            $path = $module->getPath().'/resources/views/pages';
            if (! File::exists($path) || ! File::isDirectory($path)) {
                continue;
            }

            $apiPath = $path.'/api';
            if (File::exists($apiPath) && File::isDirectory($apiPath)) {
                Folio::path($apiPath)
                    ->uri('/api')
                    ->middleware([
                        '*' => ['web'],
                    ]);
            }

            $paths[] = $path;
            foreach ($supportedLocales as $locale) {
                Folio::path($path)
                    ->uri($locale)
                    ->middleware([
                        '*' => [
                            SetFolioLocale::class,
                            ...$base_middleware,
                        ],
                    ]);
            }
        }

        $this->localizeFolioNamedRoutes($supportedLocales);

        if (! empty($paths)) {
            Volt::mount($paths);
        }
    }
}
