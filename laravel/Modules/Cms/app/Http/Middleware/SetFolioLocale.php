<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Middleware;

use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

/**
 * Middleware to set locale from URL for Folio pages.
 *
 * Priority:
 * 1. If user is logged in and has a saved lang, use that
 * 2. If URL has locale prefix, use that
 * 3. Use default locale
 */
class SetFolioLocale
{
    public function handle(Request $request, \Closure $next): Response
    {
        // Get the first segment from the URL
        $segments = $request->segments();
        $firstSegment = $segments[0] ?? '';

        // Get supported locales keys using the Facade
        try {
            /** @var array<string> $supportedLocales */
            $supportedLocales = LaravelLocalization::getSupportedLanguagesKeys();
        } catch (\Exception $e) {
            $supportedLocales = ['it', 'en'];
        }

        /** @var string $defaultLocale */
        $defaultLocale = config('app.locale', 'it');

        // Priority 1: Check if first segment is a supported locale (URL Overrides User Preference)
        if (in_array($firstSegment, $supportedLocales, true)) {
            $locale = $firstSegment;
            // Priority 2: If user is logged in and has a saved language, use that
        } else {
            // data_get legge gli attributi magici Eloquent (users.lang e' una colonna: property_exists e'
            // sempre false e questo ramo non scattava mai) e le proprieta' di uno stdClass. La lingua
            // salvata dall'utente e' libera: si applica solo se e' tra quelle supportate.
            $userLang = data_get($request->user(), 'lang');
            $locale = is_string($userLang) && in_array($userLang, $supportedLocales, true) ? $userLang : $defaultLocale;
        }

        // CRITICAL: Set locale on BOTH app AND LaravelLocalization facade.
        // Without calling LaravelLocalization::setLocale(), helpers like
        // localizeUrl(), getLocalizedURL(), getCurrentLocale() will not
        // reflect the correct locale, causing all links to default to 'it'.
        if (is_string($locale)) {
            app()->setLocale($locale);
            LaravelLocalization::setLocale($locale);
        }

        $response = $next($request);
        Assert::isInstanceOf($response, Response::class);

        return $response;
    }
}
