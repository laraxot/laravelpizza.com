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
        $n = 1;
        if (inAdmin()) {
            $n = 3;
        }

        $segment = request()->segment($n);

        if (\is_string($segment) && \in_array($segment, $langs, true)) {
            app()->setLocale($segment);
        }
    }
}
