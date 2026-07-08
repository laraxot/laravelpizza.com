# laravel-localization complete guide

Package: `mcamara/laravel-localization`
Repository: https://github.com/mcamara/laravel-localization

## What the package does

The package adds locale-prefixed URLs to any Laravel application. Every public
URL becomes `/{locale}/path` (e.g. `/it/events`, `/en/about`). The package
handles:

- Automatic language detection from `Accept-Language` header or session/cookie.
- Redirect of bare requests (`/events`) to the localized version (`/it/events`).
- A facade with helpers for generating localized URLs, reading the current locale
  and listing supported locales.
- Optional translated route segments (`/en/about` vs `/it/chi-siamo`).
- Route caching support for translated routes.

## Project configuration

Config file: `laravel/config/laravellocalization.php`

Current project settings:

```php
'supportedLocales' => [
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT'],
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English',  'regional' => 'en_GB'],
    'de' => ['name' => 'German',  'script' => 'Latn', 'native' => 'Deutsch',  'regional' => 'de_DE'],
    'fr' => ['name' => 'French',  'script' => 'Latn', 'native' => 'français', 'regional' => 'fr_FR'],
    'es' => ['name' => 'Spanish', 'script' => 'Latn', 'native' => 'español',  'regional' => 'es_ES'],
    'ru' => ['name' => 'Russian', 'script' => 'Cyrl', 'native' => 'Pусский',  'regional' => 'ru_RU'],
],

'useAcceptLanguageHeader' => true,   // detect locale from browser
'hideDefaultLocaleInURL'  => false,  // always show locale prefix in URL
'localesOrder'            => ['it', 'en', 'de', 'fr', 'es', 'ru'],
'localesMapping'          => [],
'httpMethodsIgnored'      => ['POST', 'PUT', 'PATCH', 'DELETE'],
```

`httpMethodsIgnored` prevents the redirect middleware from touching POST/PUT/PATCH/DELETE
requests. This is essential for form submissions (see "Form actions" section below).

## Middleware

Middleware aliases are registered in `laravel/bootstrap/app.php`:

```php
'localize'             => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
'localeSessionRedirect'=> \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
'localeCookieRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
'localeViewPath'       => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
```

### Middleware roles

| Alias | Class | Purpose |
|---|---|---|
| `localize` | `LaravelLocalizationRoutes` | Loads the locale from the URL prefix; required for `transRoute()` support. |
| `localizationRedirect` | `LaravelLocalizationRedirectFilter` | Redirects requests without a locale prefix to the correct locale URL. |
| `localeSessionRedirect` | `LocaleSessionRedirect` | Persists the chosen locale in the session between requests. |
| `localeCookieRedirect` | `LocaleCookieRedirect` | Persists the chosen locale in a cookie. |
| `localeViewPath` | `LaravelLocalizationViewPath` | Sets the view path based on locale (rarely needed). |

### How the project applies middleware

The project does not use a traditional `Route::group` with `LaravelLocalization::setLocale()`.
Instead, `FolioVoltServiceProvider` registers Folio paths with `->uri($locale)` for each
supported locale, and applies `SetFolioLocale` + `LocaleSessionRedirect` +
`LaravelLocalizationRedirectFilter` as per-page middleware:

```php
// Modules/Cms/app/Providers/FolioVoltServiceProvider.php
foreach ($supportedLocales as $locale) {
    Folio::path($theme_path)
        ->uri($locale)
        ->middleware([
            '*' => [
                SetFolioLocale::class,
                LocaleSessionRedirect::class,
                LaravelLocalizationRedirectFilter::class,
            ],
        ]);
}
```

`SetFolioLocale` middleware (`Modules/Cms/app/Http/Middleware/SetFolioLocale.php`) calls
both `app()->setLocale($locale)` and `LaravelLocalization::setLocale($locale)`. Both calls
are required. Without the second call, facade helpers such as `localizeUrl()` and
`getLocalizedURL()` do not reflect the correct locale.

## Facade methods

Import: `use Mcamara\LaravelLocalization\Facades\LaravelLocalization;`

### URL helpers

```php
// Add current locale prefix to a path. Use for all links and form actions.
// '/events' → '/it/events'  (when current locale is 'it')
LaravelLocalization::localizeUrl('/events')

// Get the current URL translated to a given locale. Pass null as second
// argument to use the current URL.
// Fourth argument true forces the locale prefix even when hideDefaultLocaleInURL=true.
LaravelLocalization::getLocalizedURL('en')                     // current URL in English
LaravelLocalization::getLocalizedURL('en', '/about')           // /about in English
LaravelLocalization::getLocalizedURL('en', null, [], true)     // force locale prefix

// Strip locale prefix from a URL.
LaravelLocalization::getNonLocalizedURL('/it/about')           // returns /about
```

