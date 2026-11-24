<?php

declare(strict_types=1);

namespace Modules\Lang\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

/**
 * Provider per la registrazione delle rotte del modulo Lang.
 */
class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    /**
     * The name of the module.
     */
    public string $name = 'Lang';

    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\Lang\Http\Controllers';

    /**
     * The directory of the module.
     *
     * @SuppressWarnings("CamelCasePropertyName")
     */
    protected string $module_dir = __DIR__;

    /**
     * The namespace of the module.
     *
     * @SuppressWarnings("CamelCasePropertyName")
     */
    protected string $module_ns = __NAMESPACE__;

    /**
     * Registra le impostazioni di lingua basate sulla configurazione.
     */
    public function registerLang(): void
    {
        /** @var array<string, array<string, string>>|null $locales */
        $locales = config()->has('laravellocalization.supportedLocales')
            ? config('laravellocalization.supportedLocales')
            : null;

        if (! \is_array($locales)) {
            $locales = ['it' => ['name' => 'it'], 'en' => ['name' => 'en']];
        }

        /** @var array<string> $langs */
        $langs = array_keys($locales);

        /*
         * if (! \is_array($langs)) {
         * throw new \Exception('[.__LINE__.]['.class_basename(self::class).']');
         * }
         * \getRouteParameters();
         */
        // La lingua, quando c'e', e' **sempre** il primo segmento.
        //
        // Qui c'era `if (inAdmin()) { $n = 3; }`, cioe' «in area amministrativa
        // la lingua e' il terzo segmento». Nessuna rotta di questo progetto e'
        // fatta cosi', e il ramo si contraddiceva con `inAdmin()` stesso, che e'
        // vero quando il **secondo** segmento e' `admin` — se il secondo e'
        // `admin`, il primo e' quello che resta per la lingua, non il terzo.
        //
        // Verificato, non dedotto:
        //
        // - `Modules/Cms/app/Providers/Filament/FrontPanelProvider` dichiara
        //   `->path('{lang}/front')`: lingua al primo segmento;
        // - `XotBaseMainPanelProvider` dichiara `->path('admin')` e
        //   `XotBasePanelProvider` `->path('{modulo}/admin')`: nessuna lingua
        //   nell'URL;
        // - `mcamara/laravel-localization` e' fra le dipendenze di questo modulo
        //   ma il suo gruppo di rotte non e' applicato ne' in `bootstrap/app.php`
        //   ne' in `routes/web.php`, quindi non prefissa niente.
        //
        // Non esistendo URL con la lingua al terzo segmento, quel ramo non ha
        // mai impostato nulla: toglierlo non cambia il comportamento in
        // produzione e fa smettere al codice di dire una cosa falsa
        // (base_quaeris_fila5#234).
        $segment = request()->segment(1);


        if (\is_string($segment) && \in_array($segment, $langs, true)) {
            app()->setLocale($segment);
        }
    }
}
