<?php

declare(strict_types=1);

namespace Modules\Gdpr\Http\Middleware;

use Closure;
use Modules\Gdpr\Datas\GdprData;
use Statikbe\CookieConsent\CookieConsentMiddleware;

/**
 * Inietta il banner dei cookie (vista `Modules/Gdpr/resources/views/cookie-consent`) prima di </body>.
 *
 * Il flag `cookie_banner_on` e' del tenant e il tenant si conosce solo con la richiesta: valutarlo all'avvio del provider (come
 * si faceva) dipende da quale tenant e' attivo in quel momento e in un'applicazione multi-tenant e' sbagliato in principio.
 */
final class InjectCookieBanner extends CookieConsentMiddleware
{
    public function handle(mixed $request, Closure $next): mixed
    {
        if (! GdprData::make()->cookie_banner_on) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
