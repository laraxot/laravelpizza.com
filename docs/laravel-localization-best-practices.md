# LaravelLocalization - Best Practices

## Overview

This document describes the correct usage of `mcamara/laravel-localization` package following the official documentation.

## Installation & Configuration

### Middleware Registration

Register in `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
    ]);
})
```

### Config File

```php
// config/laravellocalization.php
return [
    'supportedLocales' => [
        'it' => ['name' => 'Italian', 'native' => 'italiano'],
        'en' => ['name' => 'English', 'native' => 'English'],
    ],
    'hideDefaultLocaleInURL' => false,
    'useAcceptLanguageHeader' => true,
];
```

## Route Groups

### Traditional Routes (web.php)

```php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localize']
], function () {
    Route::get('/', fn() => view('home'));
    Route::get('/about', fn() => view('about'));
});
```

### Folio Routes (Service Provider)

For Folio, the locale is set via middleware:

```php
// In FolioVoltServiceProvider
$base_middleware[] = \Modules\Cms\Http\Middleware\SetLocaleFromUrl::class;
$base_middleware[] = LocaleSessionRedirect::class;
$base_middleware[] = LaravelLocalizationRedirectFilter::class;

// Then register Folio paths
foreach ($supportedLocales as $locale) {
    Folio::path($theme_path)
        ->uri($locale)
        ->middleware(['*' => $base_middleware]);
}
```

## Helpers Reference

### Correct Methods

| Task | Correct Usage |
|------|---------------|
| Localize link | `LaravelLocalization::localizeUrl('/path')` |
| Get URL for locale | `LaravelLocalization::getLocalizedURL('en', '/path')` |
| Language switcher | `LaravelLocalization::getLocalizedURL($code, null, [], true)` |
| Current locale | `LaravelLocalization::getCurrentLocale()` |
| Supported locales | `LaravelLocalization::getSupportedLocales()` |
| Get locales keys | `array_keys(config('laravellocalization.supportedLocales'))` |

### Incorrect Usage

```php
// ❌ WRONG - Method doesn't exist
LaravelLocalization::getSupportedLocalesKeys()
LaravelLocalization::getSupportedLanguagesKeys()

// ✅ CORRECT - Get keys from config
array_keys(config('laravellocalization.supportedLocales'))
```

## Blade Templates

### Links

```blade
{{-- ✅ CORRECT --}}
<a href="{{ LaravelLocalization::localizeUrl('/events') }}">Events</a>
<a href="{{ LaravelLocalization::localizeUrl('/login') }}">Login</a>

{{-- ❌ WRONG - Hardcoded locale --}}
<a href="/it/events">Events</a>
```

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

### Forms

```blade
{{-- ✅ CORRECT - Localized action prevents POST→GET redirect --}}
<form action="{{ LaravelLocalization::localizeUrl('/login') }}" method="POST">

{{-- ❌ WRONG - Will cause MethodNotAllowedHttpException --}}
<form action="/logout" method="POST">
```

## Testing

### PHPUnit

```php
use Mcamara\LaravelLocalization\LaravelLocalization;

protected function refreshApplicationWithLocale(string $locale): void
{
    self::tearDown();
    putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale);
    self::setUp();
}

public function test_homepage_en()
{
    $this->refreshApplicationWithLocale('en');
    $response = $this->get('/en');
    $response->assertStatus(200);
}
```

### Pest

```php
function refreshApplicationWithLocale(string $locale): void
{
    test()->tearDown();
    putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale);
    test()->setUp();
}

test('homepage responds in english', function () {
    refreshApplicationWithLocale('en');
    $this->get('/en')->assertStatus(200);
});
```

## Common Issues

### POST not working
- Cause: Form action not localized, causes redirect POST→GET
- Fix: Use `LaravelLocalization::localizeUrl('/action')`

### Validation messages in wrong locale
- Cause: Form returns to default locale after redirect
- Fix: Localize form action URL

### MethodNotAllowedHttpException
- Cause: POST redirect changes to GET
- Fix: Always localize action URLs

## References

- [Official Documentation](https://github.com/mcamara/laravel-localization)
- [Laravel 11 Middleware Setup](https://github.com/mcamara/laravel-localization#register-middleware)
