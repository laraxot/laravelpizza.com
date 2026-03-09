# Laravel Localization — Project Integration Guide

> Based on deep study of [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)

---

## Package Overview

`mcamara/laravel-localization` provides URL-based localization for Laravel. It sets `App::getLocale()` from the URL prefix (e.g., `/de`, `/it`, `/en`) and provides helpers for generating localized URLs.

## Project Configuration

### Config File: `config/laravellocalization.php`

```php
'supportedLocales' => [
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT'],
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    'de' => ['name' => 'German', 'script' => 'Latn', 'native' => 'Deutsch', 'regional' => 'de_DE'],
    'fr' => ['name' => 'French', 'script' => 'Latn', 'native' => 'français', 'regional' => 'fr_FR'],
    'es' => ['name' => 'Spanish', 'script' => 'Latn', 'native' => 'español', 'regional' => 'es_ES'],
    'ru' => ['name' => 'Russian', 'script' => 'Cyrl', 'native' => 'Pусский', 'regional' => 'ru_RU'],
],
'useAcceptLanguageHeader' => true,
'hideDefaultLocaleInURL' => false,
'localesOrder' => ['it', 'en', 'de', 'fr', 'es', 'ru'],
```

### Key Settings
- **`hideDefaultLocaleInURL`**: `false` — ALL locales appear in URL (e.g., `/it/events`)
- **`useAcceptLanguageHeader`**: `true` — detects browser language when no locale in URL
- **`httpMethodsIgnored`**: `['POST', 'PUT', 'PATCH', 'DELETE']` — POST requests are not redirected

### Middleware Registration: `bootstrap/app.php`

All 5 middleware aliases are registered:
- `localize` → `LaravelLocalizationRoutes` (sets locale from URL)
- `localizationRedirect` → `LaravelLocalizationRedirectFilter` (redirects when default locale is in URL)
- `localeSessionRedirect` → `LocaleSessionRedirect` (stores locale in session, redirects)
- `localeCookieRedirect` → `LocaleCookieRedirect` (stores locale in cookie, redirects)
- `localeViewPath` → `LaravelLocalizationViewPath` (sets view base path to locale)

## How Localization Works in This Project

### Folio Integration (Custom)

Since this project uses **Folio** (not traditional `web.php` routes), a custom middleware `SetFolioLocale` bridges the gap:

**File**: `Modules/Cms/app/Http/Middleware/SetFolioLocale.php`

**Priority logic**:
1. If user is logged in and has a saved `lang` → use that
2. If URL first segment is a supported locale → use that
3. Otherwise → use default locale (`it`)

**Applied via**: `app/Providers/FolioServiceProvider.php` → `Folio::path($pagesPath)->middleware(['*' => [SetFolioLocale::class]])`

### URL Structure
```
http://127.0.0.1:8000/it          → Italian homepage
http://127.0.0.1:8000/en          → English homepage
http://127.0.0.1:8000/de          → German homepage
http://127.0.0.1:8000/it/events   → Italian events page
http://127.0.0.1:8000/de/events   → German events page
```

## Key Helpers

| Helper | Purpose | Example |
|---|---|---|
| `LaravelLocalization::localizeUrl('/path')` | Add current locale prefix | `/it/path` |
| `LaravelLocalization::getLocalizedURL('en')` | Get current URL in locale | `http://site/en/events` |
| `LaravelLocalization::getCurrentLocale()` | Get current locale key | `'de'` |
| `LaravelLocalization::getCurrentLocaleName()` | Get locale name | `'German'` |
| `LaravelLocalization::getCurrentLocaleNative()` | Get native name | `'Deutsch'` |
| `LaravelLocalization::getCurrentLocaleDirection()` | Get text direction | `'ltr'` |
| `LaravelLocalization::getSupportedLocales()` | Get all locales | `['it' => [...], ...]` |
| `LaravelLocalization::getLocalesOrder()` | Get ordered locales | Custom order array |
| `LaravelLocalization::getNonLocalizedURL('/it/about')` | Strip locale | `/about` |

## Language Selector Pattern

```blade
<ul>
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <li>
        <a rel="alternate" hreflang="{{ $localeCode }}"
           href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
            {{ $properties['native'] }}
        </a>
    </li>
@endforeach
</ul>
```

## Testing with Localization (Pest)

```php
// Pest.php
use Mcamara\LaravelLocalization\LaravelLocalization;

function refreshApplicationWithLocale(string $locale): void {
    /** @var \Tests\TestCase $test */
    $test = test();
    $test->tearDown();
    putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale);
    $test->setUp();
}

pest()->afterEach(function () {
    putenv(LaravelLocalization::ENV_ROUTE_KEY);
});

// Usage in tests:
test('it can visit the German home page', function () {
    refreshApplicationWithLocale('de');
    $response = $this->get('/de');
    $response->assertStatus(200);
});
```

## Common Pitfalls
1. **POST not working**: Localize form action URLs with `LaravelLocalization::localizeUrl()`
2. **404 with route cache**: Use `php artisan route:trans:cache` instead of `route:cache`
3. **Validation messages in wrong locale**: Localize POST URLs
4. **Folio pages**: Require `SetFolioLocale` middleware, not the standard `localize` middleware
5. **Translation files**: Must exist in `lang/{locale}/` for each supported locale

## Translation Files Location

For each supported locale, translation files must exist:
```
lang/it/  → Italian translations
lang/en/  → English translations
lang/de/  → German translations
lang/fr/  → French translations
lang/es/  → Spanish translations
lang/ru/  → Russian translations
```

Also module-specific:
```
Modules/{Module}/lang/{locale}/{resource}.php
```
