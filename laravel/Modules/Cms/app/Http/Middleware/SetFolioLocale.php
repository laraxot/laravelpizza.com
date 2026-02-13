<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Middleware;

use Closure;
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
    public function handle(Request $request, Closure $next): mixed
    {
        // Priority 1: If user is logged in and has a saved language, use that
        if ($request->user() && $request->user()->lang) {
            $userLocale = $request->user()->lang;
            app()->setLocale($userLocale);
            LaravelLocalization::setLocale($userLocale);
            
            return $next($request);
        }
        
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