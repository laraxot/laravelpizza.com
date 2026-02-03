<?php

declare(strict_types=1);

namespace Modules\Cms\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Laravel\Folio\Folio;
use Livewire\Volt\Volt;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Datas\XotData;
use Nwidart\Modules\Facades\Module;
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
            if (app()->runningInConsole()) {
                // Durante il bootstrap dei comandi artisan, potrebbe esserci un problema
                // con la risoluzione di "env" come classe. Usiamo array vuoto come fallback.
                $base_middleware = [];
            } else {
                $middleware = TenantService::config('middleware');
                if (is_array($middleware)) {
                    $base_middleware = Arr::get($middleware, 'base', []);
                    if (! is_array($base_middleware)) {
                        $base_middleware = [];
                    }
                }
            }
        } catch (\Exception $e) {
            // Se c'è un errore nel caricamento della configurazione middleware, usa array vuoto
            // Questo evita errori durante il bootstrap quando la configurazione non è disponibile
            $base_middleware = [];
        }

        // $base_middleware[]=\Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class;
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
        $defaultLocale = config('app.locale', 'it');

        /**
         * @var Collection<int, \Nwidart\Modules\Module> $modules
         */
        $modules = Module::all();
        $paths = [];

        // Verifica che il percorso tema esista e sia una directory prima di passarlo a Folio
        if (File::exists($theme_path) && File::isDirectory($theme_path)) {
            // Registra Folio per ogni lingua supportata
            foreach ($supportedLocales as $locale) {
                Folio::path($theme_path)
                    ->uri($locale)
                    ->middleware([
                        '*' => array_merge($base_middleware, [
                            function ($request, callable $next) use ($locale) {
                                app()->setLocale($locale);

                                return $next($request);
                            },
                        ]),
                    ]);
            }
            $paths[] = $theme_path;
        }

        foreach ($modules as $module) {
            $path = $module->getPath().'/resources/views/pages';
            if (! File::exists($path) || ! File::isDirectory($path)) {
                continue;
            }
            $paths[] = $path;
            // Registra Folio per ogni lingua supportata
            foreach ($supportedLocales as $locale) {
                Folio::path($path)
                    ->uri($locale)
                    ->middleware([
                        '*' => array_merge($base_middleware, [
                            function ($request, callable $next) use ($locale) {
                                app()->setLocale($locale);

                                return $next($request);
                            },
                        ]),
                    ]);
            }
        }

        if (! empty($paths)) {
            Volt::mount($paths);
        }
    }
}
