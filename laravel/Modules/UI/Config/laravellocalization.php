<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Languages
     * |--------------------------------------------------------------------------
     * |
     * | This is the array for the languages
     * |
     */
    'languages' => [
        'it' => [
            'name' => 'Italiano',
            'script' => 'Latn',
            'native' => 'Italiano',
            'regional' => 'it_IT',
        ],
        'en' => [
            'name' => 'English',
            'script' => 'Latn',
            'native' => 'English',
            'regional' => 'en_GB',
        ],
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Language Detection
     * |--------------------------------------------------------------------------
     * |
     * | This is the configuration for the language detection
     * |
     */
    'detectBrowserLanguage' => true,
    'detectBrowserLanguageFromAcceptLanguage' => true,
    'detectBrowserLanguageFromAcceptLanguageHeader' => true,
    'detectBrowserLanguageFromSession' => true,
    'detectBrowserLanguageFromCookie' => true,
    'detectBrowserLanguageFromQueryString' => true,
    'detectBrowserLanguageFromRoute' => true,
    /*
     * |--------------------------------------------------------------------------
     * | Language Selection
     * |--------------------------------------------------------------------------
     * |
     * | This is the configuration for the language selection
     * |
     */
    'hideDefaultLocaleInURL' => false,
    'useAcceptLanguageHeader' => true,
    'useSessionLocale' => true,
    'useCookieLocale' => true,
    'useQueryStringLocale' => true,
    'useRouteLocale' => true,
    /*
     * |--------------------------------------------------------------------------
     * | Language Redirect
     * |--------------------------------------------------------------------------
     * |
     * | This is the configuration for the language redirect
     * |
     */
    'redirectToDefaultLocale' => true,
    'redirectToDefaultLocaleIfNotSupported' => true,
    'redirectToDefaultLocaleIfNotInSupportedLocales' => true,
    'redirectToDefaultLocaleIfNotInSupportedLocalesAndNotInAcceptLanguage' => true,
    'redirectToDefaultLocaleIfNotInSupportedLocalesAndNotInAcceptLanguageHeader' => true,
    'redirectToDefaultLocaleIfNotInSupportedLocalesAndNotInSession' => true,
    'redirectToDefaultLocaleIfNotInSupportedLocalesAndNotInCookie' => true,
    'redirectToDefaultLocaleIfNotInSupportedLocalesAndNotInQueryString' => true,
    'redirectToDefaultLocaleIfNotInSupportedLocalesAndNotInRoute' => true,
    /*
     * |--------------------------------------------------------------------------
     * | Language Routes
     * |--------------------------------------------------------------------------
     * |
     * | This is the configuration for the language routes
     * |
     */
    'useLocalizedRoutes' => true,
    'useLocalizedRoutesInMiddleware' => true,
    'useLocalizedRoutesInController' => true,
    'useLocalizedRoutesInView' => true,
    'useLocalizedRoutesInRedirect' => true,
    'useLocalizedRoutesInUrl' => true,
    'useLocalizedRoutesInRoute' => true,
    'useLocalizedRoutesInRouteModelBinding' => true,
    'useLocalizedRoutesInRouteModelBindingWithSlug' => true,
    'useLocalizedRoutesInRouteModelBindingWithSlugAndLocale' => true,
    'useLocalizedRoutesInRouteModelBindingWithSlugAndLocaleAndFallback' => true,
    'useLocalizedRoutesInRouteModelBindingWithSlugAndLocaleAndFallbackAndRedirect' => true,
    'useLocalizedRoutesInRouteModelBindingWithSlugAndLocaleAndFallbackAndRedirectAndSession' => true,
    'useLocalizedRoutesInRouteModelBindingWithSlugAndLocaleAndFallbackAndRedirectAndSessionAndCookie' => true,
    'useLocalizedRoutesInRouteModelBindingWithSlugAndLocaleAndFallbackAndRedirectAndSessionAndCookieAndQueryString' => true,
    'useLocalizedRoutesInRouteModelBindingWithSlugAndLocaleAndFallbackAndRedirectAndSessionAndCookieAndQueryStringAndRoute' => true,
];
