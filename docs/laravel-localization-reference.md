# Laravel Localization Reference

## Overview

This document provides the complete reference for `mcamara/laravel-localization` package (v2.x) used in the LaravelPizza project.

## Installation

```bash
composer require mcamara/laravel-localization
```

## Configuration

Publish config:
```bash
php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
```

### Available Options (config/laravellocalization.php)

- **supportedLocales** - Languages supported by the app
- **useAcceptLanguageHeader** - Auto-detect language from browser
- **hideDefaultLocaleInURL** - Hide default locale in URL
- **localesOrder** - Sort languages in custom order
- **localesMapping** - Rename URL locales
- **urlsIgnored** - URLs to ignore
- **httpMethodsIgnored** - HTTP methods to ignore

## Middleware Registration (Laravel 11+)

In `bootstrap/app.php`:

```php
return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
        ]);
    })
```

## Available Methods

### Getting Locale Information

| Method | Returns | Description |
|--------|---------|-------------|
| `getSupportedLocales()` | `array` | All supported locales with properties |
| `getSupportedLanguagesKeys()` | `array` | Array of locale keys only |
| `getLocalesOrder()` | `array` | Supported locales in custom order |
| `getCurrentLocale()` | `string` | Current locale key |
| `getCurrentLocaleName()` | `string` | Current locale English name |
| `getCurrentLocaleNative()` | `string` | Current locale native name |
| `getCurrentLocaleRegional()` | `string` | Current locale regional code |
| `getCurrentLocaleDirection()` | `string` | Current locale direction (ltr/rtl) |
| `getCurrentLocaleScript()` | `string` | Current locale script (Latn, Cyrl, etc.) |

### URL Generation

| Method | Usage |
|--------|-------|
| `getLocalizedURL($locale, $url)` | Get URL for specific locale |
| `getLocalizedURL($locale, null, [], true)` | Get current page in different locale |
| `localizeUrl($path)` | Get localized path in current locale |
| `getNonLocalizedURL($path)` | Get URL without locale prefix |
| `getURLFromRouteNameTranslated($locale, $routeName, $attributes)` | Get translated route |

### Setting Locale

| Method | Usage |
|--------|-------|
| `setLocale($locale)` | Set application locale |

## Usage Examples

### Language Selector

```blade
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
       rel="alternate"
       hreflang="{{ $localeCode }}">
        {{ $properties['native'] }}
    </a>
@endforeach
```

### Localized Links

```blade
{{-- Link to specific page in current locale --}}
<a href="{{ LaravelLocalization::localizeUrl('/about') }}">About</a>

{{-- Link to specific page in different locale --}}
<a href="{{ LaravelLocalization::getLocalizedURL('en', '/about') }}">About (EN)</a>

{{-- Keep current page, switch language --}}
<a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">English</a>
```

### Route Model Binding with Translated Routes

Create `lang/{locale}/routes.php`:

```php
// lang/en/routes.php
return [
    'about' => 'about',
    'events' => 'events/{event}',
];

// lang/it/routes.php
return [
    'about' => 'chi-siamo',
    'events' => 'eventi/{event}',
];
```

Use in routes:

```php
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localize']], function () {
    Route::get(LaravelLocalization::transRoute('routes.about'), fn () => view('about'));
});
```

## Testing

For tests, set locale manually:

```php
// PHPUnit
protected function refreshApplicationWithLocale(string $locale): void
{
    self::tearDown();
    putenv(\Mcamara\LaravelLocalization\LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale);
    self::setUp();
}

// Pest
function refreshApplicationWithLocale(string $locale): void
{
    putenv(\Mcamara\LaravelLocalization\LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale);
}
```

## Route Caching

This package requires special caching commands:

```bash
# Cache localized routes
php artisan route:trans:cache

# Clear cache
php artisan route:trans:clear

# List routes for locale
php artisan route:trans:list en
```

## Common Issues

### POST Not Working
Always localize action URLs in forms:
```blade
<form action="{{ LaravelLocalization::localizeUrl('/logout') }}" method="POST">
```

### Validation Messages in Wrong Locale
Same issue - localize POST URLs to prevent redirects that change locale.

## References

- [Official Documentation](https://github.com/mcamara/laravel-localization)
- [Laravel 12 Compatibility](#laravel-compatibility)
