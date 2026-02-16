<?php

declare(strict_types=1);

namespace Modules\Gdpr\Providers;

use Illuminate\Routing\Router;
use Modules\Gdpr\Datas\GdprData;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Statikbe\CookieConsent\CookieConsentMiddleware;

class GdprServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Gdpr';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    #[\Override]
    public function boot(): void
    {
        parent::boot();

        // Load translations for both cookie-consent and gdpr namespaces
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'cookie-consent');
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'gdpr');

        $router = app('router');
        $this->registerMyMiddleware($router);
    }

    public function registerMyMiddleware(Router $router): void
    {
        $gdpr = GdprData::make();
        if ($gdpr->cookie_banner_on) {
            $router->pushMiddlewareToGroup('web', CookieConsentMiddleware::class);
        }
    }
}