### Locale information

```php
LaravelLocalization::getCurrentLocale()          // 'it' | 'en' | ...
LaravelLocalization::getCurrentLocaleName()      // 'Italian' | 'English' | ...
LaravelLocalization::getCurrentLocaleNative()    // 'italiano' | 'English' | ...
LaravelLocalization::getCurrentLocaleDirection() // 'ltr' | 'rtl'
LaravelLocalization::getSupportedLocales()       // full array keyed by locale code
LaravelLocalization::getSupportedLanguagesKeys() // ['it', 'en', 'de', ...]
LaravelLocalization::getLocalesOrder()           // localesOrder from config
```

### Translated routes (optional)

```php
// Uses lang/{locale}/routes.php translation files.
LaravelLocalization::transRoute('routes.about')
LaravelLocalization::getURLFromRouteNameTranslated('es', 'routes.about')
```

## getCurrentLocale() vs app()->getLocale()

Prefer `LaravelLocalization::getCurrentLocale()` over `app()->getLocale()` in
Blade templates and components.

`app()->getLocale()` returns the Laravel application locale. `getCurrentLocale()`
returns the locale as resolved by the package, which may differ during bootstrap
or in edge cases where only one of the two has been set. When `SetFolioLocale`
middleware is active both values agree, but using `getCurrentLocale()` is safer
and more explicit about intent.

## localizeUrl() vs getLocalizedURL()

| Method | Input | Use case |
|---|---|---|
| `localizeUrl($path)` | A path without locale prefix. | Links and form actions where you want to add the current locale. |
| `getLocalizedURL($locale, $url, $attrs, $forceDefault)` | A locale code and optionally a full URL. | Language switcher; getting the same page in a different locale. |

`localizeUrl('/login')` returns `/it/login` when the locale is `it`.
`getLocalizedURL('en', null, [], true)` returns the current URL with the `en`
prefix, regardless of `hideDefaultLocaleInURL`.

## Form actions

Because `httpMethodsIgnored` includes POST, PUT, PATCH and DELETE, the redirect
middleware will not add a locale prefix to those methods. If the form action is
not already localized, a POST to `/login` works, but the response locale and the
session locale may not match. The rule is:

- All form `action` attributes must use `LaravelLocalization::localizeUrl()`.
- This applies to login, register, logout, contact forms, feedback forms, and
  any other form that submits to a Folio or controller route.

Correct:
```blade
<form action="{{ LaravelLocalization::localizeUrl('/login') }}" method="POST">
```

Wrong:
```blade
<form action="/login" method="POST">
```

## Language switcher

The project has a language-switcher component at
`Themes/Meetup/resources/views/components/ui/language-switcher.blade.php`.

Standard implementation pattern:

```blade
@foreach(LaravelLocalization::getSupportedLocales() as $code => $properties)
    <a rel="alternate"
       hreflang="{{ $code }}"
       href="{{ LaravelLocalization::getLocalizedURL($code, null, [], true) }}"
       class="{{ LaravelLocalization::getCurrentLocale() === $code ? 'active' : '' }}">
        {{ $properties['native'] }}
    </a>
@endforeach
```

The fourth argument `true` to `getLocalizedURL` forces the locale prefix even
when `hideDefaultLocaleInURL=true`. Always pass it in the language switcher to
ensure every link works regardless of config.

## SEO: hreflang tags

For international SEO, emit hreflang link tags in the page `<head>`:

```blade
@foreach(LaravelLocalization::getSupportedLocales() as $code => $properties)
    <link rel="alternate"
          hreflang="{{ $code }}"
          href="{{ LaravelLocalization::getLocalizedURL($code, null, [], true) }}" />
@endforeach
<link rel="alternate" hreflang="x-default" href="{{ LaravelLocalization::getLocalizedURL(config('app.locale'), null, [], true) }}" />
```

The canonical URL for structured data (JSON-LD) must match the localized URL
returned by the package for the current locale.

## Folio + Volt integration

The project does not use the traditional `Route::group(['prefix' => LaravelLocalization::setLocale()])` pattern. All public pages go through Folio.

