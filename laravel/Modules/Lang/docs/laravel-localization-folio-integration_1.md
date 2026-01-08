# Integration of Mcamara Laravel Localization with Laravel Folio

## Overview
In the `saluteora` project, providing a multi-language experience with localized URLs is essential for accessibility and SEO. This document explores the integration between [`mcamara/laravel-localization`](https://github.com/mcamara/laravel-localization) and [`laravel/folio`](https://github.com/laravel/folio), ensuring that our page routing system supports language prefixes and locale-specific content in a healthcare context.
1. **Consistent Locale Prefix**: Always show the locale in URLs (`hideDefaultLocaleInURL = false`) to maintain clarity, especially important in healthcare contexts where users must be certain of the language they're viewing.
2. **Custom Middleware**: Use the `HandleFolioLocalization` middleware approach to handle locale prefixes without altering Folio's core functionality.
3. **Localized Content**: Ensure content within Folio pages is fetched based on `app()->getLocale()` to display language-specific data.
4. **SEO Considerations**: Leverage `laravel-localization`'s ability to generate hreflang tags in Folio pages for better international SEO:
    ```php
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <link rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, route('about', [], false)) }}" />
    @endforeach
    ```
5. **Testing**: Test navigation across languages to ensure URLs maintain the correct locale prefix and content matches the selected language.

## Potential Pitfalls and Solutions
- **Pitfall**: Folio pages not recognizing locale prefixes, leading to 404 errors.
  - **Solution**: Ensure the custom middleware correctly adjusts the request path before Folio processes it.
- **Pitfall**: Language switcher redirecting to incorrect URLs for Folio pages.
  - **Solution**: Use `LaravelLocalization::getLocalizedURL()` for accurate redirection.
- **Pitfall**: Performance impact from multiple middleware layers.
  - **Solution**: Optimize middleware execution and cache locale settings where possible.

## Conclusion

