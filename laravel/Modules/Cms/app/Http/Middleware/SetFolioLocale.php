<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Middleware;

use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
    public function handle(Request $request, \Closure $next): mixed
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

        // Priority 1: If user is logged in and has a saved language, use that
        if ($request->user() && $request->user()->lang) {
            $locale = $request->user()->lang;
        // Priority 2: Check if first segment is a supported locale
        } elseif (in_array($firstSegment, $supportedLocales, true)) {
            $locale = $firstSegment;
        // Priority 3: Use default locale
        } else {
            $locale = $defaultLocale;
        }

        // CRITICAL: Set locale on BOTH app AND LaravelLocalization facade.
        // Without calling LaravelLocalization::setLocale(), helpers like
        // localizeUrl(), getLocalizedURL(), getCurrentLocale() will not
        // reflect the correct locale, causing all links to default to 'it'.
        app()->setLocale($locale);
        LaravelLocalization::setLocale($locale);

        return $next($request);
    }
}