`FolioVoltServiceProvider` registers each supported locale as a separate Folio path
using `->uri($locale)`. This means a request to `/it/events` matches the Folio page
`pages/[slug].blade.php` with the `it` prefix stripped by Folio's URI matching.

`SetFolioLocale` middleware runs on every Folio page and:
1. Reads the first URL segment.
2. Checks it against `getSupportedLanguagesKeys()`.
3. Calls `app()->setLocale($locale)` and `LaravelLocalization::setLocale($locale)`.

This is the correct way to integrate the package with Folio. Do not replicate this
logic in individual Blade pages or Volt components.

## Testing

The package resolves the locale from an environment variable at bootstrap time.
In tests, set the locale before each request using the `refreshApplicationWithLocale`
helper:

```php
protected function refreshApplicationWithLocale(string $locale): void
{
    self::tearDown();
    putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale);
    self::setUp();
}
```

Clean up after each test:

```php
protected function tearDown(): void
{
    putenv(LaravelLocalization::ENV_ROUTE_KEY);
    parent::tearDown();
}
```

Always send requests with the locale prefix:

```php
$this->get('/it/');
$this->get('/en/events');
$this->post('/it/login', $credentials);
```

Without the prefix the middleware chain does not set the locale correctly and
assertions on localized content will fail.

## Edge cases

### hideDefaultLocaleInURL = false (project default)

All locale codes appear in every URL, including the default locale. This is the
safest setting and avoids ambiguity in Folio URI matching. Do not change this
without reviewing all Folio `->uri()` registrations.

### Root URL redirect

A request to `/` (no locale) is caught by `LaravelLocalizationRedirectFilter` and
redirected to `/{detected-locale}/`. The detected locale comes from (in order):
session, cookie, `Accept-Language` header (if `useAcceptLanguageHeader=true`),
then `app.locale` config.

### Locale not in supportedLocales

If a request arrives with an unrecognized locale segment (e.g. `/xx/page`), the
middleware does not match it as a locale. The `SetFolioLocale` middleware falls
back to the default locale. The URL is still served if a Folio page matches.

### POST redirect issue

When `httpMethodsIgnored` does not include POST and a form submits to a non-localized
URL, the redirect converts POST to GET (HTTP 302 redirect). The project avoids this
by always localizing form actions and by keeping POST in `httpMethodsIgnored`.

### Route caching with translated routes

Standard `php artisan route:cache` does not work with translated routes. Use the
package commands instead:

```bash
php artisan route:trans:cache
php artisan route:trans:clear
php artisan route:trans:list en
```

For the LoadsTranslatedCachedRoutes trait, add it to `RouteServiceProvider` (pre-
Laravel 11). In Laravel 11+ this is not applicable as `RouteServiceProvider` is
replaced by `bootstrap/app.php`.

## Supported locales config structure

Each locale entry has these keys:

| Key | Description | Example |
|---|---|---|
| `name` | English name | `'Italian'` |
| `script` | ISO 15924 script code | `'Latn'` |
| `native` | Native name | `'italiano'` |
| `regional` | Regional locale string | `'it_IT'` |

The `regional` value is used by some PHP locale functions and by the `utf8suffix`
config when setting `setlocale()`.

## Quick reference: what to use where

| Situation | Correct call |
|---|---|
| Link to another page | `LaravelLocalization::localizeUrl('/path')` |
| Form action | `LaravelLocalization::localizeUrl('/submit')` |
| Language switcher href | `LaravelLocalization::getLocalizedURL($code, null, [], true)` |
| Current locale string | `LaravelLocalization::getCurrentLocale()` |
| Check if locale is active | `LaravelLocalization::getCurrentLocale() === $code` |
| Hreflang tags | `LaravelLocalization::getLocalizedURL($code, null, [], true)` |
| JSON-LD canonical URL | `LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), null, [], true)` |
| All supported locales | `LaravelLocalization::getSupportedLocales()` |
| Locale keys only | `LaravelLocalization::getSupportedLanguagesKeys()` |

## Files in this project

| File | Purpose |
|---|---|
| `laravel/config/laravellocalization.php` | Package configuration |
| `laravel/bootstrap/app.php` | Middleware alias registration |
| `laravel/Modules/Cms/app/Providers/FolioVoltServiceProvider.php` | Folio + locale URI registration |
| `laravel/Modules/Cms/app/Http/Middleware/SetFolioLocale.php` | Per-request locale resolution for Folio |
| `laravel/Themes/Meetup/resources/views/components/ui/language-switcher.blade.php` | Language switcher component |
