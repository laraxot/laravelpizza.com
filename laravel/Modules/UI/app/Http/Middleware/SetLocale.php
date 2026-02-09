<?php

declare(strict_types=1);

namespace Modules\UI\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

final class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * Locale detection priority:
     * 1. URL prefix (e.g., /en/events → 'en') - source of truth
     * 2. Session (persisted from previous request)
     * 3. Config default (app.locale)
     */
    public function handle(Request $request, \Closure $next): Response
    {
        $supportedLocales = config('laravellocalization.supportedLocales', []);
        $supportedKeys = is_array($supportedLocales) ? array_map('strval', array_keys($supportedLocales)) : [];

        // 1. Detect locale from URL prefix (most reliable in Folio context)
        $segments = $request->segments();
        $urlLocale = $segments[0] ?? null;

        if (is_string($urlLocale) && in_array($urlLocale, $supportedKeys, true)) {
            $locale = $urlLocale;
            Session::put('locale', $locale);
        } else {
            // 2. Fall back to session
            $locale = Session::get('locale');
            if (! is_string($locale) || ! in_array($locale, $supportedKeys, true)) {
                // 3. Fall back to config default
                $locale = Config::string('app.locale');
            }
        }

        App::setLocale($locale);

        $response = $next($request);
        if (! $response instanceof Response) {
            throw new \RuntimeException('Middleware must return a Response instance');
        }

        return $response;
    }
}
