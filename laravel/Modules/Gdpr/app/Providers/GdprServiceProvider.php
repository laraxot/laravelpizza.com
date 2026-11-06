<?php

declare(strict_types=1);

namespace Modules\Gdpr\Providers;

use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;
use Illuminate\Translation\Translator;
use Modules\Gdpr\Http\Middleware\InjectCookieBanner;
use Modules\Xot\Providers\XotBaseServiceProvider;

use function Safe\realpath;

class GdprServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Gdpr';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    #[\Override]
    public function boot(): void
    {
        parent::boot();

        // cookie-consent namespace: not covered by XotBaseServiceProvider (loads only module nameLower).
        // Per le traduzioni vince l'ultimo namespace registrato e statikbe/laravel-cookie-consent registra il suo (solo en, es, fr, nl, oc) dopo
        // questo provider: a boot concluso il namespace del modulo (it, en, de, es) torna a prevalere. Senza, in /it il banner mostrava le chiavi.
        $cookieConsentLangPath = realpath(__DIR__.'/../../lang/cookie-consent');
        if ($cookieConsentLangPath && is_dir($cookieConsentLangPath)) {
            $this->app->booted(function () use ($cookieConsentLangPath): void {
                $this->loadTranslationsFrom($cookieConsentLangPath, 'cookie-consent');
                $translator = $this->app->make(Translator::class);
                foreach (['it', 'en', 'de', 'es'] as $locale) {
                    $file = $cookieConsentLangPath.'/'.$locale.'/texts.php';
                    if (is_file($file)) {
                        /** @var array<string, string> $lines */
                        $lines = require $file;
                        $translator->addLines(
                            array_combine(array_map(static fn (string $key): string => 'texts.'.$key, array_keys($lines)), array_values($lines)),
                            $locale,
                            'cookie-consent',
                        );
                    }
                }
            });
        }

        // La vista del banner e' del modulo (DCP-153): prependNamespace la fa prevalere su quella di statikbe/laravel-cookie-consent.
        $cookieViewPath = realpath(__DIR__.'/../../resources/views/cookie-consent');
        if ($cookieViewPath) {
            View::prependNamespace('cookie-consent', $cookieViewPath);
        }

        $router = app('router');
        $this->registerMyMiddleware($router);
    }

    public function registerMyMiddleware(Router $router): void
    {
        // Sempre registrato: il flag `cookie_banner_on` del tenant lo valuta il middleware a ogni richiesta (InjectCookieBanner).
        // Sul kernel e non solo sul router: il kernel risincronizza i gruppi sul router e un push fatto solo sul router puo' andare perso.
        $kernel = $this->app->make(HttpKernel::class);
        if ($kernel instanceof Kernel) {
            $kernel->appendMiddlewareToGroup('web', InjectCookieBanner::class);

            return;
        }
        $router->pushMiddlewareToGroup('web', InjectCookieBanner::class);
    }
}
