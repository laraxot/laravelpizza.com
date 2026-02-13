<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Middleware to set locale from URL for Folio pages.
 *
 * Laravel Localization doesn't integrate well with Folio's routing system.
 * This middleware manually extracts the locale from the first URL segment
 * and sets it for the application.
 */
class SetFolioLocale
{
    public function handle(Request $request, Closure $next): mixed
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

        // Check if first segment is a supported locale
        if (in_array($firstSegment, $supportedLocales, true)) {
            app()->setLocale($firstSegment);
        } else {
            // Use default locale if first segment is not a locale
            app()->setLocale($defaultLocale);
        }

        return $next($request);
    }
}