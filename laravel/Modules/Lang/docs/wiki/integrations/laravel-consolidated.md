---
qmd: "laravel consolidated"
issues: []
discussions: []
title: "laravel: Consolidated Documentation"
module: lang
type: integration
tags: [integrations, modules, lang]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# laravel: Consolidated Documentation

Consolidated from **23** individual files.

## Table of Contents

- [---](#laravel-13-upgrade)
- [---](#laravel-localization-best-practices)
- [---](#laravel-localization-complete-guide)
- [---](#laravel-localization-complete)
- [---](#laravel-localization-consolidated)
- [---](#laravel-localization-folio-integration)
- [---](#laravel-localization-folio)
- [---](#laravel-localization-implementation)
- [---](#laravel-localization-integration)
- [---](#laravel-localization-livewire-volt)
- [---](#laravel-localization-mcaa-reference)
- [---](#laravel-localization-mcamara-reference)
- [---](#laravel-localization-reference)
- [---](#laravel-localization-usage)
- [---](#laravel-localization)
- [---](#laravel_localization)
- [---](#laravel_localization_complete)
- [---](#laravel_localization_folio)
- [---](#laravel_localization_folio_integration)
- [---](#laravel_localization_implementation)
- [---](#laravel_localization_integration)
- [---](#laravel_localization_livewire_volt)
- [---](#laravel_localization_usage)

---

## laravel-13-upgrade

*Consolidated from: `laravel-13-upgrade.md`*

title: "Upgrade Laravel 13 - Lang 🐄✨"
module: "Lang"
type: concept
tags: [migrazione, filament, 4]
created: 2026-07-14
updated: 2026-07-14
qmd: "migrazione filament 4"
related:
  - "./italian-text-refined-audit-report.md"
---
# Upgrade Laravel 13 - Lang 🐄✨

## 🎯 Visione Architetturale
L'upgrade a Laravel 13 per il modulo **Lang** non è un mero aggiornamento tecnico, ma un atto di purificazione zen. Seguendo i dettami della **Super Mucca**, ogni riga di codice è stata meditata per raggiungere la massima indipendenza.

## 🧘 Principi Applicati
1.  **Isolamento (SOLID)**: Il modulo dichiara ora esplicitamente le proprie dipendenze, riducendo l'accoppiamento con il core.
2.  **Semplicità (KISS)**: Rimossi i wrapper obsoleti e le dipendenze ridondanti.
3.  **Memoria (Documentation)**: Questo documento funge da memoria persistente dell'evoluzione del modulo.

## 🛠️ Modifiche Eseguite
- [x] **PHP ^8.4**: Allineamento ai requisiti di Laravel 13.
- [x] **composer.json**: Aggiornato con `laravel/framework: ^13.0` e `nwidart/laravel-modules: ^13.0`.
- [x] **Namespacing**: Verificata la conformità PSR-4.
- [x] **Configurazione**: Sincronizzate le nuove opzioni di Laravel 13.

## 🚀 Quality Gates (Target)
- **PHPStan**: Level 10 (Zero tolleranza errori).
- **Complexity**: Inferiore a 10 (PHPMD).
- **Pest**: Coverage > 80% (In progress).

## 📝 Note Operative
L'aggiornamento richiede l'esecuzione di `composer go` dalla root per consolidare le dipendenze merged.

---
**Status**: Purificato e Pronto per il Futuro.

---

## laravel-localization-best-practices

*Consolidated from: `laravel-localization-best-practices.md`*

title: "LaravelLocalization - Best Practices"
module: "Lang"
type: concept
tags: [filament4, migration]
created: 2026-07-14
updated: 2026-07-14
qmd: "filament4 migration"
related:
  - "./italian-text-refined-audit-report.md"
---
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

---

## laravel-localization-complete-guide

*Consolidated from: `laravel-localization-complete-guide.md`*

title: "laravel-localization complete guide"
module: "Lang"
type: how-to
tags: [google, translate]
created: 2026-07-14
updated: 2026-07-14
qmd: "google translate"
related:
  - "./italian-text-refined-audit-report.md"
---
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

---

## laravel-localization-complete

*Consolidated from: `laravel-localization-complete.md`*

title: "Guida Completa a Laravel Localization"
module: "Lang"
type: concept
tags: [links]
created: 2026-07-14
updated: 2026-07-14
qmd: "links"
related:
  - "./italian-text-refined-audit-report.md"
---
# Guida Completa a Laravel Localization

## Introduzione

Il pacchetto `mcamara/laravel-localization` è una soluzione potente per implementare la localizzazione in applicazioni Laravel. Questa guida, basata sul corso di Laravel Daily, fornisce istruzioni dettagliate per l'installazione, la configurazione e l'uso del pacchetto nel progetto `<nome progetto>`.

## Funzionalità Principali

- **Gestione delle Lingue**: Supporta la gestione di più lingue tramite URL, sessioni o cookie.
- **Middleware**: Include middleware per il redirect basato sulla lingua.
- **URL Localizzati**: Genera URL specifici per ogni lingua supportata.
- **Route Tradotte**: Permette la traduzione dei parametri delle route.
- **Helper**: Fornisce funzioni helper per ottenere informazioni sulla lingua corrente e supportata.

## Installazione

Per installare il pacchetto, seguire questi passaggi:

1. **Installazione del Pacchetto**:
   ```bash
   composer require mcamara/laravel-localization
   ```

2. **Pubblicazione del File di Configurazione**:
   ```bash
   php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
   ```

3. **Registrazione del Middleware**:
   Modificare il file `app/Http/Kernel.php` per aggiungere i middleware necessari:
   ```php
   protected $routeMiddleware = [
       // ...
       'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
       'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
       'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
       'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
       'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class
   ];
   ```

## Configurazione delle Route

Per configurare le route con il prefisso della lingua, modificare il file `routes/web.php`:

```php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect']
], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    // altre route...
    require __DIR__ . '/auth.php';
});
```

Questo codice:
- Aggiunge il prefisso della lingua agli URL (es. `/en/` o `/es/`).
- Reindirizza l'utente alla lingua corretta se non la sta utilizzando.
- Tenta di indovinare la lingua dell'utente basandosi sulle impostazioni del browser.

## Abilitazione di Diverse Lingue

Modificare il file `config/laravellocalization.php` per abilitare le lingue desiderate:

```php
'supportedLocales' => [
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'Italiano', 'regional' => 'it_IT'],
    'es' => ['name' => 'Spanish', 'script' => 'Latn', 'native' => 'español', 'regional' => 'es_ES'],
],
```

## Aggiunta di un Selettore di Lingua

Aggiungere un selettore di lingua alla navigazione dell'applicazione modificando il file `resources/views/layouts/navigation.blade.php`:

```php
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <x-nav-link rel="alternate" hreflang="{{ $localeCode }}"
                :active="$localeCode === app()->getLocale()"
                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
        {{ ucfirst($properties['native']) }}
    </x-nav-link>
@endforeach
```

## Correzione della Cache delle Route

Per utilizzare la cache delle route con questo pacchetto, modificare il file `app/Providers/RouteServiceProvider.php`:

```php
class RouteServiceProvider extends ServiceProvider
{
    use \Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;
    // ...
}
```

Utilizzare i seguenti comandi per la cache delle route:
- Invece di `php artisan route:cache`, usare `php artisan route:trans:cache`.
- Invece di `php artisan route:clear`, usare `php artisan route:trans:clear`.

## Visualizzazione di Tutte le Route

Per visualizzare un elenco dettagliato delle route tradotte, utilizzare:
```bash
php artisan route:trans:list {locale}
```

## Funzionalità Estese del Pacchetto

### Mostrare o Nascondere la Lingua Predefinita nell'URL

Modificare `config/laravellocalization.php` per nascondere la lingua predefinita:

```php
'hideDefaultLocaleInURL' => true,
```

### Ignorare Route Specifiche

Per ignorare la localizzazione di alcune route, aggiungerle a `config/laravellocalization.php`:

```php
'urlsIgnored' => [
    '/queue-check',
],
```

### Traduzione delle Route

Per tradurre le route, aggiungere il middleware `localize` al gruppo di route in `routes/web.php`:

```php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localize']
], function () {
    // route tradotte...
});
```

Creare file di traduzione per le route in `resources/lang/{locale}/routes.php`. Ad esempio:

- Per l'inglese (`resources/lang/en/routes.php`):
  ```php
  return [
      'dashboard' => 'dashboard',
  ];
  ```

- Per l'italiano (`resources/lang/it/routes.php`):
  ```php
  return [
      'dashboard' => 'cruscotto',
  ];
  ```

Modificare le route per utilizzare la traduzione:

```php
Route::get(LaravelLocalization::transRoute('routes.dashboard'), [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
```

## Problemi con le Route Tradotte

Si noti che il metodo POST non funziona con le route tradotte. Utilizzare `LaravelLocalization::localizeUrl($route)` invece di `route()` per i form POST.

## Integrazione con Livewire

Se si utilizza Livewire, potrebbe essere necessario modificare il file `App/Providers/AppServiceProvider.php` per gestire correttamente gli aggiornamenti:

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Livewire\Livewire;

public function boot()
{
    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/livewire/update', $handle)
            ->middleware('web')
            ->prefix(LaravelLocalization::setLocale());
    });
    // ...
}
```

## Conclusione

Il pacchetto `mcamara/laravel-localization` offre un controllo versatile sulla localizzazione delle route. Combinato con la traduzione di testi statici, rende l'applicazione multilingue facile da gestire e user-friendly. Questa guida fornisce tutte le informazioni necessarie per implementare il pacchetto nel progetto `<nome progetto>`, rispettando le convenzioni di localizzazione degli URL e migliorando l'esperienza utente.

## Risorse

- Repository GitHub: [LaravelDaily/laravel11-localization-course](https://github.com/LaravelDaily/laravel11-localization-course/tree/lesson/packages/mcamara-laravel-localization)
- Documentazione Ufficiale: [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
# Guida Completa a Laravel Localization

## Introduzione

Il pacchetto `mcamara/laravel-localization` è una soluzione potente per implementare la localizzazione in applicazioni Laravel. Questa guida, basata sul corso di Laravel Daily, fornisce istruzioni dettagliate per l'installazione, la configurazione e l'uso del pacchetto nel progetto `<nome progetto>`.

## Funzionalità Principali

- **Gestione delle Lingue**: Supporta la gestione di più lingue tramite URL, sessioni o cookie.
- **Middleware**: Include middleware per il redirect basato sulla lingua.
- **URL Localizzati**: Genera URL specifici per ogni lingua supportata.
- **Route Tradotte**: Permette la traduzione dei parametri delle route.
- **Helper**: Fornisce funzioni helper per ottenere informazioni sulla lingua corrente e supportata.

## Installazione

Per installare il pacchetto, seguire questi passaggi:

1. **Installazione del Pacchetto**:
   ```bash
   composer require mcamara/laravel-localization
   ```

2. **Pubblicazione del File di Configurazione**:
   ```bash
   php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
   ```

3. **Registrazione del Middleware**:
   Modificare il file `app/Http/Kernel.php` per aggiungere i middleware necessari:
   ```php
   protected $routeMiddleware = [
       // ...
       'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
       'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
       'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
       'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
       'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class
   ];
   ```

## Configurazione delle Route

Per configurare le route con il prefisso della lingua, modificare il file `routes/web.php`:

```php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect']
], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    // altre route...
    require __DIR__ . '/auth.php';
});
```

Questo codice:
- Aggiunge il prefisso della lingua agli URL (es. `/en/` o `/es/`).
- Reindirizza l'utente alla lingua corretta se non la sta utilizzando.
- Tenta di indovinare la lingua dell'utente basandosi sulle impostazioni del browser.

## Abilitazione di Diverse Lingue

Modificare il file `config/laravellocalization.php` per abilitare le lingue desiderate:

```php
'supportedLocales' => [
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'Italiano', 'regional' => 'it_IT'],
    'es' => ['name' => 'Spanish', 'script' => 'Latn', 'native' => 'español', 'regional' => 'es_ES'],
],
```

## Aggiunta di un Selettore di Lingua

Aggiungere un selettore di lingua alla navigazione dell'applicazione modificando il file `resources/views/layouts/navigation.blade.php`:

```php
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <x-nav-link rel="alternate" hreflang="{{ $localeCode }}"
                :active="$localeCode === app()->getLocale()"
                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
        {{ ucfirst($properties['native']) }}
    </x-nav-link>
@endforeach
```

## Correzione della Cache delle Route

Per utilizzare la cache delle route con questo pacchetto, modificare il file `app/Providers/RouteServiceProvider.php`:

```php
class RouteServiceProvider extends ServiceProvider
{
    use \Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;
    // ...
}
```

Utilizzare i seguenti comandi per la cache delle route:
- Invece di `php artisan route:cache`, usare `php artisan route:trans:cache`.
- Invece di `php artisan route:clear`, usare `php artisan route:trans:clear`.

## Visualizzazione di Tutte le Route

Per visualizzare un elenco dettagliato delle route tradotte, utilizzare:
```bash
php artisan route:trans:list {locale}
```

## Funzionalità Estese del Pacchetto

### Mostrare o Nascondere la Lingua Predefinita nell'URL

Modificare `config/laravellocalization.php` per nascondere la lingua predefinita:

```php
'hideDefaultLocaleInURL' => true,
```

### Ignorare Route Specifiche

Per ignorare la localizzazione di alcune route, aggiungerle a `config/laravellocalization.php`:

```php
'urlsIgnored' => [
    '/queue-check',
],
```

### Traduzione delle Route

Per tradurre le route, aggiungere il middleware `localize` al gruppo di route in `routes/web.php`:

```php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localize']
], function () {
    // route tradotte...
});
```

Creare file di traduzione per le route in `resources/lang/{locale}/routes.php`. Ad esempio:

- Per l'inglese (`resources/lang/en/routes.php`):
  ```php
  return [
      'dashboard' => 'dashboard',
  ];
  ```

- Per l'italiano (`resources/lang/it/routes.php`):
  ```php
  return [
      'dashboard' => 'cruscotto',
  ];
  ```

Modificare le route per utilizzare la traduzione:

```php
Route::get(LaravelLocalization::transRoute('routes.dashboard'), [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
```

## Problemi con le Route Tradotte

Si noti che il metodo POST non funziona con le route tradotte. Utilizzare `LaravelLocalization::localizeUrl($route)` invece di `route()` per i form POST.

## Integrazione con Livewire

Se si utilizza Livewire, potrebbe essere necessario modificare il file `App/Providers/AppServiceProvider.php` per gestire correttamente gli aggiornamenti:

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Livewire\Livewire;

public function boot()
{
    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/livewire/update', $handle)
            ->middleware('web')
            ->prefix(LaravelLocalization::setLocale());
    });
    // ...
}
```

## Conclusione

Il pacchetto `mcamara/laravel-localization` offre un controllo versatile sulla localizzazione delle route. Combinato con la traduzione di testi statici, rende l'applicazione multilingue facile da gestire e user-friendly. Questa guida fornisce tutte le informazioni necessarie per implementare il pacchetto nel progetto `<nome progetto>`, rispettando le convenzioni di localizzazione degli URL e migliorando l'esperienza utente.

## Risorse

- Repository GitHub: [LaravelDaily/laravel11-localization-course](https://github.com/LaravelDaily/laravel11-localization-course/tree/lesson/packages/mcamara-laravel-localization)
- Documentazione Ufficiale: [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)

---

## laravel-localization-consolidated

*Consolidated from: `laravel-localization-consolidated.md`*

title: "Laravel Localization (mcamara): Consolidated Reference"
module: "Lang"
type: concept
tags: [filament4, migration]
created: 2026-07-14
updated: 2026-07-14
qmd: "filament4 migration"
related:
  - "./italian-text-refined-audit-report.md"
---
# Laravel Localization (mcamara): Consolidated Reference

## Overview

`mcamara/laravel-localization` provides i18n URL routing for this project. It handles locale detection, URL prefixing, session/cookie persistence, and translated routes.

## Project Usage

| File | Purpose |
|------|---------|
| `Modules/Lang/app/Http/Livewire/Lang/Switcher.php` | Language switcher component |
| `Modules/Lang/app/Http/Livewire/Lang/Change.php` | Language change handler |
| `Modules/Lang/resources/views/livewire/lang/change.blade.php` | Language selector view |
| `Modules/User/app/Filament/Widgets/RegistrationWidget.php` | Registration with locale |
| `Modules/User/resources/views/filament/widgets/user-dropdown.blade.php` | User dropdown with locale |
| `Modules/User/resources/views/pages/auth/register.blade.php` | Registration page |

## Configuration

Config file: `config/laravellocalization.php`

| Option | Description |
|--------|-------------|
| `supportedLocales` | Array of supported languages |
| `useAcceptLanguageHeader` | Auto-detect from browser |
| `hideDefaultLocaleInURL` | Hide default locale prefix |
| `localesOrder` | Custom sort for language selector |
| `localesMapping` | Rename URL segments |

## Routing

```php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
], function () {
    // All localized routes here
});
```

## Middleware

| Alias | Purpose |
|-------|---------|
| `localize` | Core localization routing |
| `localeSessionRedirect` | Store/restore locale in session |
| `localeCookieRedirect` | Store/restore locale in cookie |
| `localizationRedirect` | Redirect when default locale is in URL |
| `localeViewPath` | Set view base path per locale |

## Key Helpers

```php
// Localized URL
LaravelLocalization::localizeUrl('/test')

// URL for specific locale
LaravelLocalization::getLocalizedURL('en')

// Clean URL (no locale prefix)
LaravelLocalization::getNonLocalizedURL('/it/chi-siamo')

// Translated route URL
LaravelLocalization::getURLFromRouteNameTranslated('it', 'routes.about')

// All supported locales
LaravelLocalization::getSupportedLocales()

// Current locale
LaravelLocalization::getCurrentLocale()
LaravelLocalization::getCurrentLocaleName()
LaravelLocalization::getCurrentLocaleNative()
LaravelLocalization::getCurrentLocaleDirection()
```

## Language Selector (Blade)

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

## Translated Routes

Define in `lang/{locale}/routes.php`:

```php
// lang/en/routes.php
return [
    'about' => 'about',
];

// lang/it/routes.php
return [
    'about' => 'chi-siamo',
];
```

Usage:
```php
Route::get(LaravelLocalization::transRoute('routes.about'), [AboutController::class, 'index']);
```

## Route Caching

```bash
php artisan route:trans:cache   # Cache translated routes
php artisan route:trans:clear   # Clear cache
php artisan route:trans:list it # List routes for locale
```

## Laraxot Rules

1. **Module `Lang` owns localization**: other modules must not duplicate this logic
2. **Always use redirect middleware**: prevents SEO duplicate content
3. **Never hardcode locale strings**: use `LaravelLocalization::getCurrentLocale()`
4. **Short array syntax `[]`** only in all PHP code
5. **Filament panels** integrate via `XotBasePanelProvider`

## Related Docs

- [Skill: laravel-localization](../../../../.agent/skills/laravel-localization/skill.md)
- [Filament Integration](./filament-integration.md)
- [Filament Integration](../../filament-integration.md)
- [Philosophy](./philosophy.md)

---

## laravel-localization-folio-integration

*Consolidated from: `laravel-localization-folio-integration.md`*

title: "Integration of Mcamara Laravel Localization with Laravel Folio"
module: "Lang"
type: concept
tags: [phpstan, level10, fixes, 1]
created: 2026-07-14
updated: 2026-07-14
qmd: "phpstan level10 fixes 1"
related:
  - "./italian-text-refined-audit-report.md"
---
# Integration of Mcamara Laravel Localization with Laravel Folio

## Overview
In the `<nome progetto>` project, providing a multi-language experience with localized URLs is essential for accessibility and SEO. This document explores the integration between [`mcamara/laravel-localization`](https://github.com/mcamara/laravel-localization) and [`laravel/folio`](https://github.com/laravel/folio), ensuring that our page routing system supports language prefixes and locale-specific content in a healthcare context.
In the `ptvx` project, providing a multi-language experience with localized URLs is essential for accessibility and SEO. This document explores the integration between [`mcamara/laravel-localization`](https://github.com/mcamara/laravel-localization) and [`laravel/folio`](https://github.com/laravel/folio), ensuring that our page routing system supports language prefixes and locale-specific content in a healthcare context.

## Purpose of Integration
- **Localized URLs**: Enable language prefixes in URLs (e.g., `/en/services`, `/it/servizi`) for better user experience and SEO.
- **Dynamic Page Routing**: Use Laravel Folio for managing page routes directly from Blade files while maintaining locale awareness.
- **Seamless Language Switching**: Ensure users can switch languages without breaking page navigation or losing context.

## Analysis of Components

### Mcamara Laravel Localization
This package provides robust tools for:
- Managing localized routes with prefixes.
- Middleware to detect and set the application locale based on URL or user preference.
- Helpers for generating localized URLs and handling language switching.

Key features relevant to Folio integration:
- **Route Translation**: Automatically prepends locale to routes.
- **Locale Detection**: Determines the current locale from URL segments.
- **URL Generation**: Generates URLs with the appropriate locale prefix via the `route()` and `url()` helpers.

### Laravel Folio
Folio is a page-based routing system for Laravel that:
- Maps URLs directly to Blade view files based on their file path.
- Simplifies routing for static or semi-static pages by eliminating the need for explicit route definitions.
- Supports middleware application at the page level.

Challenges with localization:
- Folio's automatic routing does not inherently account for locale prefixes.
- Direct file-to-URL mapping may conflict with dynamic locale segments in URLs.

## Integration Challenges
1. **URL Structure Conflict**: Folio maps URLs directly to file paths (e.g., `/about` to `resources/views/pages/about.blade.php`), but `laravel-localization` prepends a locale (e.g., `/en/about`), potentially causing mismatches.
2. **Locale Detection**: Ensuring Folio pages respect the locale set by `laravel-localization` middleware.
3. **Language Switching**: Maintaining the correct URL structure when users switch languages on Folio-managed pages.
4. **Route Generation**: Adapting Folio's simplicity with `laravel-localization`'s need for localized route names or prefixes.

## Integration Solution

### Step 1: Installation and Setup
Ensure both packages are installed:
```bash
composer require mcamara/laravel-localization
composer require laravel/folio
```
Publish configuration for `laravel-localization`:
```bash
php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
```
Set up Folio as per Laravel documentation, typically in a service provider or `routes/web.php`:
```php
use Laravel\Folio\Folio;

Folio::path(resource_path('views/pages'))->middleware([
    '*'.':'.\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRoutes::class,
    '*'.':'.\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRedirectFilter::class,
    '*'.':'.\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationViewPath::class,
]);
```

### Step 2: Configuration
Configure supported locales in `config/laravellocalization.php`:
```php
'supportedLocales' => [
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'Italiano', 'regional' => 'it_IT'],
],
'useAcceptLanguageHeader' => true,
'hideDefaultLocaleInURL' => false,
```

### Step 3: Middleware Integration
Ensure that Folio routes are processed by `laravel-localization` middleware to handle locale detection and redirection. In a service provider (e.g., `AppServiceProvider`):
```php
public function boot()
{
    Folio::path(resource_path('views/pages'))->middleware([
        \Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRoutes::class,
        \Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRedirectFilter::class,
        \Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationViewPath::class,
    ]);
}
```
Alternatively, apply middleware globally in `bootstrap/app.php` to cover all routes, including Folio:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->append(\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRoutes::class);
    $middleware->append(\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRedirectFilter::class);
    $middleware->append(\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationViewPath::class);
})
```

### Step 4: Handling Folio Routes with Locale Prefixes
Folio's direct mapping needs adjustment to account for locale prefixes. Since Folio doesn't natively support dynamic prefixes, we can use a custom approach:

#### Option 1: Custom Folio Middleware
Create a middleware to strip the locale prefix before Folio processes the route:
```php
// app/Http/Middleware/HandleFolioLocalization.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class HandleFolioLocalization
{
    public function handle(Request $request, Closure $next)
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $path = $request->path();
        if (strpos($path, $locale) === 0) {
            $newPath = substr($path, strlen($locale) + 1);
            $request->server->set('REQUEST_URI', '/' . $newPath);
        }
        return $next($request);
    }
}
```
Register this middleware specifically for Folio routes after the `LaravelLocalization` middleware:
```php
Folio::path(resource_path('views/pages'))->middleware([
    \Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRoutes::class,
    \App\Http\Middleware\HandleFolioLocalization::class,
]);
```

#### Option 2: Folder Structure for Localized Pages
Organize Folio pages with locale subfolders (e.g., `resources/views/pages/en/about.blade.php`, `resources/views/pages/it/about.blade.php`) and use a custom Folio resolver or middleware to select the correct folder based on locale. However, this approach may require significant customization of Folio's routing logic and is less recommended due to maintenance overhead.

### Step 5: URL Generation in Blade Files
Ensure that links in Folio-managed Blade files respect localization. Use `laravel-localization`'s helpers:
```php
<!-- resources/views/pages/about.blade.php -->
<a href="{{ LaravelLocalization::getLocalizedURL(null, route('home')) }}">Home</a>
```
Or directly with the route helper:
```php
<a href="{{ route('home', [], false) }}">Home</a>
```
Ensure `routeIs()` helper accounts for locale when checking active routes:
```php
<li class="{{ routeIs('about') ? 'active' : '' }}">
    <a href="{{ route('about', [], false) }}">About</a>
</li>
```

### Step 6: Language Switching for Folio Pages
When implementing a language switcher, ensure it redirects to the localized version of the current Folio page:
```php
// app/Http/Controllers/ChangeLanguageController.php
public function __invoke($locale)
{
    if (!array_key_exists($locale, LaravelLocalization::getSupportedLocales())) {
        return redirect()->back();
    }
    if (Auth::check()) {
        Auth::user()->update(['language' => $locale]);
    }
    session()->put('locale', $locale);
    return redirect(LaravelLocalization::getLocalizedURL($locale, url()->current()));
}
```

## Best Practices for `<nome progetto>`
## Best Practices for `ptvx`
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
Integrating `mcamara/laravel-localization` with `laravel/folio` requires careful handling of URL prefixes and middleware to ensure seamless localized routing. By using a custom middleware to manage locale prefixes and leveraging `laravel-localization`'s helpers for URL generation, `<nome progetto>` can provide a robust multi-language experience for healthcare users while maintaining the simplicity of Folio's page-based routing. This approach ensures accessibility, SEO benefits, and user-friendly navigation across languages.
# Integration of Mcamara Laravel Localization with Laravel Folio

## Overview
In the `<nome progetto>` project, providing a multi-language experience with localized URLs is essential for accessibility and SEO. This document explores the integration between [`mcamara/laravel-localization`](https://github.com/mcamara/laravel-localization) and [`laravel/folio`](https://github.com/laravel/folio), ensuring that our page routing system supports language prefixes and locale-specific content in a healthcare context.

## Purpose of Integration
- **Localized URLs**: Enable language prefixes in URLs (e.g., `/en/services`, `/it/servizi`) for better user experience and SEO.
- **Dynamic Page Routing**: Use Laravel Folio for managing page routes directly from Blade files while maintaining locale awareness.
- **Seamless Language Switching**: Ensure users can switch languages without breaking page navigation or losing context.

## Analysis of Components

### Mcamara Laravel Localization
This package provides robust tools for:
- Managing localized routes with prefixes.
- Middleware to detect and set the application locale based on URL or user preference.
- Helpers for generating localized URLs and handling language switching.

Key features relevant to Folio integration:
- **Route Translation**: Automatically prepends locale to routes.
- **Locale Detection**: Determines the current locale from URL segments.
- **URL Generation**: Generates URLs with the appropriate locale prefix via the `route()` and `url()` helpers.

### Laravel Folio
Folio is a page-based routing system for Laravel that:
- Maps URLs directly to Blade view files based on their file path.
- Simplifies routing for static or semi-static pages by eliminating the need for explicit route definitions.
- Supports middleware application at the page level.

Challenges with localization:
- Folio's automatic routing does not inherently account for locale prefixes.
- Direct file-to-URL mapping may conflict with dynamic locale segments in URLs.

## Integration Challenges
1. **URL Structure Conflict**: Folio maps URLs directly to file paths (e.g., `/about` to `resources/views/pages/about.blade.php`), but `laravel-localization` prepends a locale (e.g., `/en/about`), potentially causing mismatches.
2. **Locale Detection**: Ensuring Folio pages respect the locale set by `laravel-localization` middleware.
3. **Language Switching**: Maintaining the correct URL structure when users switch languages on Folio-managed pages.
4. **Route Generation**: Adapting Folio's simplicity with `laravel-localization`'s need for localized route names or prefixes.

## Integration Solution

### Step 1: Installation and Setup
Ensure both packages are installed:
```bash
composer require mcamara/laravel-localization
composer require laravel/folio
```
Publish configuration for `laravel-localization`:
```bash
php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
```
Set up Folio as per Laravel documentation, typically in a service provider or `routes/web.php`:
```php
use Laravel\Folio\Folio;

Folio::path(resource_path('views/pages'))->middleware([
    '*'.':'.\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRoutes::class,
    '*'.':'.\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRedirectFilter::class,
    '*'.':'.\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationViewPath::class,
]);
```

### Step 2: Configuration
Configure supported locales in `config/laravellocalization.php`:
```php
'supportedLocales' => [
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'Italiano', 'regional' => 'it_IT'],
],
'useAcceptLanguageHeader' => true,
'hideDefaultLocaleInURL' => false,
```

### Step 3: Middleware Integration
Ensure that Folio routes are processed by `laravel-localization` middleware to handle locale detection and redirection. In a service provider (e.g., `AppServiceProvider`):
```php
public function boot()
{
    Folio::path(resource_path('views/pages'))->middleware([
        \Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRoutes::class,
        \Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRedirectFilter::class,
        \Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationViewPath::class,
    ]);
}
```
Alternatively, apply middleware globally in `bootstrap/app.php` to cover all routes, including Folio:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->append(\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRoutes::class);
    $middleware->append(\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRedirectFilter::class);
    $middleware->append(\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationViewPath::class);
})
```

### Step 4: Handling Folio Routes with Locale Prefixes
Folio's direct mapping needs adjustment to account for locale prefixes. Since Folio doesn't natively support dynamic prefixes, we can use a custom approach:

#### Option 1: Custom Folio Middleware
Create a middleware to strip the locale prefix before Folio processes the route:
```php
// app/Http/Middleware/HandleFolioLocalization.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class HandleFolioLocalization
{
    public function handle(Request $request, Closure $next)
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $path = $request->path();
        if (strpos($path, $locale) === 0) {
            $newPath = substr($path, strlen($locale) + 1);
            $request->server->set('REQUEST_URI', '/' . $newPath);
        }
        return $next($request);
    }
}
```
Register this middleware specifically for Folio routes after the `LaravelLocalization` middleware:
```php
Folio::path(resource_path('views/pages'))->middleware([
    \Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRoutes::class,
    \App\Http\Middleware\HandleFolioLocalization::class,
]);
```

#### Option 2: Folder Structure for Localized Pages
Organize Folio pages with locale subfolders (e.g., `resources/views/pages/en/about.blade.php`, `resources/views/pages/it/about.blade.php`) and use a custom Folio resolver or middleware to select the correct folder based on locale. However, this approach may require significant customization of Folio's routing logic and is less recommended due to maintenance overhead.

### Step 5: URL Generation in Blade Files
Ensure that links in Folio-managed Blade files respect localization. Use `laravel-localization`'s helpers:
```php
<!-- resources/views/pages/about.blade.php -->
<a href="{{ LaravelLocalization::getLocalizedURL(null, route('home')) }}">Home</a>
```
Or directly with the route helper:
```php
<a href="{{ route('home', [], false) }}">Home</a>
```
Ensure `routeIs()` helper accounts for locale when checking active routes:
```php
<li class="{{ routeIs('about') ? 'active' : '' }}">
    <a href="{{ route('about', [], false) }}">About</a>
</li>
```

### Step 6: Language Switching for Folio Pages
When implementing a language switcher, ensure it redirects to the localized version of the current Folio page:
```php
// app/Http/Controllers/ChangeLanguageController.php
public function __invoke($locale)
{
    if (!array_key_exists($locale, LaravelLocalization::getSupportedLocales())) {
        return redirect()->back();
    }
    if (Auth::check()) {
        Auth::user()->update(['language' => $locale]);
    }
    session()->put('locale', $locale);
    return redirect(LaravelLocalization::getLocalizedURL($locale, url()->current()));
}
```

## Best Practices for `<nome progetto>`
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
Integrating `mcamara/laravel-localization` with `laravel/folio` requires careful handling of URL prefixes and middleware to ensure seamless localized routing. By using a custom middleware to manage locale prefixes and leveraging `laravel-localization`'s helpers for URL generation, `<nome progetto>` can provide a robust multi-language experience for healthcare users while maintaining the simplicity of Folio's page-based routing. This approach ensures accessibility, SEO benefits, and user-friendly navigation across languages.
Integrating `mcamara/laravel-localization` with `laravel/folio` requires careful handling of URL prefixes and middleware to ensure seamless localized routing. By using a custom middleware to manage locale prefixes and leveraging `laravel-localization`'s helpers for URL generation, `ptvx` can provide a robust multi-language experience for healthcare users while maintaining the simplicity of Folio's page-based routing. This approach ensures accessibility, SEO benefits, and user-friendly navigation across languages.

---

## laravel-localization-folio

*Consolidated from: `laravel-localization-folio.md`*

title: "Integrazione tra mcamara/laravel-localization e Laravel Folio"
module: "Lang"
type: concept
tags: [REDUNDANCY, ANALYSIS]
created: 2026-07-14
updated: 2026-07-14
qmd: "redundancy analysis"
related:
  - "./italian-text-refined-audit-report.md"
---
# Integrazione tra mcamara/laravel-localization e Laravel Folio

## Obiettivo
Fornire una guida pratica e dettagliata per integrare la localizzazione delle rotte (mcamara/laravel-localization) con il routing file-based di **Laravel Folio**, garantendo URL localizzati, contenuti multilingua e compatibilità con le best practice Laravel.

---

## 1. Cos'è Laravel Folio?
- **Folio** è il sistema di routing file-based introdotto in Laravel 11+, che permette di definire le rotte tramite la struttura delle cartelle e dei file in `resources/views/pages`.
- Ogni file Blade in questa cartella diventa una rotta accessibile via URL.

---

## 2. Sfida dell'integrazione
- **mcamara/laravel-localization** si basa su gruppi di rotte Laravel classici (`Route::group`) per aggiungere il prefisso della lingua e gestire la localizzazione.
- **Folio** genera le rotte in modo automatico, senza passare da `routes/web.php`.
- È necessario assicurarsi che tutte le rotte Folio siano "wrappate" dal middleware di localizzazione e che i path siano localizzati.

---

## 3. Best Practice per l'integrazione

### a) Registrazione delle rotte Folio nel gruppo localizzato
**Soluzione consigliata:**
- Registra Folio **dentro** il gruppo di localizzazione, esattamente come faresti con le rotte classiche.

Esempio in `routes/web.php`:
```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Laravel\Folio\Folio;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Folio::route(resource_path('views/pages'));
        // ...altre rotte classiche se necessario
    }
);
```
**Risultato:**
Tutte le pagine Folio saranno accessibili con il prefisso lingua (`/it/about`, `/en/about`, ecc).

---

### b) Traduzione dei path delle pagine Folio
- Di default, i path Folio sono basati sul nome del file (es: `about.blade.php` → `/about`).
- Per avere path localizzati (es: `/it/chi-siamo` invece di `/it/about`), sfrutta la funzionalità di **route translation mapping** di mcamara/laravel-localization.

**Procedura:**
1. Crea i file di mapping in `lang/{locale}/routes.php`:
    ```php
    // lang/it/routes.php
    return [
        'about' => 'chi-siamo',
        'contact' => 'contatti',
    ];
    ```
2. Quando generi link o usi redirect, usa sempre:
    ```php
    route(LaravelLocalization::transRoute('routes.about'))
    ```
3. Se vuoi che anche Folio generi le rotte con path tradotti, valuta di creare symlink o duplicati dei file Blade con nomi localizzati, oppure implementa una logica custom (ad oggi Folio non supporta nativamente il mapping automatico dei path tramite array di traduzioni).

**Nota:**
Se la localizzazione dei path è fondamentale, valuta se usare ancora le rotte classiche per le pagine che richiedono path tradotti, oppure contribuisci/estendi Folio per supportare questa feature.

---

### c) Middleware e sessione
- Il middleware di mcamara/laravel-localization gestisce la lingua tramite sessione, cookie e URL.
- Assicurati che il middleware sia applicato a tutte le rotte Folio (come nell'esempio sopra).
- Se usi componenti Livewire/Volt nelle pagine Folio, la lingua sarà già impostata correttamente.

---

### d) Language Switcher
- Usa sempre gli helper di mcamara per generare i link di cambio lingua:
    ```blade
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
            {{ $properties['native'] }}
        </a>
    @endforeach
    ```
- Inserisci il language switcher in un layout Blade condiviso da tutte le pagine Folio.

---

### e) Caching delle rotte
- Per cache-izzare le rotte localizzate, usa **solo**:
    ```
    php artisan route:trans:cache
    ```
  e **non** il comando standard `route:cache`.
- Segui le istruzioni aggiornate nella [documentazione ufficiale](https://github.com/mcamara/laravel-localization#caching-routes) per Laravel 11+.

---

## 4. FAQ e problemi comuni
- **Perché una pagina Folio non viene localizzata?**
  Verifica che la registrazione di Folio sia dentro il gruppo di localizzazione e che il middleware sia applicato.
- **Come traduco i path delle pagine Folio?**
  Ad oggi serve una soluzione custom (symlink, duplicati, override di Folio) oppure accetta che i path siano in inglese ma i contenuti localizzati.
- **Come gestisco redirect e link?**
  Usa sempre `route(LaravelLocalization::transRoute('routes.nome'))` per generare URL localizzati.
- **Come gestisco i form POST?**
  Usa sempre l'helper `localizeURL` per l'action dei form:
  ```blade
  <form action="{{ LaravelLocalization::localizeURL('/contatti') }}" method="POST">
  ```

---

## 5. Checklist
- [ ] Folio è registrato dentro il gruppo localizzato.
- [ ] Tutti i link e redirect usano helper di localizzazione.
- [ ] I path delle pagine sono localizzati (se necessario) tramite mapping o workaround.
- [ ] Il language switcher è presente in tutti i layout.
- [ ] La cache delle rotte usa solo `route:trans:cache`.

---

## 6. Modifiche consigliate ai file del progetto
- **routes/web.php**:
  Sposta la registrazione di Folio dentro il gruppo localizzato.
- **lang/{locale}/routes.php**:
  Aggiungi mapping per i path delle pagine Folio se vuoi path tradotti.
- **layouts Blade**:
  Inserisci il language switcher in tutti i layout usati da Folio.
- **Documentazione**:
  Aggiorna sempre questa guida ogni volta che cambi la struttura delle pagine o la strategia di localizzazione.

---

## 7. Collegamenti correlati
- [Documentazione ufficiale mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
- [Documentazione Laravel Folio](https://laravel.com/project_docs/12.x/folio)
- [Esempio di mapping rotte](https://github.com/mcamara/laravel-localization#translated-routes)
- [FAQ e problemi comuni](Modules/Lang/project_docs/translations-faq.md)
- [Guida language switcher](Modules/Lang/project_docs/README.md)
- [FAQ e problemi comuni](Modules/Lang/project_docs/translations-faq.md)
- [Guida language switcher](Modules/Lang/project_docs/README.md)
- [FAQ e problemi comuni](Modules/Lang/project_docs/translations-faq.md)
- [FAQ e problemi comuni](../../translations-faq.md)
- [Guida language switcher](Modules/Lang/project_docs/README.md)
- [FAQ e problemi comuni](../../translations-faq.md)
- [Guida language switcher](Modules/Lang/project_docs/README.md)
- [FAQ e problemi comuni](../../translations-faq.md)
- [Guida language switcher](Modules/Lang/project_docs/README.md)

---

**Se vuoi che aggiorni direttamente la documentazione o vuoi esempi pratici di override/mapping path Folio, chiedi pure!**
# Integrazione tra mcamara/laravel-localization e Laravel Folio

## Obiettivo
Fornire una guida pratica e dettagliata per integrare la localizzazione delle rotte (mcamara/laravel-localization) con il routing file-based di **Laravel Folio**, garantendo URL localizzati, contenuti multilingua e compatibilità con le best practice Laravel.

---

## 1. Cos'è Laravel Folio?
- **Folio** è il sistema di routing file-based introdotto in Laravel 11+, che permette di definire le rotte tramite la struttura delle cartelle e dei file in `resources/views/pages`.
- Ogni file Blade in questa cartella diventa una rotta accessibile via URL.

---

## 2. Sfida dell'integrazione
- **mcamara/laravel-localization** si basa su gruppi di rotte Laravel classici (`Route::group`) per aggiungere il prefisso della lingua e gestire la localizzazione.
- **Folio** genera le rotte in modo automatico, senza passare da `routes/web.php`.
- È necessario assicurarsi che tutte le rotte Folio siano "wrappate" dal middleware di localizzazione e che i path siano localizzati.

---

## 3. Best Practice per l'integrazione

### a) Registrazione delle rotte Folio nel gruppo localizzato
**Soluzione consigliata:**
- Registra Folio **dentro** il gruppo di localizzazione, esattamente come faresti con le rotte classiche.

Esempio in `routes/web.php`:
```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Laravel\Folio\Folio;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Folio::route(resource_path('views/pages'));
        // ...altre rotte classiche se necessario
    }
);
```
**Risultato:**
Tutte le pagine Folio saranno accessibili con il prefisso lingua (`/it/about`, `/en/about`, ecc).

---

### b) Traduzione dei path delle pagine Folio
- Di default, i path Folio sono basati sul nome del file (es: `about.blade.php` → `/about`).
- Per avere path localizzati (es: `/it/chi-siamo` invece di `/it/about`), sfrutta la funzionalità di **route translation mapping** di mcamara/laravel-localization.

**Procedura:**
1. Crea i file di mapping in `lang/{locale}/routes.php`:
    ```php
    // lang/it/routes.php
    return [
        'about' => 'chi-siamo',
        'contact' => 'contatti',
    ];
    ```
2. Quando generi link o usi redirect, usa sempre:
    ```php
    route(LaravelLocalization::transRoute('routes.about'))
    ```
3. Se vuoi che anche Folio generi le rotte con path tradotti, valuta di creare symlink o duplicati dei file Blade con nomi localizzati, oppure implementa una logica custom (ad oggi Folio non supporta nativamente il mapping automatico dei path tramite array di traduzioni).

**Nota:**
Se la localizzazione dei path è fondamentale, valuta se usare ancora le rotte classiche per le pagine che richiedono path tradotti, oppure contribuisci/estendi Folio per supportare questa feature.

---

### c) Middleware e sessione
- Il middleware di mcamara/laravel-localization gestisce la lingua tramite sessione, cookie e URL.
- Assicurati che il middleware sia applicato a tutte le rotte Folio (come nell'esempio sopra).
- Se usi componenti Livewire/Volt nelle pagine Folio, la lingua sarà già impostata correttamente.

---

### d) Language Switcher
- Usa sempre gli helper di mcamara per generare i link di cambio lingua:
    ```blade
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
            {{ $properties['native'] }}
        </a>
    @endforeach
    ```
- Inserisci il language switcher in un layout Blade condiviso da tutte le pagine Folio.

---

### e) Caching delle rotte
- Per cache-izzare le rotte localizzate, usa **solo**:
    ```
    php artisan route:trans:cache
    ```
  e **non** il comando standard `route:cache`.
- Segui le istruzioni aggiornate nella [documentazione ufficiale](https://github.com/mcamara/laravel-localization#caching-routes) per Laravel 11+.

---

## 4. FAQ e problemi comuni
- **Perché una pagina Folio non viene localizzata?**
  Verifica che la registrazione di Folio sia dentro il gruppo di localizzazione e che il middleware sia applicato.
- **Come traduco i path delle pagine Folio?**
  Ad oggi serve una soluzione custom (symlink, duplicati, override di Folio) oppure accetta che i path siano in inglese ma i contenuti localizzati.
- **Come gestisco redirect e link?**
  Usa sempre `route(LaravelLocalization::transRoute('routes.nome'))` per generare URL localizzati.
- **Come gestisco i form POST?**
  Usa sempre l'helper `localizeURL` per l'action dei form:
  ```blade
  <form action="{{ LaravelLocalization::localizeURL('/contatti') }}" method="POST">
  ```

---

## 5. Checklist
- [ ] Folio è registrato dentro il gruppo localizzato.
- [ ] Tutti i link e redirect usano helper di localizzazione.
- [ ] I path delle pagine sono localizzati (se necessario) tramite mapping o workaround.
- [ ] Il language switcher è presente in tutti i layout.
- [ ] La cache delle rotte usa solo `route:trans:cache`.

---

## 6. Modifiche consigliate ai file del progetto
- **routes/web.php**:
  Sposta la registrazione di Folio dentro il gruppo localizzato.
- **lang/{locale}/routes.php**:
  Aggiungi mapping per i path delle pagine Folio se vuoi path tradotti.
- **layouts Blade**:
  Inserisci il language switcher in tutti i layout usati da Folio.
- **Documentazione**:
  Aggiorna sempre questa guida ogni volta che cambi la struttura delle pagine o la strategia di localizzazione.

---

## 7. Collegamenti correlati
- [Documentazione ufficiale mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
- [Documentazione Laravel Folio](https://laravel.com/docs/12.x/folio)
- [Esempio di mapping rotte](https://github.com/mcamara/laravel-localization#translated-routes)
- [FAQ e problemi comuni](Modules/Lang/docs/translations-faq.md)
- [Guida language switcher](Modules/Lang/docs/README.md)
- [FAQ e problemi comuni](Modules/Lang/docs/translations-faq.md)
- [FAQ e problemi comuni](../../translations-faq.md)
- [Guida language switcher](Modules/Lang/docs/README.md)
- [FAQ e problemi comuni](../../translations-faq.md)
- [Guida language switcher](Modules/Lang/docs/README.md)

---

**Se vuoi che aggiorni direttamente la documentazione o vuoi esempi pratici di override/mapping path Folio, chiedi pure!**

---

**Se vuoi che aggiorni direttamente la documentazione o vuoi esempi pratici di override/mapping path Folio, chiedi pure!**
- [FAQ e problemi comuni](Modules/Lang/docs/translations-faq.md)
- [FAQ e problemi comuni](../../translations-faq.md)
- [Guida language switcher](Modules/Lang/docs/README.md)

---

**Se vuoi che aggiorni direttamente la documentazione o vuoi esempi pratici di override/mapping path Folio, chiedi pure!**

---

## laravel-localization-implementation

*Consolidated from: `laravel-localization-implementation.md`*

title: "Implementazione della Localizzazione"
module: "Lang"
type: concept
tags: [migrazione, filament, 4]
created: 2026-07-14
updated: 2026-07-14
qmd: "migrazione filament 4"
related:
  - "./italian-text-refined-audit-report.md"
---
# Implementazione della Localizzazione

## Collegamenti correlati
- [Documentazione centrale](/docs/README.md)
- [Collegamenti documentazione](/docs/collegamenti-documentazione.md)
- [Regole Traduzioni Lang](/laravel/Modules/Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Componenti SVG Bandiere](/laravel/Modules/UI/docs/FLAGS_COMPONENTS.md)
- [Implementazione Header](/laravel/Themes/One/docs/sections/HEADER_LANGUAGE_USER_DROPDOWN.md)

## Panoramica

 utilizza il pacchetto `mcamara/laravel-localization` per gestire la localizzazione dell'applicazione. Questo documento descrive come implementare correttamente il selettore di lingue e come utilizzare le funzioni del pacchetto.

## Regole Fondamentali

1. **NON creare rotte personalizzate** per la gestione delle lingue (come `language.switch`)
2. **NON creare controller specifici** per la gestione delle lingue
3. Utilizzare **ESCLUSIVAMENTE** le funzioni native del pacchetto `mcamara/laravel-localization`
4. Filament e Folio gestiscono già la localizzazione, non è necessario implementare logiche personalizzate

## Funzioni del Pacchetto `mcamara/laravel-localization`

### Ottenere la Lingua Corrente

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

$currentLocale = LaravelLocalization::getCurrentLocale();
```

### Ottenere le Lingue Supportate

```php
$supportedLocales = LaravelLocalization::getSupportedLocales();
```

### Generare URL Localizzati

```php
$url = LaravelLocalization::getLocalizedURL('it'); // URL per la lingua italiana
$url = LaravelLocalization::getLocalizedURL('en'); // URL per la lingua inglese
```

## Implementazione Corretta del Selettore di Lingue

### Componente Blade

```blade
@props(['currentLocale' => LaravelLocalization::getCurrentLocale()])

<div x-data="{ open: false }" class="relative">
    <button
        @click="open = !open"
        class="flex items-center space-x-2 px-3 py-2 rounded-lg bg-white/10 hover:bg-white/20 transition-colors duration-200"
        aria-label="{{ __('common.language_selector.toggle_button') }}"
    >
        @php
            $flagCode = $currentLocale === 'en' ? 'gb' : $currentLocale;
        @endphp
        <x-ui-flags.{{ $flagCode }} class="w-6 h-4" />
        <span class="text-sm font-medium text-white">{{ strtoupper($currentLocale) }}</span>
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
    >
        <div class="py-1">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                @php
                    $flagCode = $localeCode === 'en' ? 'gb' : $localeCode;
                @endphp
                <a
                    href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}"
                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $currentLocale === $localeCode ? 'bg-gray-50' : '' }}"
                >
                    <x-ui-flags.{{ $flagCode }} class="w-6 h-4 mr-2" />
                    <span>{{ $properties['native'] }}</span>
                    @if($currentLocale === $localeCode)
                        <svg class="w-4 h-4 ml-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
```

## Errori Comuni da Evitare

### 1. Utilizzo di Rotte Personalizzate

```blade
<!-- ERRATO -->
<a href="{{ route('language.switch', 'it') }}">Italiano</a>

<!-- CORRETTO -->
<a href="{{ LaravelLocalization::getLocalizedURL('it') }}">Italiano</a>
```

### 2. Implementazione di Controller per il Cambio Lingua

```php
// ERRATO
Route::get('language/{locale}', 'LanguageController@switch')->name('language.switch');

// CORRETTO
// Non è necessario implementare controller o rotte personalizzate
// Il pacchetto mcamara/laravel-localization gestisce già tutto
```

### 3. Utilizzo di Helper Personalizzati

```php
// ERRATO
function switchLanguage($locale) {
    // Logica personalizzata per il cambio lingua
}

// CORRETTO
// Utilizzare le funzioni native del pacchetto
$url = LaravelLocalization::getLocalizedURL($locale);
```

## Configurazione del Pacchetto

La configurazione del pacchetto `mcamara/laravel-localization` si trova nel file `config/laravellocalization.php`. Le lingue supportate sono definite nell'array `supportedLocales`:

```php
'supportedLocales' => [
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT'],
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    // Altre lingue...
],
```

## Middleware

Il pacchetto `mcamara/laravel-localization` fornisce diversi middleware per gestire la localizzazione:

1. `LaravelLocalizationRoutes`: Applica il prefisso della lingua alle rotte
2. `LaravelLocalizationRedirectFilter`: Reindirizza alla lingua predefinita se la lingua non è specificata
3. `LaravelLocalizationViewPath`: Imposta il percorso delle viste in base alla lingua

## Conclusione

Seguendo queste linee guida, è possibile implementare correttamente la localizzazione  utilizzando il pacchetto `mcamara/laravel-localization` senza creare rotte o controller personalizzati. Questo approccio è coerente con la filosofia di  di utilizzare Filament e Folio per gestire la maggior parte delle funzionalità dell'applicazione.
# Implementazione della Localizzazione

## Collegamenti correlati
- [Documentazione centrale](/docs/README.md)
- [Collegamenti documentazione](/docs/collegamenti-documentazione.md)
- [Regole Traduzioni Lang](/laravel/Modules/Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Componenti SVG Bandiere](/laravel/Modules/UI/docs/FLAGS_COMPONENTS.md)
- [Implementazione Header](/laravel/Themes/One/docs/sections/HEADER_LANGUAGE_USER_DROPDOWN.md)

## Panoramica

<nome progetto> utilizza il pacchetto `mcamara/laravel-localization` per gestire la localizzazione dell'applicazione. Questo documento descrive come implementare correttamente il selettore di lingue e come utilizzare le funzioni del pacchetto.

## Regole Fondamentali

1. **NON creare rotte personalizzate** per la gestione delle lingue (come `language.switch`)
2. **NON creare controller specifici** per la gestione delle lingue
3. Utilizzare **ESCLUSIVAMENTE** le funzioni native del pacchetto `mcamara/laravel-localization`
4. Filament e Folio gestiscono già la localizzazione, non è necessario implementare logiche personalizzate

## Funzioni del Pacchetto `mcamara/laravel-localization`

### Ottenere la Lingua Corrente

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

$currentLocale = LaravelLocalization::getCurrentLocale();
```

### Ottenere le Lingue Supportate

```php
$supportedLocales = LaravelLocalization::getSupportedLocales();
```

### Generare URL Localizzati

```php
$url = LaravelLocalization::getLocalizedURL('it'); // URL per la lingua italiana
$url = LaravelLocalization::getLocalizedURL('en'); // URL per la lingua inglese
```

## Implementazione Corretta del Selettore di Lingue

### Componente Blade

```blade
@props(['currentLocale' => LaravelLocalization::getCurrentLocale()])

<div x-data="{ open: false }" class="relative">
    <button
        @click="open = !open"
        class="flex items-center space-x-2 px-3 py-2 rounded-lg bg-white/10 hover:bg-white/20 transition-colors duration-200"
        aria-label="{{ __('common.language_selector.toggle_button') }}"
    >
        @php
            $flagCode = $currentLocale === 'en' ? 'gb' : $currentLocale;
        @endphp
        <x-ui-flags.{{ $flagCode }} class="w-6 h-4" />
        <span class="text-sm font-medium text-white">{{ strtoupper($currentLocale) }}</span>
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
    >
        <div class="py-1">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                @php
                    $flagCode = $localeCode === 'en' ? 'gb' : $localeCode;
                @endphp
                <a
                    href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}"
                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $currentLocale === $localeCode ? 'bg-gray-50' : '' }}"
                >
                    <x-ui-flags.{{ $flagCode }} class="w-6 h-4 mr-2" />
                    <span>{{ $properties['native'] }}</span>
                    @if($currentLocale === $localeCode)
                        <svg class="w-4 h-4 ml-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
```

## Errori Comuni da Evitare

### 1. Utilizzo di Rotte Personalizzate

```blade
<!-- ERRATO -->
<a href="{{ route('language.switch', 'it') }}">Italiano</a>

<!-- CORRETTO -->
<a href="{{ LaravelLocalization::getLocalizedURL('it') }}">Italiano</a>
```

### 2. Implementazione di Controller per il Cambio Lingua

```php
// ERRATO
Route::get('language/{locale}', 'LanguageController@switch')->name('language.switch');

// CORRETTO
// Non è necessario implementare controller o rotte personalizzate
// Il pacchetto mcamara/laravel-localization gestisce già tutto
```

### 3. Utilizzo di Helper Personalizzati

```php
// ERRATO
function switchLanguage($locale) {
    // Logica personalizzata per il cambio lingua
}

// CORRETTO
// Utilizzare le funzioni native del pacchetto
$url = LaravelLocalization::getLocalizedURL($locale);
```

## Configurazione del Pacchetto

La configurazione del pacchetto `mcamara/laravel-localization` si trova nel file `config/laravellocalization.php`. Le lingue supportate sono definite nell'array `supportedLocales`:

```php
'supportedLocales' => [
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT'],
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    // Altre lingue...
],
```

## Middleware

Il pacchetto `mcamara/laravel-localization` fornisce diversi middleware per gestire la localizzazione:

1. `LaravelLocalizationRoutes`: Applica il prefisso della lingua alle rotte
2. `LaravelLocalizationRedirectFilter`: Reindirizza alla lingua predefinita se la lingua non è specificata
3. `LaravelLocalizationViewPath`: Imposta il percorso delle viste in base alla lingua

## Conclusione

Seguendo queste linee guida, è possibile implementare correttamente la localizzazione  utilizzando il pacchetto `mcamara/laravel-localization` senza creare rotte o controller personalizzati. Questo approccio è coerente con la filosofia di <nome progetto> di utilizzare Filament e Folio per gestire la maggior parte delle funzionalità dell'applicazione.
Seguendo queste linee guida, è possibile implementare correttamente la localizzazione  utilizzando il pacchetto `mcamara/laravel-localization` senza creare rotte o controller personalizzati. Questo approccio è coerente con la filosofia di <nome progetto> di utilizzare Filament e Folio per gestire la maggior parte delle funzionalità dell'applicazione.
Seguendo queste linee guida, è possibile implementare correttamente la localizzazione  utilizzando il pacchetto `mcamara/laravel-localization` senza creare rotte o controller personalizzati. Questo approccio è coerente con la filosofia di <nome progetto> di utilizzare Filament e Folio per gestire la maggior parte delle funzionalità dell'applicazione.
Seguendo queste linee guida, è possibile implementare correttamente la localizzazione  utilizzando il pacchetto `mcamara/laravel-localization` senza creare rotte o controller personalizzati. Questo approccio è coerente con la filosofia di <nome progetto> di utilizzare Filament e Folio per gestire la maggior parte delle funzionalità dell'applicazione.
Seguendo queste linee guida, è possibile implementare correttamente la localizzazione  utilizzando il pacchetto `mcamara/laravel-localization` senza creare rotte o controller personalizzati. Questo approccio è coerente con la filosofia di <nome progetto> di utilizzare Filament e Folio per gestire la maggior parte delle funzionalità dell'applicazione.

---

## laravel-localization-integration

*Consolidated from: `laravel-localization-integration.md`*

title: "Integrazione avanzata: mcamara/laravel-localization + Laravel Folio"
module: "Lang"
type: concept
tags: [migrazione, filament, 4]
created: 2026-07-14
updated: 2026-07-14
qmd: "migrazione filament 4"
related:
  - "./italian-text-refined-audit-report.md"
---
# Integrazione avanzata: mcamara/laravel-localization + Laravel Folio

## 1. Introduzione

Questa guida approfondisce l'integrazione tra [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization) e [Laravel Folio](https://github.com/laravel/folio), con focus su:
- Localizzazione delle route Folio (file-based routing)
- Traduzione degli slug e dei parametri dinamici
- Best practice, criticità e raccomandazioni operative

---

## 2. Analisi tecnica e criticità

### 2.1. Come funziona Folio
- Genera route da `resources/views/pages` (ogni file Blade = una route)
- Supporta parametri dinamici (`[slug].blade.php` → `/qualcosa`)

### 2.2. Come funziona mcamara/laravel-localization
- Wrappa le route in un gruppo con prefisso lingua e middleware
- Permette la traduzione degli slug tramite `lang/{locale}/routes.php`
- Offre helper per URL localizzati e parametri tradotti

### 2.3. Punti critici
- Folio **non supporta nativamente** la traduzione degli slug: serve mappatura manuale
- Cache delle route: usare sempre `php artisan route:trans:cache`
- Parametri dinamici: richiedono override custom (vedi sotto)
- Fallback locale: va gestito sia lato Folio che localization

---

## 3. Passaggi operativi dettagliati

### 3.1. Wrappare tutte le route Folio nel gruppo localizzato

```php
use Laravel\Folio\Facades\Folio;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localizationRedirect', 'localeViewPath'],
], function () {
    Folio::route('pages');
    // ...altre route
});
```

### 3.2. Traduzione degli slug Folio

#### a) File di traduzione degli slug

- Crea `lang/en/routes.php`, `lang/it/routes.php`, ecc.
- Esempio:
  ```php
  // lang/en/routes.php
  return [ 'about' => 'about', 'contact' => 'contact', ];
  // lang/it/routes.php
  return [ 'about' => 'chi-siamo', 'contact' => 'contatti', ];
  ```

#### b) Mappare le route Folio agli slug tradotti

- Folio non supporta la traduzione automatica degli slug: usa i nomi tradotti nei link e, se serve, crea route custom:
  ```php
  Route::get(LaravelLocalization::transRoute('routes.about'), function () {
      return view('pages.about');
  })->name('about');
  ```

#### c) Nei Blade Folio, usa sempre i metodi di LaravelLocalization

```blade
<a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), route('about')) }}">
    {{ __('About us') }}
</a>
```

### 3.3. Gestione avanzata dei parametri dinamici (slug, id, ecc.)

- Per tradurre parametri dinamici (es. `/it/articolo/slug-italiano` vs `/en/article/english-slug`):
  - Implementa l'interfaccia `LocalizedUrlRoutable` nel model
  - Override di `getLocalizedRouteKey($locale)` e `resolveRouteBinding($slug)`

**Esempio:**
```php
class Article extends Model implements \Mcamara\LaravelLocalization\Interfaces\LocalizedUrlRoutable
{
    public function getLocalizedRouteKey($locale)
    {
        return $this->getTranslation('slug', $locale);
    }
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where("slug->{$locale}", $value)->firstOrFail();
    }
}
```

- Richiede che il model abbia un campo `slug` multilingua (es. via spatie/laravel-translatable)

### 3.4. Cache delle route

- Usa **sempre** `php artisan route:trans:cache` per la cache delle route localizzate
- Non usare il comando standard `route:cache`

### 3.5. Testing

- Nei test, imposta il locale con:
  ```php
  protected function refreshApplicationWithLocale($locale)
  {
      self::tearDown();
      putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale);
      self::setUp();
  }
  ```

---

## 4. Best practice e raccomandazioni

- Versiona sempre i file `lang/{locale}/routes.php` e aggiorna la documentazione ad ogni nuova pagina Folio
- Usa sempre i metodi di LaravelLocalization per link e redirect nei Blade
- Testa la localizzazione sia per le route che per i contenuti delle pagine Folio
- Documenta la strategia in `/Modules/Lang/project_docs/laravel-localization-integration.md` e linka dal README
- Per la cache delle route, usa sempre `php artisan route:trans:cache`

---

## 5. Modifiche consigliate ai file del progetto

- Aggiorna `routes/web.php` per wrappare tutte le route Folio nel gruppo localizzato
- Crea/aggiorna i file `lang/{locale}/routes.php` per tutte le lingue supportate
- Nei Blade Folio, sostituisci tutti i link hardcoded con i metodi di LaravelLocalization
- Se usi parametri dinamici multilingua, aggiorna i model per supportare `LocalizedUrlRoutable`
- Documenta la strategia in `/Modules/Lang/project_docs/laravel-localization-integration.md` e linka dal README

---

## 6. Checklist finale

- [ ] Tutte le route Folio sono wrappate dal gruppo localizzato
- [ ] I file `lang/{locale}/routes.php` sono completi e versionati
- [ ] I link nei Blade usano i metodi di LaravelLocalization
- [ ] I parametri dinamici sono gestiti in modo multilingua se necessario
- [ ] La cache delle route usa `route:trans:cache`
- [ ] La documentazione è aggiornata e linkata nei README

---

## 7. Collegamenti utili

- [mcamara/laravel-localization - GitHub](https://github.com/mcamara/laravel-localization)
- [Laravel Folio - Docs](https://laravel.com/project_docs/12.x/folio)
- [Traduzione route con mcamara](https://github.com/mcamara/laravel-localization#translated-routes)
- [Esempio di override parametri dinamici](https://github.com/mcamara/laravel-localization#translatable-route-parameters)
# Integrazione avanzata: mcamara/laravel-localization + Laravel Folio

## 1. Introduzione

Questa guida approfondisce l'integrazione tra [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization) e [Laravel Folio](https://github.com/laravel/folio), con focus su:
- Localizzazione delle route Folio (file-based routing)
- Traduzione degli slug e dei parametri dinamici
- Best practice, criticità e raccomandazioni operative

---

## 2. Analisi tecnica e criticità

### 2.1. Come funziona Folio
- Genera route da `resources/views/pages` (ogni file Blade = una route)
- Supporta parametri dinamici (`[slug].blade.php` → `/qualcosa`)

### 2.2. Come funziona mcamara/laravel-localization
- Wrappa le route in un gruppo con prefisso lingua e middleware
- Permette la traduzione degli slug tramite `lang/{locale}/routes.php`
- Offre helper per URL localizzati e parametri tradotti

### 2.3. Punti critici
- Folio **non supporta nativamente** la traduzione degli slug: serve mappatura manuale
- Cache delle route: usare sempre `php artisan route:trans:cache`
- Parametri dinamici: richiedono override custom (vedi sotto)
- Fallback locale: va gestito sia lato Folio che localization

---

## 3. Passaggi operativi dettagliati

### 3.1. Wrappare tutte le route Folio nel gruppo localizzato

```php
use Laravel\Folio\Facades\Folio;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localizationRedirect', 'localeViewPath'],
], function () {
    Folio::route('pages');
    // ...altre route
});
```

### 3.2. Traduzione degli slug Folio

#### a) File di traduzione degli slug

- Crea `lang/en/routes.php`, `lang/it/routes.php`, ecc.
- Esempio:
  ```php
  // lang/en/routes.php
  return [ 'about' => 'about', 'contact' => 'contact', ];
  // lang/it/routes.php
  return [ 'about' => 'chi-siamo', 'contact' => 'contatti', ];
  ```

#### b) Mappare le route Folio agli slug tradotti

- Folio non supporta la traduzione automatica degli slug: usa i nomi tradotti nei link e, se serve, crea route custom:
  ```php
  Route::get(LaravelLocalization::transRoute('routes.about'), function () {
      return view('pages.about');
  })->name('about');
  ```

#### c) Nei Blade Folio, usa sempre i metodi di LaravelLocalization

```blade
<a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), route('about')) }}">
    {{ __('About us') }}
</a>
```

### 3.3. Gestione avanzata dei parametri dinamici (slug, id, ecc.)

- Per tradurre parametri dinamici (es. `/it/articolo/slug-italiano` vs `/en/article/english-slug`):
  - Implementa l'interfaccia `LocalizedUrlRoutable` nel model
  - Override di `getLocalizedRouteKey($locale)` e `resolveRouteBinding($slug)`

**Esempio:**
```php
class Article extends Model implements \Mcamara\LaravelLocalization\Interfaces\LocalizedUrlRoutable
{
    public function getLocalizedRouteKey($locale)
    {
        return $this->getTranslation('slug', $locale);
    }
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where("slug->{$locale}", $value)->firstOrFail();
    }
}
```

- Richiede che il model abbia un campo `slug` multilingua (es. via spatie/laravel-translatable)

### 3.4. Cache delle route

- Usa **sempre** `php artisan route:trans:cache` per la cache delle route localizzate
- Non usare il comando standard `route:cache`

### 3.5. Testing

- Nei test, imposta il locale con:
  ```php
  protected function refreshApplicationWithLocale($locale)
  {
      self::tearDown();
      putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale);
      self::setUp();
  }
  ```

---

## 4. Best practice e raccomandazioni

- Versiona sempre i file `lang/{locale}/routes.php` e aggiorna la documentazione ad ogni nuova pagina Folio
- Usa sempre i metodi di LaravelLocalization per link e redirect nei Blade
- Testa la localizzazione sia per le route che per i contenuti delle pagine Folio
- Documenta la strategia in `/Modules/Lang/docs/laravel-localization-integration.md` e linka dal README
- Per la cache delle route, usa sempre `php artisan route:trans:cache`

---

## 5. Modifiche consigliate ai file del progetto

- Aggiorna `routes/web.php` per wrappare tutte le route Folio nel gruppo localizzato
- Crea/aggiorna i file `lang/{locale}/routes.php` per tutte le lingue supportate
- Nei Blade Folio, sostituisci tutti i link hardcoded con i metodi di LaravelLocalization
- Se usi parametri dinamici multilingua, aggiorna i model per supportare `LocalizedUrlRoutable`
- Documenta la strategia in `/Modules/Lang/docs/laravel-localization-integration.md` e linka dal README

---

## 6. Checklist finale

- [ ] Tutte le route Folio sono wrappate dal gruppo localizzato
- [ ] I file `lang/{locale}/routes.php` sono completi e versionati
- [ ] I link nei Blade usano i metodi di LaravelLocalization
- [ ] I parametri dinamici sono gestiti in modo multilingua se necessario
- [ ] La cache delle route usa `route:trans:cache`
- [ ] La documentazione è aggiornata e linkata nei README

---

## 7. Collegamenti utili

- [mcamara/laravel-localization - GitHub](https://github.com/mcamara/laravel-localization)
- [Laravel Folio - Docs](https://laravel.com/docs/12.x/folio)
- [Traduzione route con mcamara](https://github.com/mcamara/laravel-localization#translated-routes)
- [Esempio di override parametri dinamici](https://github.com/mcamara/laravel-localization#translatable-route-parameters)

---

## laravel-localization-livewire-volt

*Consolidated from: `laravel-localization-livewire-volt.md`*

title: "Integrazione di mcamara/laravel-localization con Livewire Volt"
module: "Lang"
type: concept
tags: [ottimizzazioni, correzioni]
created: 2026-07-14
updated: 2026-07-14
qmd: "ottimizzazioni correzioni"
related:
  - "./italian-text-refined-audit-report.md"
---
# Integrazione di mcamara/laravel-localization con Livewire Volt

## Obiettivo
Fornire una guida pratica per integrare la localizzazione delle rotte e dei contenuti con Livewire Volt, sfruttando le potenzialità di mcamara/laravel-localization.

---

## 1. Cos'è Livewire Volt?
Volt è una sintassi semplificata per creare componenti Livewire, che permette di scrivere componenti reattivi direttamente in Blade, con una sintassi più concisa e moderna.

---

## 2. Sfida dell'integrazione
- **Volt** genera componenti Livewire che vengono richiamati tramite rotte Laravel.
- **mcamara/laravel-localization** lavora a livello di routing, aggiungendo il prefisso della lingua e gestendo la localizzazione delle rotte.
- È necessario assicurarsi che i componenti Volt siano accessibili tramite rotte localizzate e che i contenuti siano tradotti correttamente.

---

## 3. Best Practice per l'integrazione

### a) Registrazione delle rotte Volt nel gruppo localizzato
Assicurati che tutte le rotte che richiamano componenti Volt siano dichiarate all'interno del gruppo di localizzazione:

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        // Rotte Volt
        Volt::route('dashboard', 'dashboard');
        Volt::route('profile', 'profile');
        // ...altre rotte Volt
    }
);
```

**Nota:**
Se usi Folio, assicurati che anche le pagine Volt siano registrate nel gruppo localizzato.

---

### b) Traduzione dei contenuti nei componenti Volt
- Usa sempre le funzioni di traduzione Laravel (`__()`, `@lang`) all'interno dei template Blade dei componenti Volt.
- Esempio:
  ```blade
  <h1>{{ __('Welcome') }}</h1>
  <button>{{ __('Logout') }}</button>
  ```
- Per i messaggi dinamici, usa la funzione `__()` anche nel codice PHP del componente Volt:
  ```php
  $this->notify(__('Profile updated successfully!'));
  ```

---

### c) Gestione dei redirect e dei link
- Quando effettui redirect o generi link all'interno dei componenti Volt, usa sempre i nomi delle rotte localizzate:
  ```php
  return redirect()->route(LaravelLocalization::getCurrentLocale().'.dashboard');
  ```
- Nei link Blade:
  ```blade
  <a href="{{ route(LaravelLocalization::getCurrentLocale().'.profile') }}">{{ __('Profile') }}</a>
  ```

---

### d) Middleware e Locale
- Se hai logica custom che dipende dalla lingua, puoi accedere alla lingua corrente tramite:
  ```php
  app()->getLocale()
  ```
- Se necessario, puoi forzare la lingua in un componente Volt:
  ```php
  app()->setLocale($locale);
  ```

---

### e) Traduzione delle rotte Volt
- Se vuoi tradurre anche i path delle rotte Volt (es: `/it/bacheca` invece di `/it/dashboard`), usa la funzionalità di route translation mapping di mcamara/laravel-localization.
- Esempio in `resources/lang/it/routes.php`:
  ```php
  return [
      'dashboard' => 'bacheca',
      'profile' => 'profilo',
  ];
  ```
- E registra le rotte Volt usando le chiavi tradotte:
  ```php
  Volt::route(__('routes.dashboard'), 'dashboard');
  ```

---

## 4. Checklist
- [ ] Tutte le rotte Volt sono dentro il gruppo localizzato.
- [ ] Tutti i testi nei componenti Volt sono tradotti con `__()` o `@lang`.
- [ ] Tutti i link e redirect usano nomi di rotte localizzate.
- [ ] Se necessario, i path delle rotte Volt sono tradotti tramite mapping.
- [ ] Documenta ogni eccezione o workaround in `/Modules/Lang/project_docs/laravel-localization-livewire-volt.md`.

---

## 5. FAQ e problemi comuni
- **Perché il componente Volt non si localizza?**
  Verifica che la rotta sia dentro il gruppo localizzato e che il middleware sia applicato.
- **Come traduco i path delle rotte Volt?**
  Usa il mapping delle rotte in `lang/{locale}/routes.php` e registra le rotte Volt con le chiavi tradotte.
- **Come gestisco la lingua nei redirect?**
  Usa sempre `LaravelLocalization::getCurrentLocale()` nei redirect e nei link.

---

## 6. Modifiche consigliate ai file del progetto
- **web.php**:
  Sposta tutte le rotte Volt dentro il gruppo localizzato.
- **lang/{locale}/routes.php**:
  Aggiungi mapping per i path delle rotte Volt se vuoi path tradotti.
- **Componenti Volt**:
  Verifica che tutti i testi siano tradotti e che i redirect usino le rotte localizzate.
- **Documentazione**:
  Aggiorna sempre `/Modules/Lang/project_docs/laravel-localization-livewire-volt.md` ogni volta che cambi la struttura delle rotte o dei componenti Volt.

---

## 7. Best Practices operative (.mdc)

Vedi file `.cursor/rules/laravel-localization-livewire-volt.mdc` e `.windsurf/rules/laravel-localization-livewire-volt.mdc` per checklist e regole operative.
# Integrazione di mcamara/laravel-localization con Livewire Volt

## Obiettivo
Fornire una guida pratica per integrare la localizzazione delle rotte e dei contenuti con Livewire Volt, sfruttando le potenzialità di mcamara/laravel-localization.

---

## 1. Cos'è Livewire Volt?
Volt è una sintassi semplificata per creare componenti Livewire, che permette di scrivere componenti reattivi direttamente in Blade, con una sintassi più concisa e moderna.

---

## 2. Sfida dell'integrazione
- **Volt** genera componenti Livewire che vengono richiamati tramite rotte Laravel.
- **mcamara/laravel-localization** lavora a livello di routing, aggiungendo il prefisso della lingua e gestendo la localizzazione delle rotte.
- È necessario assicurarsi che i componenti Volt siano accessibili tramite rotte localizzate e che i contenuti siano tradotti correttamente.

---

## 3. Best Practice per l'integrazione

### a) Registrazione delle rotte Volt nel gruppo localizzato
Assicurati che tutte le rotte che richiamano componenti Volt siano dichiarate all'interno del gruppo di localizzazione:

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        // Rotte Volt
        Volt::route('dashboard', 'dashboard');
        Volt::route('profile', 'profile');
        // ...altre rotte Volt
    }
);
```

**Nota:**
Se usi Folio, assicurati che anche le pagine Volt siano registrate nel gruppo localizzato.

---

### b) Traduzione dei contenuti nei componenti Volt
- Usa sempre le funzioni di traduzione Laravel (`__()`, `@lang`) all'interno dei template Blade dei componenti Volt.
- Esempio:
  ```blade
  <h1>{{ __('Welcome') }}</h1>
  <button>{{ __('Logout') }}</button>
  ```
- Per i messaggi dinamici, usa la funzione `__()` anche nel codice PHP del componente Volt:
  ```php
  $this->notify(__('Profile updated successfully!'));
  ```

---

### c) Gestione dei redirect e dei link
- Quando effettui redirect o generi link all'interno dei componenti Volt, usa sempre i nomi delle rotte localizzate:
  ```php
  return redirect()->route(LaravelLocalization::getCurrentLocale().'.dashboard');
  ```
- Nei link Blade:
  ```blade
  <a href="{{ route(LaravelLocalization::getCurrentLocale().'.profile') }}">{{ __('Profile') }}</a>
  ```

---

### d) Middleware e Locale
- Se hai logica custom che dipende dalla lingua, puoi accedere alla lingua corrente tramite:
  ```php
  app()->getLocale()
  ```
- Se necessario, puoi forzare la lingua in un componente Volt:
  ```php
  app()->setLocale($locale);
  ```

---

### e) Traduzione delle rotte Volt
- Se vuoi tradurre anche i path delle rotte Volt (es: `/it/bacheca` invece di `/it/dashboard`), usa la funzionalità di route translation mapping di mcamara/laravel-localization.
- Esempio in `resources/lang/it/routes.php`:
  ```php
  return [
      'dashboard' => 'bacheca',
      'profile' => 'profilo',
  ];
  ```
- E registra le rotte Volt usando le chiavi tradotte:
  ```php
  Volt::route(__('routes.dashboard'), 'dashboard');
  ```

---

## 4. Checklist
- [ ] Tutte le rotte Volt sono dentro il gruppo localizzato.
- [ ] Tutti i testi nei componenti Volt sono tradotti con `__()` o `@lang`.
- [ ] Tutti i link e redirect usano nomi di rotte localizzate.
- [ ] Se necessario, i path delle rotte Volt sono tradotti tramite mapping.
- [ ] Documenta ogni eccezione o workaround in `/Modules/Lang/docs/laravel-localization-livewire-volt.md`.

---

## 5. FAQ e problemi comuni
- **Perché il componente Volt non si localizza?**
  Verifica che la rotta sia dentro il gruppo localizzato e che il middleware sia applicato.
- **Come traduco i path delle rotte Volt?**
  Usa il mapping delle rotte in `lang/{locale}/routes.php` e registra le rotte Volt con le chiavi tradotte.
- **Come gestisco la lingua nei redirect?**
  Usa sempre `LaravelLocalization::getCurrentLocale()` nei redirect e nei link.

---

## 6. Modifiche consigliate ai file del progetto
- **web.php**:
  Sposta tutte le rotte Volt dentro il gruppo localizzato.
- **lang/{locale}/routes.php**:
  Aggiungi mapping per i path delle rotte Volt se vuoi path tradotti.
- **Componenti Volt**:
  Verifica che tutti i testi siano tradotti e che i redirect usino le rotte localizzate.
- **Documentazione**:
  Aggiorna sempre `/Modules/Lang/docs/laravel-localization-livewire-volt.md` ogni volta che cambi la struttura delle rotte o dei componenti Volt.

---

## 7. Best Practices operative (.mdc)

Vedi file `.cursor/rules/laravel-localization-livewire-volt.mdc` e `.windsurf/rules/laravel-localization-livewire-volt.mdc` per checklist e regole operative.

---

## laravel-localization-mcaa-reference

*Consolidated from: `laravel-localization-mcaa-reference.md`*

title: "mcamara/laravel-localization: Riferimento per moduli e temi"
module: "Lang"
type: concept
tags: [migrazione, filament, 4]
created: 2026-07-14
updated: 2026-07-14
qmd: "migrazione filament 4"
related:
  - "./italian-text-refined-audit-report.md"
---
# mcamara/laravel-localization: Riferimento per moduli e temi

## Scopo

Questo documento riassume come il package [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization) è usato nel progetto e come ogni modulo/tema può sfruttarlo.

## Funzionalità principali

- **Prefisso lingua in URL**: tutte le rotte pubbliche localizzate sono sotto `/{locale}/...` (es. `/it/`, `/en/events`).
- **Redirect**: richiesta senza locale → redirect con locale (da session, cookie o Accept-Language).
- **Helper**: generazione URL localizzati, locale corrente, lingue supportate, ordine lingue.
- **Translated routes** (opzionale): segmenti URL tradotti per lingua (es. `/en/about`, `/es/acerca`) tramite `lang/{locale}/routes.php` e `transRoute()`.
- **Route cache**: usare `php artisan route:trans:cache` e trait `LoadsTranslatedCachedRoutes`; non usare `route:cache` per le rotte localizzate.

## Configurazione

- **File**: `config/laravellocalization.php`.
- **supportedLocales**: array di lingue (es. `it`, `en`) con `name`, `script`, `native`, `regional`.
- **hideDefaultLocaleInURL**: se true, la lingua di default non appare in URL.
- **useAcceptLanguageHeader**: rilevamento lingua da browser.
- **localesOrder**: ordine delle lingue (es. per lo switcher).
- **httpMethodsIgnored**: metodi HTTP da non processare per redirect (es. POST, PUT, PATCH, DELETE).

## Uso obbligatorio in Blade (tutti i moduli e temi)

### Link

- Usare **sempre** `LaravelLocalization::localizeUrl($path)` per link verso pagine localizzate (path senza prefisso lingua).

```blade
<a href="{{ LaravelLocalization::localizeUrl('/') }}">Home</a>
<a href="{{ LaravelLocalization::localizeUrl('/events') }}">Events</a>
<a href="{{ LaravelLocalization::localizeUrl('/login') }}">Login</a>
```

### Form

- L’**action** di form (login, register, submit) deve essere localizzata, altrimenti il redirect cambia POST in GET e la validazione usa il locale sbagliato.

```blade
<form action="{{ LaravelLocalization::localizeUrl('/login') }}" method="POST">
```

### Language selector

- Per mantenere la pagina corrente e solo cambiare lingua: **`LaravelLocalization::getLocalizedURL($localeCode, null, [], true)`** (il quarto parametro `true` forza il locale in URL anche se `hideDefaultLocaleInURL` è true).
- Locale corrente: **`LaravelLocalization::getCurrentLocale()`**.
- Elenco lingue: **`LaravelLocalization::getSupportedLocales()`** o **`getLocalesOrder()`**.

## Come aiuta il modulo Lang

- Il modulo Lang **dipende** da mcamara/laravel-localization.
- Fornisce componenti Livewire/Blade per lo switcher lingua e le traduzioni.
- Tutte le view e i componenti che generano link devono usare gli helper sopra; non costruire URL a mano con `app()->getLocale()`.

## Come aiuta Cms (Folio + Volt)

- **FolioVoltServiceProvider** legge `config('laravellocalization.supportedLocales')` e registra Folio con **`->uri($locale)`** per ogni lingua.
- Middleware: **LocaleSessionRedirect**, **LaravelLocalizationRedirectFilter**; per ogni request viene impostato **`app()->setLocale($locale)`**.
- Le pagine pubbliche sono quindi sempre sotto `/{locale}/...`. Qualsiasi link da componenti (header, footer, blocchi) deve usare **`LaravelLocalization::localizeUrl($path)`**.

## Come aiuta Meetup (modulo e tema)

- Link a eventi, community, sponsors, login, register: **`LaravelLocalization::localizeUrl('/events')`** ecc.
- Header e footer: tutti i link già localizzati con `localizeUrl()`; language switcher con **getLocalizedURL($code, null, [], true)**.
- Nuovi link aggiunti in futuro devono seguire lo stesso pattern.

## Come aiuta User (auth)

- Form di login, registrazione, logout: **action** localizzata (es. `LaravelLocalization::localizeUrl('/login')`, `localizeUrl('/logout')`).
- Redirect dopo login/registrazione: verso URL localizzati.

## Test

- Nei test il package non conosce la rotta (bootstrap prima della request). Usare **refreshApplicationWithLocale($locale)**:
  - **putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale)** prima della request.
  - **tearDown** (o afterEach) per pulire l’env.
- Effettuare le request con prefisso locale (es. `$this->get('/en/')`).

Vedi README del package per PHPUnit e Pest.

## Riferimenti

- [Regola progetto](../../../../.cursor/rules/laravel-localization-mcamara.mdc)
- [Memoria](../../../../.cursor/memories/laravel-localization-mcamara.md)
- [README mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
- [Meetup localization standard](../../meetup/docs/localization-standard.md)
- [Themes/Meetup localization standard](../../../themes/meetup/docs/localization-standard.md)

---

## laravel-localization-mcamara-reference

*Consolidated from: `laravel-localization-mcamara-reference.md`*

title: "mcamara/laravel-localization: Riferimento per moduli e temi"
module: "Lang"
type: concept
tags: [migration, filament, 4]
created: 2026-07-14
updated: 2026-07-14
qmd: "migration filament 4"
related:
  - "./italian-text-refined-audit-report.md"
---
# mcamara/laravel-localization: Riferimento per moduli e temi

## Scopo

Questo documento riassume come il package [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization) è usato nel progetto e come ogni modulo/tema può sfruttarlo.

## Funzionalità principali

- **Prefisso lingua in URL**: tutte le rotte pubbliche localizzate sono sotto `/{locale}/...` (es. `/it/`, `/en/events`).
- **Redirect**: richiesta senza locale → redirect con locale (da session, cookie o Accept-Language).
- **Helper**: generazione URL localizzati, locale corrente, lingue supportate, ordine lingue.
- **Translated routes** (opzionale): segmenti URL tradotti per lingua (es. `/en/about`, `/es/acerca`) tramite `lang/{locale}/routes.php` e `transRoute()`.
- **Route cache**: usare `php artisan route:trans:cache` e trait `LoadsTranslatedCachedRoutes`; non usare `route:cache` per le rotte localizzate.

## Configurazione

- **File**: `config/laravellocalization.php`.
- **supportedLocales**: array di lingue (es. `it`, `en`) con `name`, `script`, `native`, `regional`.
- **hideDefaultLocaleInURL**: se true, la lingua di default non appare in URL.
- **useAcceptLanguageHeader**: rilevamento lingua da browser.
- **localesOrder**: ordine delle lingue (es. per lo switcher).
- **httpMethodsIgnored**: metodi HTTP da non processare per redirect (es. POST, PUT, PATCH, DELETE).

## Uso obbligatorio in Blade (tutti i moduli e temi)

### Link

- Usare **sempre** `LaravelLocalization::localizeUrl($path)` per link verso pagine localizzate (path senza prefisso lingua).

```blade
<a href="{{ LaravelLocalization::localizeUrl('/') }}">Home</a>
<a href="{{ LaravelLocalization::localizeUrl('/events') }}">Events</a>
<a href="{{ LaravelLocalization::localizeUrl('/login') }}">Login</a>
```

### Form

- L’**action** di form (login, register, submit) deve essere localizzata, altrimenti il redirect cambia POST in GET e la validazione usa il locale sbagliato.

```blade
<form action="{{ LaravelLocalization::localizeUrl('/login') }}" method="POST">
```

### Language selector

- Per mantenere la pagina corrente e solo cambiare lingua: **`LaravelLocalization::getLocalizedURL($localeCode, null, [], true)`** (il quarto parametro `true` forza il locale in URL anche se `hideDefaultLocaleInURL` è true).
- Locale corrente: **`LaravelLocalization::getCurrentLocale()`**.
- Elenco lingue: **`LaravelLocalization::getSupportedLocales()`** o **`getLocalesOrder()`**.

## Come aiuta il modulo Lang

- Il modulo Lang **dipende** da mcamara/laravel-localization.
- Fornisce componenti Livewire/Blade per lo switcher lingua e le traduzioni.
- Tutte le view e i componenti che generano link devono usare gli helper sopra; non costruire URL a mano con `app()->getLocale()`.

## Come aiuta Cms (Folio + Volt)

- **FolioVoltServiceProvider** legge `config('laravellocalization.supportedLocales')` e registra Folio con **`->uri($locale)`** per ogni lingua.
- Middleware: **LocaleSessionRedirect**, **LaravelLocalizationRedirectFilter**; per ogni request viene impostato **`app()->setLocale($locale)`**.
- Le pagine pubbliche sono quindi sempre sotto `/{locale}/...`. Qualsiasi link da componenti (header, footer, blocchi) deve usare **`LaravelLocalization::localizeUrl($path)`**.

## Come aiuta Meetup (modulo e tema)

- Link a eventi, community, sponsors, login, register: **`LaravelLocalization::localizeUrl('/events')`** ecc.
- Header e footer: tutti i link già localizzati con `localizeUrl()`; language switcher con **getLocalizedURL($code, null, [], true)**.
- Nuovi link aggiunti in futuro devono seguire lo stesso pattern.

## Come aiuta User (auth)

- Form di login, registrazione, logout: **action** localizzata (es. `LaravelLocalization::localizeUrl('/login')`, `localizeUrl('/logout')`).
- Redirect dopo login/registrazione: verso URL localizzati.

## Test

- Nei test il package non conosce la rotta (bootstrap prima della request). Usare **refreshApplicationWithLocale($locale)**:
  - **putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale)** prima della request.
  - **tearDown** (o afterEach) per pulire l’env.
- Effettuare le request con prefisso locale (es. `$this->get('/en/')`).

Vedi README del package per PHPUnit e Pest.

## Riferimenti

- [Regola progetto](../../../../.cursor/rules/laravel-localization-mcamara.mdc)
- [Memoria](../../../../.cursor/memories/laravel-localization-mcamara.md)
- [README mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
- [Meetup localization standard](../../Meetup/docs/localization-standard.md)
- [Themes/Meetup localization standard](../../../Themes/Meetup/docs/localization-standard.md)

---

## laravel-localization-reference

*Consolidated from: `laravel-localization-reference.md`*

title: "Laravel Localization Reference"
module: "Lang"
type: concept
tags: [lang, service, helper, text]
created: 2026-07-14
updated: 2026-07-14
qmd: "lang service helper text fix"
related:
  - "./italian-text-refined-audit-report.md"
---
# Laravel Localization Reference

## Overview

This document provides the complete reference for `mcamara/laravel-localization` package (v2.x) used in the <nome progetto> project.

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
- [Laravel 13 Compatibility](#laravel-compatibility)

---

## laravel-localization-usage

*Consolidated from: `laravel-localization-usage.md`*

title: "Utilizzo di mcamara/laravel-localization"
module: "Lang"
type: concept
tags: [migrazione, filament, 4]
created: 2026-07-14
updated: 2026-07-14
qmd: "migrazione filament 4"
related:
  - "./italian-text-refined-audit-report.md"
---
# Utilizzo di mcamara/laravel-localization

## Collegamenti correlati
- [README modulo Lang](./README.md)
- [Best Practices Chiavi di Traduzione](translation-keys-best-practices.md)
- [Implementazione Header con Selettore Lingua](/laravel/Modules/User/docs/HEADER_LANGUAGE_SELECTOR_WITH_FLAGS.md)
- [README modulo Lang](./README.md)
- [Best Practices Chiavi di Traduzione](translation-keys-best-practices.md)
- [Implementazione Header con Selettore Lingua](/laravel/Modules/User/docs/HEADER_LANGUAGE_SELECTOR_WITH_FLAGS.md)
- [README modulo Lang](./README.md)
- [Best Practices Chiavi di Traduzione](translation-keys-best-practices.md)
- [Best Practices Chiavi di Traduzione](../../translation-keys-best-practices.md)
- [Implementazione Header con Selettore Lingua](/laravel/Modules/User/docs/HEADER_LANGUAGE_SELECTOR_WITH_FLAGS.md)
- [README modulo Lang](./README.md)
- [Best Practices Chiavi di Traduzione](../../translation-keys-best-practices.md)
- [Implementazione Header con Selettore Lingua](/laravel/Modules/User/docs/HEADER_LANGUAGE_SELECTOR_WITH_FLAGS.md)
- [README modulo Lang](./README.md)
- [Best Practices Chiavi di Traduzione](../../translation-keys-best-practices.md)
- [Implementazione Header con Selettore Lingua](/laravel/Modules/User/docs/HEADER_LANGUAGE_SELECTOR_WITH_FLAGS.md)
- [Collegamenti Documentazione](/docs/collegamenti-documentazione.md)

## Panoramica

Questo documento descrive come utilizzare correttamente il pacchetto `mcamara/laravel-localization`  per gestire la localizzazione delle URL e l'interfaccia multilingua.

## Regole Fondamentali

1. **MAI creare rotte aggiungendole in web.php**
   - Filament e Folio gestiscono automaticamente le rotte
   - Non creare file di rotte personalizzati

2. **MAI creare controller personalizzati**
   - Utilizzare le funzionalità di Filament e Folio
   - Evitare di creare controller HTTP tradizionali

3. **Gestione della Localizzazione**
   - Utilizzare SEMPRE il pacchetto mcamara/laravel-localization
   - Seguire la documentazione ufficiale: https://github.com/mcamara/laravel-localization
   - Assicurarsi che tutti gli URL includano il prefisso della lingua

## Configurazione

Il pacchetto `mcamara/laravel-localization` è già configurato . La configurazione si trova in:
- `config/laravellocalization.php`

Le lingue supportate sono definite nella chiave `supportedLocales` di questo file.

## Utilizzo Corretto in Blade

### 1. Ottenere la Lingua Corrente

```php
// CORRETTO - Utilizzare LaravelLocalization::getCurrentLocale()
$currentLocale = LaravelLocalization::getCurrentLocale();

// ERRATO - Non utilizzare app()->getLocale() direttamente
$currentLocale = app()->getLocale();
```

### 2. Ottenere le Lingue Supportate

```php
// CORRETTO - Utilizzare LaravelLocalization::getSupportedLocales()
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    // $properties contiene 'name', 'script', 'native', 'regional'
    <span>{{ $properties['native'] }}</span>
@endforeach

// ERRATO - Non utilizzare array hardcoded
@foreach(['it' => 'Italiano', 'en' => 'English'] as $locale => $label)
    <span>{{ $label }}</span>
@endforeach
```

### 3. Generare URL Localizzati

```php
// CORRETTO - Utilizzare LaravelLocalization::getLocalizedURL()
<a href="{{ LaravelLocalization::getLocalizedURL('en') }}">English</a>

// ERRATO - Non costruire URL manualmente
<a href="{{ '/en' . substr(request()->getPathInfo(), 3) }}">English</a>
```

### 4. Esempio di Selettore Lingua Completo

```php
@props(['currentLocale' => LaravelLocalization::getCurrentLocale()])

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" @click.away="open = false">
        <x-dynamic-component
            :component="'ui-flags.' . ($currentLocale === 'en' ? 'gb' : $currentLocale)"
        />
        <span>{{ LaravelLocalization::getSupportedLocales()[$currentLocale]['native'] }}</span>
    </button>

    <div x-show="open">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                <x-dynamic-component
                    :component="'ui-flags.' . ($localeCode === 'en' ? 'gb' : $localeCode)"
                />
                <span>{{ $properties['native'] }}</span>
            </a>
        @endforeach
    </div>
</div>
```

## Utilizzo delle Bandiere SVG

Le bandiere SVG sono disponibili in `Modules/UI/resources/svg/flags` e sono autoregistrate come componenti Blade con il prefisso `ui-flags`.

### Utilizzo Corretto

```php
// Per la bandiera italiana
<x-ui-flags.it class="w-6 h-6" />

// Per la bandiera inglese (UK)
<x-ui-flags.gb class="w-6 h-6" />

// Utilizzo dinamico
@php
    $flagCode = $locale === 'en' ? 'gb' : $locale;
@endphp
<x-dynamic-component :component="'ui-flags.' . $flagCode" class="w-6 h-6" />
```

## Middleware e Configurazione

Il pacchetto utilizza diversi middleware per gestire la localizzazione:

1. `LaravelLocalizationRedirectFilter` - Reindirizza all'URL localizzato
2. `LaravelLocalizationViewPath` - Imposta il percorso della vista localizzata
3. `LaravelLocalizationRoutes` - Gestisce le rotte localizzate

Questi middleware sono già configurati  e non è necessario modificarli.

## Errori Comuni da Evitare

1. **Utilizzo di route() per rotte localizzate**
   ```php
   // ERRATO
   <a href="{{ LaravelLocalization::getLocalizedURL('it') }}">Italiano</a>

   // CORRETTO
   <a href="{{ LaravelLocalization::getLocalizedURL('it') }}">Italiano</a>
   ```

2. **Costruzione manuale degli URL localizzati**
   ```php
   // ERRATO
   <a href="{{ '/' . $locale . '/pages/about' }}">About</a>

   // CORRETTO
   <a href="{{ LaravelLocalization::getLocalizedURL($locale, route('pages.about')) }}">About</a>
   ```

3. **Utilizzo di app()->setLocale() direttamente**
   ```php
   // ERRATO
   @php app()->setLocale('it') @endphp

   // CORRETTO - Lasciare che il middleware gestisca la locale
   // Non modificare manualmente la locale
   ```

## Esempi Pratici

### Esempio 1: Header con Selettore Lingua

```php
// /laravel/Themes/One/resources/views/components/blocks/language-selector.blade.php
@props(['currentLocale' => LaravelLocalization::getCurrentLocale()])

<div class="relative inline-block text-left" x-data="{ open: false }">
    <button @click="open = !open" @click.away="open = false">
        @php
            $flagCode = $currentLocale === 'en' ? 'gb' : $currentLocale;
        @endphp
        <x-dynamic-component :component="'ui-flags.' . $flagCode" />
        <span>{{ LaravelLocalization::getSupportedLocales()[$currentLocale]['native'] }}</span>
    </button>

    <div x-show="open">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            @php
                $flagCode = $localeCode === 'en' ? 'gb' : $localeCode;
            @endphp
            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                <x-dynamic-component :component="'ui-flags.' . $flagCode" />
                <span>{{ $properties['native'] }}</span>
            </a>
        @endforeach
    </div>
</div>
```

### Esempio 2: Configurazione JSON per Header

```json
{
    "name": {
        "it": "Selettore Lingua",
        "en": "Language Selector"
    },
    "type": "language-selector",
    "data": {
        "view": "pub_theme::components.blocks.language-selector"
    }
}
```

## Componenti Bandiera

### Implementazione Corretta
```blade
{{-- Per icone semplici --}}
<x-filament::icon
    :icon="'ui-flags.' . $flagCode"
    class="h-5 w-5 text-gray-500 dark:text-gray-400"
    :label="$flagCode"
    aria-hidden="true"
/>

{{-- Per pulsanti con icone --}}
<x-filament::icon-button
    :icon="'ui-flags.' . $flagCode"
    class="h-5 w-5"
    :label="$flagCode"
    aria-hidden="true"
/>
```

### Vantaggi
1. **Coerenza**: Usa i componenti nativi di Filament
2. **Tema Scuro**: Supporto automatico
3. **Accessibilità**: Componenti ottimizzati
4. **Manutenibilità**: Codice pulito e standardizzato

## Riferimenti

- [Documentazione ufficiale mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
- [Documentazione Laravel Localization](https://laravel.com/docs/10.x/localization)
- [Blade Components Documentation](https://laravel.com/docs/10.x/blade#components)
# Utilizzo di mcamara/laravel-localization

## Collegamenti correlati
- [README modulo Lang](./README.md)
- [Best Practices Chiavi di Traduzione](translation-keys-best-practices.md)
- [Implementazione Header con Selettore Lingua](/laravel/Modules/User/docs/HEADER_LANGUAGE_SELECTOR_WITH_FLAGS.md)
- [README modulo Lang](./README.md)
- [Best Practices Chiavi di Traduzione](translation-keys-best-practices.md)
- [Implementazione Header con Selettore Lingua](/laravel/Modules/User/docs/HEADER_LANGUAGE_SELECTOR_WITH_FLAGS.md)
- [README modulo Lang](./README.md)
- [Best Practices Chiavi di Traduzione](translation-keys-best-practices.md)
- [Best Practices Chiavi di Traduzione](../../translation-keys-best-practices.md)
- [Implementazione Header con Selettore Lingua](/laravel/Modules/User/docs/HEADER_LANGUAGE_SELECTOR_WITH_FLAGS.md)
- [README modulo Lang](./README.md)
- [Best Practices Chiavi di Traduzione](../../translation-keys-best-practices.md)
- [Implementazione Header con Selettore Lingua](/laravel/Modules/User/docs/HEADER_LANGUAGE_SELECTOR_WITH_FLAGS.md)
- [README modulo Lang](./README.md)
- [Best Practices Chiavi di Traduzione](../../translation-keys-best-practices.md)
- [Implementazione Header con Selettore Lingua](/laravel/Modules/User/docs/HEADER_LANGUAGE_SELECTOR_WITH_FLAGS.md)
- [Collegamenti Documentazione](/docs/collegamenti-documentazione.md)

## Panoramica

Questo documento descrive come utilizzare correttamente il pacchetto `mcamara/laravel-localization`  per gestire la localizzazione delle URL e l'interfaccia multilingua.

## Regole Fondamentali

1. **MAI creare rotte aggiungendole in web.php**
   - Filament e Folio gestiscono automaticamente le rotte
   - Non creare file di rotte personalizzati

2. **MAI creare controller personalizzati**
   - Utilizzare le funzionalità di Filament e Folio
   - Evitare di creare controller HTTP tradizionali

3. **Gestione della Localizzazione**
   - Utilizzare SEMPRE il pacchetto mcamara/laravel-localization
   - Seguire la documentazione ufficiale: https://github.com/mcamara/laravel-localization
   - Assicurarsi che tutti gli URL includano il prefisso della lingua

## Configurazione

Il pacchetto `mcamara/laravel-localization` è già configurato . La configurazione si trova in:
- `config/laravellocalization.php`

Le lingue supportate sono definite nella chiave `supportedLocales` di questo file.

## Utilizzo Corretto in Blade

### 1. Ottenere la Lingua Corrente

```php
// CORRETTO - Utilizzare LaravelLocalization::getCurrentLocale()
$currentLocale = LaravelLocalization::getCurrentLocale();

// ERRATO - Non utilizzare app()->getLocale() direttamente
$currentLocale = app()->getLocale();
```

### 2. Ottenere le Lingue Supportate

```php
// CORRETTO - Utilizzare LaravelLocalization::getSupportedLocales()
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    // $properties contiene 'name', 'script', 'native', 'regional'
    <span>{{ $properties['native'] }}</span>
@endforeach

// ERRATO - Non utilizzare array hardcoded
@foreach(['it' => 'Italiano', 'en' => 'English'] as $locale => $label)
    <span>{{ $label }}</span>
@endforeach
```

### 3. Generare URL Localizzati

```php
// CORRETTO - Utilizzare LaravelLocalization::getLocalizedURL()
<a href="{{ LaravelLocalization::getLocalizedURL('en') }}">English</a>

// ERRATO - Non costruire URL manualmente
<a href="{{ '/en' . substr(request()->getPathInfo(), 3) }}">English</a>
```

### 4. Esempio di Selettore Lingua Completo

```php
@props(['currentLocale' => LaravelLocalization::getCurrentLocale()])

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" @click.away="open = false">
        <x-dynamic-component
            :component="'ui-flags.' . ($currentLocale === 'en' ? 'gb' : $currentLocale)"
        />
        <span>{{ LaravelLocalization::getSupportedLocales()[$currentLocale]['native'] }}</span>
    </button>

    <div x-show="open">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                <x-dynamic-component
                    :component="'ui-flags.' . ($localeCode === 'en' ? 'gb' : $localeCode)"
                />
                <span>{{ $properties['native'] }}</span>
            </a>
        @endforeach
    </div>
</div>
```

## Utilizzo delle Bandiere SVG

Le bandiere SVG sono disponibili in `Modules/UI/resources/svg/flags` e sono autoregistrate come componenti Blade con il prefisso `ui-flags`.

### Utilizzo Corretto

```php
// Per la bandiera italiana
<x-ui-flags.it class="w-6 h-6" />

// Per la bandiera inglese (UK)
<x-ui-flags.gb class="w-6 h-6" />

// Utilizzo dinamico
@php
    $flagCode = $locale === 'en' ? 'gb' : $locale;
@endphp
<x-dynamic-component :component="'ui-flags.' . $flagCode" class="w-6 h-6" />
```

## Middleware e Configurazione

Il pacchetto utilizza diversi middleware per gestire la localizzazione:

1. `LaravelLocalizationRedirectFilter` - Reindirizza all'URL localizzato
2. `LaravelLocalizationViewPath` - Imposta il percorso della vista localizzata
3. `LaravelLocalizationRoutes` - Gestisce le rotte localizzate

Questi middleware sono già configurati  e non è necessario modificarli.

## Errori Comuni da Evitare

1. **Utilizzo di route() per rotte localizzate**
   ```php
   // ERRATO
   <a href="{{ LaravelLocalization::getLocalizedURL('it') }}">Italiano</a>

   // CORRETTO
   <a href="{{ LaravelLocalization::getLocalizedURL('it') }}">Italiano</a>
   ```

2. **Costruzione manuale degli URL localizzati**
   ```php
   // ERRATO
   <a href="{{ '/' . $locale . '/pages/about' }}">About</a>

   // CORRETTO
   <a href="{{ LaravelLocalization::getLocalizedURL($locale, route('pages.about')) }}">About</a>
   ```

3. **Utilizzo di app()->setLocale() direttamente**
   ```php
   // ERRATO
   @php app()->setLocale('it') @endphp

   // CORRETTO - Lasciare che il middleware gestisca la locale
   // Non modificare manualmente la locale
   ```

## Esempi Pratici

### Esempio 1: Header con Selettore Lingua

```php
// /laravel/Themes/One/resources/views/components/blocks/language-selector.blade.php
@props(['currentLocale' => LaravelLocalization::getCurrentLocale()])

<div class="relative inline-block text-left" x-data="{ open: false }">
    <button @click="open = !open" @click.away="open = false">
        @php
            $flagCode = $currentLocale === 'en' ? 'gb' : $currentLocale;
        @endphp
        <x-dynamic-component :component="'ui-flags.' . $flagCode" />
        <span>{{ LaravelLocalization::getSupportedLocales()[$currentLocale]['native'] }}</span>
    </button>

    <div x-show="open">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            @php
                $flagCode = $localeCode === 'en' ? 'gb' : $localeCode;
            @endphp
            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                <x-dynamic-component :component="'ui-flags.' . $flagCode" />
                <span>{{ $properties['native'] }}</span>
            </a>
        @endforeach
    </div>
</div>
```

### Esempio 2: Configurazione JSON per Header

```json
{
    "name": {
        "it": "Selettore Lingua",
        "en": "Language Selector"
    },
    "type": "language-selector",
    "data": {
        "view": "pub_theme::components.blocks.language-selector"
    }
}
```

## Componenti Bandiera

### Implementazione Corretta
```blade
{{-- Per icone semplici --}}
<x-filament::icon
    :icon="'ui-flags.' . $flagCode"
    class="h-5 w-5 text-gray-500 dark:text-gray-400"
    :label="$flagCode"
    aria-hidden="true"
/>

{{-- Per pulsanti con icone --}}
<x-filament::icon-button
    :icon="'ui-flags.' . $flagCode"
    class="h-5 w-5"
    :label="$flagCode"
    aria-hidden="true"
/>
```

### Vantaggi
1. **Coerenza**: Usa i componenti nativi di Filament
2. **Tema Scuro**: Supporto automatico
3. **Accessibilità**: Componenti ottimizzati
4. **Manutenibilità**: Codice pulito e standardizzato

## Riferimenti

- [Documentazione ufficiale mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
- [Documentazione Laravel Localization](https://laravel.com/docs/10.x/localization)
- [Blade Components Documentation](https://laravel.com/docs/10.x/blade#components)
- [Blade Components Documentation](https://laravel.com/docs/10.x/blade#components)
- [Blade Components Documentation](https://laravel.com/docs/10.x/blade#components)
- [Blade Components Documentation](https://laravel.com/docs/10.x/blade#components)
- [Blade Components Documentation](https://laravel.com/docs/10.x/blade#components)

---

## laravel-localization

*Consolidated from: `laravel-localization.md`*

title: "Laravel Localization"
module: "Lang"
type: concept
tags: [lang, service, helper, text]
created: 2026-07-14
updated: 2026-07-14
qmd: "lang service helper text fix"
related:
  - "./italian-text-refined-audit-report.md"
---
# Laravel Localization

## Introduzione

Il pacchetto `mcamara/laravel-localization` offre un modo semplice per implementare la localizzazione in applicazioni Laravel. Questo documento analizza le funzionalità del pacchetto e suggerisce modifiche utili per il nostro progetto `<nome progetto>`.

## Funzionalità Principali

- **Gestione delle Lingue**: Supporta la gestione di più lingue tramite URL, sessioni o cookie.
- **Middleware**: Include middleware per il redirect basato sulla lingua.
- **URL Localizzati**: Genera URL specifici per ogni lingua supportata.
- **Route Tradotte**: Permette la traduzione dei parametri delle route.
- **Helper**: Fornisce funzioni helper per ottenere informazioni sulla lingua corrente e supportata.

## Analisi del Progetto `<nome progetto>`

Dopo aver analizzato il progetto, ho notato che la localizzazione degli URL è già implementata seguendo la regola fondamentale di includere il prefisso della lingua come primo segmento del percorso (`/{locale}/{sezione}/{risorsa}`). Tuttavia, ci sono aree che possono essere migliorate:

1. **Middleware per Redirect**: Potremmo implementare `LocaleSessionRedirect` o `LocaleCookieRedirect` per gestire automaticamente il redirect basato sulla lingua dell'utente.
2. **URL Localizzati**: Utilizzare gli helper del pacchetto per generare URL localizzati in modo più efficiente.
3. **Route Tradotte**: Implementare la traduzione dei parametri delle route per una user experience più coerente.
4. **Language Selector**: Creare un selettore di lingua per permettere agli utenti di cambiare lingua facilmente.

## Modifiche Suggerite

- **Configurazione del Pacchetto**: Aggiungere `mcamara/laravel-localization` come dipendenza nel `composer.json` e configurare i file di configurazione per supportare le lingue desiderate (es. italiano e inglese).
- **Registrazione del Middleware**: Registrare i middleware forniti dal pacchetto per gestire i redirect basati sulla lingua.
- **Implementazione di Helper**: Utilizzare gli helper per ottenere informazioni sulla lingua corrente e generare URL localizzati.
- **Creazione di un Selettore di Lingua**: Aggiungere un componente UI per permettere agli utenti di selezionare la lingua preferita.
- **Documentazione**: Aggiornare la documentazione del progetto per includere istruzioni sull'uso del pacchetto e sulle convenzioni di localizzazione.

## Conclusione

L'implementazione di `mcamara/laravel-localization` nel progetto `<nome progetto>` migliorerebbe la gestione della localizzazione, rendendo l'applicazione più accessibile e user-friendly per utenti di diverse lingue. Le modifiche suggerite non richiedono cambiamenti significativi al codice esistente, ma offrono un notevole miglioramento in termini di funzionalità e esperienza utente.
# Laravel Localization

## Introduzione

Il pacchetto `mcamara/laravel-localization` offre un modo semplice per implementare la localizzazione in applicazioni Laravel. Questo documento analizza le funzionalità del pacchetto e suggerisce modifiche utili per il nostro progetto `<nome progetto>`.

## Funzionalità Principali

- **Gestione delle Lingue**: Supporta la gestione di più lingue tramite URL, sessioni o cookie.
- **Middleware**: Include middleware per il redirect basato sulla lingua.
- **URL Localizzati**: Genera URL specifici per ogni lingua supportata.
- **Route Tradotte**: Permette la traduzione dei parametri delle route.
- **Helper**: Fornisce funzioni helper per ottenere informazioni sulla lingua corrente e supportata.

## Analisi del Progetto `<nome progetto>`

Dopo aver analizzato il progetto, ho notato che la localizzazione degli URL è già implementata seguendo la regola fondamentale di includere il prefisso della lingua come primo segmento del percorso (`/{locale}/{sezione}/{risorsa}`). Tuttavia, ci sono aree che possono essere migliorate:

1. **Middleware per Redirect**: Potremmo implementare `LocaleSessionRedirect` o `LocaleCookieRedirect` per gestire automaticamente il redirect basato sulla lingua dell'utente.
2. **URL Localizzati**: Utilizzare gli helper del pacchetto per generare URL localizzati in modo più efficiente.
3. **Route Tradotte**: Implementare la traduzione dei parametri delle route per una user experience più coerente.
4. **Language Selector**: Creare un selettore di lingua per permettere agli utenti di cambiare lingua facilmente.

## Modifiche Suggerite

- **Configurazione del Pacchetto**: Aggiungere `mcamara/laravel-localization` come dipendenza nel `composer.json` e configurare i file di configurazione per supportare le lingue desiderate (es. italiano e inglese).
- **Registrazione del Middleware**: Registrare i middleware forniti dal pacchetto per gestire i redirect basati sulla lingua.
- **Implementazione di Helper**: Utilizzare gli helper per ottenere informazioni sulla lingua corrente e generare URL localizzati.
- **Creazione di un Selettore di Lingua**: Aggiungere un componente UI per permettere agli utenti di selezionare la lingua preferita.
- **Documentazione**: Aggiornare la documentazione del progetto per includere istruzioni sull'uso del pacchetto e sulle convenzioni di localizzazione.

## Conclusione

L'implementazione di `mcamara/laravel-localization` nel progetto `<nome progetto>` migliorerebbe la gestione della localizzazione, rendendo l'applicazione più accessibile e user-friendly per utenti di diverse lingue. Le modifiche suggerite non richiedono cambiamenti significativi al codice esistente, ma offrono un notevole miglioramento in termini di funzionalità e esperienza utente.
# Laravel Localization Metadata for Cursor

## Context

This document provides metadata for Cursor about the integration of `mcamara/laravel-localization` into the `<nome progetto>` project.
# Laravel Localization Metadata for Cursor

## Context

This document provides metadata for Cursor about the integration of `mcamara/laravel-localization` into the `<nome progetto>` project.

## Key Points

- **Package**: `mcamara/laravel-localization`
- **Purpose**: Enhance localization capabilities in Laravel applications.
- **Suggested Actions**: 
  - Add package to `composer.json`.
  - Configure supported languages.
  - Register middleware for language redirects.
  - Implement language selector UI component.
- **Benefits**: Improved user experience with localized URLs and translated routes.

# Regola: Vietato usare chiavi che terminano con `.navigation` nei file di traduzione

- Usa sempre la struttura array per navigation:
  ```php
  'navigation' => [
      'label' => 'Gestione Pazienti',
      'group' => 'Pazienti',
      'icon' => 'heroicon-o-user-group',
      'color' => 'primary',
  ],
  ```
- Consulta anche:
  - [translation-keys-best-practices.md](../translation-keys-best-practices.md)
  - [translation_keys_rules.md](../translation_keys_rules.md)
  - [filament-translations.md](../filament-translations.md)
  - [translation-keys-best-practices.md](../../translation-keys-best-practices.md)
  - [translation_keys_rules.md](../../translation_keys_rules.md)
  - [filament-translations.md](../../filament-translations.md)
  - [docs <nome progetto>](../../../<nome progetto>/docs/translations.md)
## Modifiche Suggerite

- **Configurazione del Pacchetto**: Aggiungere `mcamara/laravel-localization` come dipendenza nel `composer.json` e configurare i file di configurazione per supportare le lingue desiderate (es. italiano e inglese).
- **Registrazione del Middleware**: Registrare i middleware forniti dal pacchetto per gestire i redirect basati sulla lingua.
- **Implementazione di Helper**: Utilizzare gli helper per ottenere informazioni sulla lingua corrente e generare URL localizzati.
- **Creazione di un Selettore di Lingua**: Aggiungere un componente UI per permettere agli utenti di selezionare la lingua preferita.
- **Documentazione**: Aggiornare la documentazione del progetto per includere istruzioni sull'uso del pacchetto e sulle convenzioni di localizzazione.

## Conclusione

L'implementazione di `mcamara/laravel-localization` nel progetto `<nome progetto>` migliorerebbe la gestione della localizzazione, rendendo l'applicazione più accessibile e user-friendly per utenti di diverse lingue. Le modifiche suggerite non richiedono cambiamenti significativi al codice esistente, ma offrono un notevole miglioramento in termini di funzionalità e esperienza utente.
# Laravel Localization

## Introduzione

Il pacchetto `mcamara/laravel-localization` offre un modo semplice per implementare la localizzazione in applicazioni Laravel. Questo documento analizza le funzionalità del pacchetto e suggerisce modifiche utili per il nostro progetto `<nome progetto>`.

## Funzionalità Principali

- **Gestione delle Lingue**: Supporta la gestione di più lingue tramite URL, sessioni o cookie.
- **Middleware**: Include middleware per il redirect basato sulla lingua.
- **URL Localizzati**: Genera URL specifici per ogni lingua supportata.
- **Route Tradotte**: Permette la traduzione dei parametri delle route.
- **Helper**: Fornisce funzioni helper per ottenere informazioni sulla lingua corrente e supportata.

## Analisi del Progetto `<nome progetto>`

Dopo aver analizzato il progetto, ho notato che la localizzazione degli URL è già implementata seguendo la regola fondamentale di includere il prefisso della lingua come primo segmento del percorso (`/{locale}/{sezione}/{risorsa}`). Tuttavia, ci sono aree che possono essere migliorate:

1. **Middleware per Redirect**: Potremmo implementare `LocaleSessionRedirect` o `LocaleCookieRedirect` per gestire automaticamente il redirect basato sulla lingua dell'utente.
2. **URL Localizzati**: Utilizzare gli helper del pacchetto per generare URL localizzati in modo più efficiente.
3. **Route Tradotte**: Implementare la traduzione dei parametri delle route per una user experience più coerente.
4. **Language Selector**: Creare un selettore di lingua per permettere agli utenti di cambiare lingua facilmente.

## Modifiche Suggerite

- **Configurazione del Pacchetto**: Aggiungere `mcamara/laravel-localization` come dipendenza nel `composer.json` e configurare i file di configurazione per supportare le lingue desiderate (es. italiano e inglese).
- **Registrazione del Middleware**: Registrare i middleware forniti dal pacchetto per gestire i redirect basati sulla lingua.
- **Implementazione di Helper**: Utilizzare gli helper per ottenere informazioni sulla lingua corrente e generare URL localizzati.
- **Creazione di un Selettore di Lingua**: Aggiungere un componente UI per permettere agli utenti di selezionare la lingua preferita.
- **Documentazione**: Aggiornare la documentazione del progetto per includere istruzioni sull'uso del pacchetto e sulle convenzioni di localizzazione.

## Conclusione

L'implementazione di `mcamara/laravel-localization` nel progetto `<nome progetto>` migliorerebbe la gestione della localizzazione, rendendo l'applicazione più accessibile e user-friendly per utenti di diverse lingue. Le modifiche suggerite non richiedono cambiamenti significativi al codice esistente, ma offrono un notevole miglioramento in termini di funzionalità e esperienza utente.

---

## laravel_localization

*Consolidated from: `laravel_localization.md`*

title: "Laravel Localization"
module: "Lang"
type: concept
tags: [migration, filament]
created: 2026-07-14
updated: 2026-07-14
qmd: "migration filament"
related:
  - "./italian-text-refined-audit-report.md"
---
# Laravel Localization

## Introduzione

Il pacchetto `mcamara/laravel-localization` offre un modo semplice per implementare la localizzazione in applicazioni Laravel. Questo documento analizza le funzionalità del pacchetto e suggerisce modifiche utili per il nostro progetto `<nome progetto>corrente`.

## Funzionalità Principali

- **Gestione delle Lingue**: Supporta la gestione di più lingue tramite URL, sessioni o cookie.
- **Middleware**: Include middleware per il redirect basato sulla lingua.
- **URL Localizzati**: Genera URL specifici per ogni lingua supportata.
- **Route Tradotte**: Permette la traduzione dei parametri delle route.
- **Helper**: Fornisce funzioni helper per ottenere informazioni sulla lingua corrente e supportata.

## Analisi del Progetto `<nome progetto>corrente`

Dopo aver analizzato il progetto, ho notato che la localizzazione degli URL è già implementata seguendo la regola fondamentale di includere il prefisso della lingua come primo segmento del percorso (`/{locale}/{sezione}/{risorsa}`). Tuttavia, ci sono aree che possono essere migliorate:

1. **Middleware per Redirect**: Potremmo implementare `LocaleSessionRedirect` o `LocaleCookieRedirect` per gestire automaticamente il redirect basato sulla lingua dell'utente.
2. **URL Localizzati**: Utilizzare gli helper del pacchetto per generare URL localizzati in modo più efficiente.
3. **Route Tradotte**: Implementare la traduzione dei parametri delle route per una user experience più coerente.
4. **Language Selector**: Creare un selettore di lingua per permettere agli utenti di cambiare lingua facilmente.

## Modifiche Suggerite

- **Configurazione del Pacchetto**: Aggiungere `mcamara/laravel-localization` come dipendenza nel `composer.json` e configurare i file di configurazione per supportare le lingue desiderate (es. italiano e inglese).
- **Registrazione del Middleware**: Registrare i middleware forniti dal pacchetto per gestire i redirect basati sulla lingua.
- **Implementazione di Helper**: Utilizzare gli helper per ottenere informazioni sulla lingua corrente e generare URL localizzati.
- **Creazione di un Selettore di Lingua**: Aggiungere un componente UI per permettere agli utenti di selezionare la lingua preferita.
- **Documentazione**: Aggiornare la documentazione del progetto per includere istruzioni sull'uso del pacchetto e sulle convenzioni di localizzazione.

## Conclusione

L'implementazione di `mcamara/laravel-localization` nel progetto `<nome progetto>corrente` migliorerebbe la gestione della localizzazione, rendendo l'applicazione più accessibile e user-friendly per utenti di diverse lingue. Le modifiche suggerite non richiedono cambiamenti significativi al codice esistente, ma offrono un notevole miglioramento in termini di funzionalità e esperienza utente.

---

## laravel_localization_complete

*Consolidated from: `laravel_localization_complete.md`*

title: "Guida Completa a Laravel Localization"
module: "Lang"
type: concept
tags: [migration, filament]
created: 2026-07-14
updated: 2026-07-14
qmd: "migration filament"
related:
  - "./italian-text-refined-audit-report.md"
---
# Guida Completa a Laravel Localization

## Introduzione

Il pacchetto `mcamara/laravel-localization` è una soluzione potente per implementare la localizzazione in applicazioni Laravel. Questa guida, basata sul corso di Laravel Daily, fornisce istruzioni dettagliate per l'installazione, la configurazione e l'uso del pacchetto nel progetto `<nome progetto>corrente`.

## Funzionalità Principali

- **Gestione delle Lingue**: Supporta la gestione di più lingue tramite URL, sessioni o cookie.
- **Middleware**: Include middleware per il redirect basato sulla lingua.
- **URL Localizzati**: Genera URL specifici per ogni lingua supportata.
- **Route Tradotte**: Permette la traduzione dei parametri delle route.
- **Helper**: Fornisce funzioni helper per ottenere informazioni sulla lingua corrente e supportata.

## Installazione

Per installare il pacchetto, seguire questi passaggi:

1. **Installazione del Pacchetto**:
   ```bash
   composer require mcamara/laravel-localization
   ```

2. **Pubblicazione del File di Configurazione**:
   ```bash
   php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
   ```

3. **Registrazione del Middleware**:
   Modificare il file `app/Http/Kernel.php` per aggiungere i middleware necessari:
   ```php
   protected $routeMiddleware = [
       // ...
       'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
       'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
       'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
       'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
       'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class
   ];
   ```

## Configurazione delle Route

Per configurare le route con il prefisso della lingua, modificare il file `routes/web.php`:

```php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect']
], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    // altre route...
    require __DIR__ . '/auth.php';
});
```

Questo codice:
- Aggiunge il prefisso della lingua agli URL (es. `/en/` o `/es/`).
- Reindirizza l'utente alla lingua corretta se non la sta utilizzando.
- Tenta di indovinare la lingua dell'utente basandosi sulle impostazioni del browser.

## Abilitazione di Diverse Lingue

Modificare il file `config/laravellocalization.php` per abilitare le lingue desiderate:

```php
'supportedLocales' => [
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'Italiano', 'regional' => 'it_IT'],
    'es' => ['name' => 'Spanish', 'script' => 'Latn', 'native' => 'español', 'regional' => 'es_ES'],
],
```

## Aggiunta di un Selettore di Lingua

Aggiungere un selettore di lingua alla navigazione dell'applicazione modificando il file `resources/views/layouts/navigation.blade.php`:

```php
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <x-nav-link rel="alternate" hreflang="{{ $localeCode }}"
                :active="$localeCode === app()->getLocale()"
                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
        {{ ucfirst($properties['native']) }}
    </x-nav-link>
@endforeach
```

## Correzione della Cache delle Route

Per utilizzare la cache delle route con questo pacchetto, modificare il file `app/Providers/RouteServiceProvider.php`:

```php
class RouteServiceProvider extends ServiceProvider
{
    use \Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;
    // ...
}
```

Utilizzare i seguenti comandi per la cache delle route:
- Invece di `php artisan route:cache`, usare `php artisan route:trans:cache`.
- Invece di `php artisan route:clear`, usare `php artisan route:trans:clear`.

## Visualizzazione di Tutte le Route

Per visualizzare un elenco dettagliato delle route tradotte, utilizzare:
```bash
php artisan route:trans:list {locale}
```

## Funzionalità Estese del Pacchetto

### Mostrare o Nascondere la Lingua Predefinita nell'URL

Modificare `config/laravellocalization.php` per nascondere la lingua predefinita:

```php
'hideDefaultLocaleInURL' => true,
```

### Ignorare Route Specifiche

Per ignorare la localizzazione di alcune route, aggiungerle a `config/laravellocalization.php`:

```php
'urlsIgnored' => [
    '/queue-check',
],
```

### Traduzione delle Route

Per tradurre le route, aggiungere il middleware `localize` al gruppo di route in `routes/web.php`:

```php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localize']
], function () {
    // route tradotte...
});
```

Creare file di traduzione per le route in `resources/lang/{locale}/routes.php`. Ad esempio:

- Per l'inglese (`resources/lang/en/routes.php`):
  ```php
  return [
      'dashboard' => 'dashboard',
  ];
  ```

- Per l'italiano (`resources/lang/it/routes.php`):
  ```php
  return [
      'dashboard' => 'cruscotto',
  ];
  ```

Modificare le route per utilizzare la traduzione:

```php
Route::get(LaravelLocalization::transRoute('routes.dashboard'), [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
```

## Problemi con le Route Tradotte

Si noti che il metodo POST non funziona con le route tradotte. Utilizzare `LaravelLocalization::localizeUrl($route)` invece di `route()` per i form POST.

## Integrazione con Livewire

Se si utilizza Livewire, potrebbe essere necessario modificare il file `App/Providers/AppServiceProvider.php` per gestire correttamente gli aggiornamenti:

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Livewire\Livewire;

public function boot()
{
    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/livewire/update', $handle)
            ->middleware('web')
            ->prefix(LaravelLocalization::setLocale());
    });
    // ...
}
```

## Conclusione

Il pacchetto `mcamara/laravel-localization` offre un controllo versatile sulla localizzazione delle route. Combinato con la traduzione di testi statici, rende l'applicazione multilingue facile da gestire e user-friendly. Questa guida fornisce tutte le informazioni necessarie per implementare il pacchetto nel progetto `<nome progetto>corrente`, rispettando le convenzioni di localizzazione degli URL e migliorando l'esperienza utente.

## Risorse

- Repository GitHub: [LaravelDaily/laravel11-localization-course](https://github.com/LaravelDaily/laravel11-localization-course/tree/lesson/packages/mcamara-laravel-localization)
- Documentazione Ufficiale: [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)

---

## laravel_localization_folio

*Consolidated from: `laravel_localization_folio.md`*

title: "Integrazione tra mcamara/laravel-localization e Laravel Folio"
module: "Lang"
type: concept
tags: [phpstan, level10, fixes, 1]
created: 2026-07-14
updated: 2026-07-14
qmd: "phpstan level10 fixes 1"
related:
  - "./italian-text-refined-audit-report.md"
---
# Integrazione tra mcamara/laravel-localization e Laravel Folio

## Obiettivo
Fornire una guida pratica e dettagliata per integrare la localizzazione delle rotte (mcamara/laravel-localization) con il routing file-based di **Laravel Folio**, garantendo URL localizzati, contenuti multilingua e compatibilità con le best practice Laravel.

---

## 1. Cos'è Laravel Folio?
- **Folio** è il sistema di routing file-based introdotto in Laravel 11+, che permette di definire le rotte tramite la struttura delle cartelle e dei file in `resources/views/pages`.
- Ogni file Blade in questa cartella diventa una rotta accessibile via URL.

---

## 2. Sfida dell'integrazione
- **mcamara/laravel-localization** si basa su gruppi di rotte Laravel classici (`Route::group`) per aggiungere il prefisso della lingua e gestire la localizzazione.
- **Folio** genera le rotte in modo automatico, senza passare da `routes/web.php`.
- È necessario assicurarsi che tutte le rotte Folio siano "wrappate" dal middleware di localizzazione e che i path siano localizzati.

---

## 3. Best Practice per l'integrazione

### a) Registrazione delle rotte Folio nel gruppo localizzato
**Soluzione consigliata:**
- Registra Folio **dentro** il gruppo di localizzazione, esattamente come faresti con le rotte classiche.

Esempio in `routes/web.php`:
```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Laravel\Folio\Folio;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Folio::route(resource_path('views/pages'));
        // ...altre rotte classiche se necessario
    }
);
```
**Risultato:**  
Tutte le pagine Folio saranno accessibili con il prefisso lingua (`/it/about`, `/en/about`, ecc).

---

### b) Traduzione dei path delle pagine Folio
- Di default, i path Folio sono basati sul nome del file (es: `about.blade.php` → `/about`).
- Per avere path localizzati (es: `/it/chi-siamo` invece di `/it/about`), sfrutta la funzionalità di **route translation mapping** di mcamara/laravel-localization.

**Procedura:**
1. Crea i file di mapping in `lang/{locale}/routes.php`:
    ```php
    // lang/it/routes.php
    return [
        'about' => 'chi-siamo',
        'contact' => 'contatti',
    ];
    ```
2. Quando generi link o usi redirect, usa sempre:
    ```php
    route(LaravelLocalization::transRoute('routes.about'))
    ```
3. Se vuoi che anche Folio generi le rotte con path tradotti, valuta di creare symlink o duplicati dei file Blade con nomi localizzati, oppure implementa una logica custom (ad oggi Folio non supporta nativamente il mapping automatico dei path tramite array di traduzioni).

**Nota:**  
Se la localizzazione dei path è fondamentale, valuta se usare ancora le rotte classiche per le pagine che richiedono path tradotti, oppure contribuisci/estendi Folio per supportare questa feature.

---

### c) Middleware e sessione
- Il middleware di mcamara/laravel-localization gestisce la lingua tramite sessione, cookie e URL.
- Assicurati che il middleware sia applicato a tutte le rotte Folio (come nell'esempio sopra).
- Se usi componenti Livewire/Volt nelle pagine Folio, la lingua sarà già impostata correttamente.

---

### d) Language Switcher
- Usa sempre gli helper di mcamara per generare i link di cambio lingua:
    ```blade
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
            {{ $properties['native'] }}
        </a>
    @endforeach
    ```
- Inserisci il language switcher in un layout Blade condiviso da tutte le pagine Folio.

---

### e) Caching delle rotte
- Per cache-izzare le rotte localizzate, usa **solo**:
    ```
    php artisan route:trans:cache
    ```
  e **non** il comando standard `route:cache`.
- Segui le istruzioni aggiornate nella [documentazione ufficiale](https://github.com/mcamara/laravel-localization#caching-routes) per Laravel 11+.

---

## 4. FAQ e problemi comuni
- **Perché una pagina Folio non viene localizzata?**  
  Verifica che la registrazione di Folio sia dentro il gruppo di localizzazione e che il middleware sia applicato.
- **Come traduco i path delle pagine Folio?**  
  Ad oggi serve una soluzione custom (symlink, duplicati, override di Folio) oppure accetta che i path siano in inglese ma i contenuti localizzati.
- **Come gestisco redirect e link?**  
  Usa sempre `route(LaravelLocalization::transRoute('routes.nome'))` per generare URL localizzati.
- **Come gestisco i form POST?**  
  Usa sempre l'helper `localizeURL` per l'action dei form:
  ```blade
  <form action="{{ LaravelLocalization::localizeURL('/contatti') }}" method="POST">
  ```

---

## 5. Checklist
- [ ] Folio è registrato dentro il gruppo localizzato.
- [ ] Tutti i link e redirect usano helper di localizzazione.
- [ ] I path delle pagine sono localizzati (se necessario) tramite mapping o workaround.
- [ ] Il language switcher è presente in tutti i layout.
- [ ] La cache delle rotte usa solo `route:trans:cache`.

---

## 6. Modifiche consigliate ai file del progetto
- **routes/web.php**:  
  Sposta la registrazione di Folio dentro il gruppo localizzato.
- **lang/{locale}/routes.php**:  
  Aggiungi mapping per i path delle pagine Folio se vuoi path tradotti.
- **layouts Blade**:  
  Inserisci il language switcher in tutti i layout usati da Folio.
- **Documentazione**:  
  Aggiorna sempre questa guida ogni volta che cambi la struttura delle pagine o la strategia di localizzazione.

---

## 7. Collegamenti correlati
- [Documentazione ufficiale mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
- [Documentazione Laravel Folio](https://laravel.com/docs/12.x/folio)
- [Esempio di mapping rotte](https://github.com/mcamara/laravel-localization#translated-routes)
- [FAQ e problemi comuni]([project-root]/laravel/Modules/Lang/docs/translations-faq.md)
- [FAQ e problemi comuni](../../translations-faq.md)
- [Guida language switcher]([project-root]/laravel/Modules/Lang/docs/README.md)

---

**Se vuoi che aggiorni direttamente la documentazione o vuoi esempi pratici di override/mapping path Folio, chiedi pure!** 

---

## laravel_localization_folio_integration

*Consolidated from: `laravel_localization_folio_integration.md`*

title: "Integration of Mcamara Laravel Localization with Laravel Folio"
module: "Lang"
type: concept
tags: [phpstan, level10, fixes, 1]
created: 2026-07-14
updated: 2026-07-14
qmd: "phpstan level10 fixes 1"
related:
  - "./italian-text-refined-audit-report.md"
---
# Integration of Mcamara Laravel Localization with Laravel Folio

## Overview
In the `<nome progetto>corrente` project, providing a multi-language experience with localized URLs is essential for accessibility and SEO. This document explores the integration between [`mcamara/laravel-localization`](https://github.com/mcamara/laravel-localization) and [`laravel/folio`](https://github.com/laravel/folio), ensuring that our page routing system supports language prefixes and locale-specific content in a healthcare context.

## Purpose of Integration
- **Localized URLs**: Enable language prefixes in URLs (e.g., `/en/services`, `/it/servizi`) for better user experience and SEO.
- **Dynamic Page Routing**: Use Laravel Folio for managing page routes directly from Blade files while maintaining locale awareness.
- **Seamless Language Switching**: Ensure users can switch languages without breaking page navigation or losing context.

## Analysis of Components

### Mcamara Laravel Localization
This package provides robust tools for:
- Managing localized routes with prefixes.
- Middleware to detect and set the application locale based on URL or user preference.
- Helpers for generating localized URLs and handling language switching.

Key features relevant to Folio integration:
- **Route Translation**: Automatically prepends locale to routes.
- **Locale Detection**: Determines the current locale from URL segments.
- **URL Generation**: Generates URLs with the appropriate locale prefix via the `route()` and `url()` helpers.

### Laravel Folio
Folio is a page-based routing system for Laravel that:
- Maps URLs directly to Blade view files based on their file path.
- Simplifies routing for static or semi-static pages by eliminating the need for explicit route definitions.
- Supports middleware application at the page level.

Challenges with localization:
- Folio's automatic routing does not inherently account for locale prefixes.
- Direct file-to-URL mapping may conflict with dynamic locale segments in URLs.

## Integration Challenges
1. **URL Structure Conflict**: Folio maps URLs directly to file paths (e.g., `/about` to `resources/views/pages/about.blade.php`), but `laravel-localization` prepends a locale (e.g., `/en/about`), potentially causing mismatches.
2. **Locale Detection**: Ensuring Folio pages respect the locale set by `laravel-localization` middleware.
3. **Language Switching**: Maintaining the correct URL structure when users switch languages on Folio-managed pages.
4. **Route Generation**: Adapting Folio's simplicity with `laravel-localization`'s need for localized route names or prefixes.

## Integration Solution

### Step 1: Installation and Setup
Ensure both packages are installed:
```bash
composer require mcamara/laravel-localization
composer require laravel/folio
```
Publish configuration for `laravel-localization`:
```bash
php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
```
Set up Folio as per Laravel documentation, typically in a service provider or `routes/web.php`:
```php
use Laravel\Folio\Folio;

Folio::path(resource_path('views/pages'))->middleware([
    '*'.':'.\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRoutes::class,
    '*'.':'.\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRedirectFilter::class,
    '*'.':'.\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationViewPath::class,
]);
```

### Step 2: Configuration
Configure supported locales in `config/laravellocalization.php`:
```php
'supportedLocales' => [
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'Italiano', 'regional' => 'it_IT'],
],
'useAcceptLanguageHeader' => true,
'hideDefaultLocaleInURL' => false,
```

### Step 3: Middleware Integration
Ensure that Folio routes are processed by `laravel-localization` middleware to handle locale detection and redirection. In a service provider (e.g., `AppServiceProvider`):
```php
public function boot()
{
    Folio::path(resource_path('views/pages'))->middleware([
        \Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRoutes::class,
        \Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRedirectFilter::class,
        \Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationViewPath::class,
    ]);
}
```
Alternatively, apply middleware globally in `bootstrap/app.php` to cover all routes, including Folio:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->append(\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRoutes::class);
    $middleware->append(\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRedirectFilter::class);
    $middleware->append(\Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationViewPath::class);
})
```

### Step 4: Handling Folio Routes with Locale Prefixes
Folio's direct mapping needs adjustment to account for locale prefixes. Since Folio doesn't natively support dynamic prefixes, we can use a custom approach:

#### Option 1: Custom Folio Middleware
Create a middleware to strip the locale prefix before Folio processes the route:
```php
// app/Http/Middleware/HandleFolioLocalization.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class HandleFolioLocalization
{
    public function handle(Request $request, Closure $next)
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $path = $request->path();
        if (strpos($path, $locale) === 0) {
            $newPath = substr($path, strlen($locale) + 1);
            $request->server->set('REQUEST_URI', '/' . $newPath);
        }
        return $next($request);
    }
}
```
Register this middleware specifically for Folio routes after the `LaravelLocalization` middleware:
```php
Folio::path(resource_path('views/pages'))->middleware([
    \Mcamara\LaravelLocalization\Middlewares\LaravelLocalizationRoutes::class,
    \App\Http\Middleware\HandleFolioLocalization::class,
]);
```

#### Option 2: Folder Structure for Localized Pages
Organize Folio pages with locale subfolders (e.g., `resources/views/pages/en/about.blade.php`, `resources/views/pages/it/about.blade.php`) and use a custom Folio resolver or middleware to select the correct folder based on locale. However, this approach may require significant customization of Folio's routing logic and is less recommended due to maintenance overhead.

### Step 5: URL Generation in Blade Files
Ensure that links in Folio-managed Blade files respect localization. Use `laravel-localization`'s helpers:
```php
<!-- resources/views/pages/about.blade.php -->
<a href="{{ LaravelLocalization::getLocalizedURL(null, route('home')) }}">Home</a>
```
Or directly with the route helper:
```php
<a href="{{ route('home', [], false) }}">Home</a>
```
Ensure `routeIs()` helper accounts for locale when checking active routes:
```php
<li class="{{ routeIs('about') ? 'active' : '' }}">
    <a href="{{ route('about', [], false) }}">About</a>
</li>
```

### Step 6: Language Switching for Folio Pages
When implementing a language switcher, ensure it redirects to the localized version of the current Folio page:
```php
// app/Http/Controllers/ChangeLanguageController.php
public function __invoke($locale)
{
    if (!array_key_exists($locale, LaravelLocalization::getSupportedLocales())) {
        return redirect()->back();
    }
    if (Auth::check()) {
        Auth::user()->update(['language' => $locale]);
    }
    session()->put('locale', $locale);
    return redirect(LaravelLocalization::getLocalizedURL($locale, url()->current()));
}
```

## Best Practices for `<nome progetto>corrente`
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
Integrating `mcamara/laravel-localization` with `laravel/folio` requires careful handling of URL prefixes and middleware to ensure seamless localized routing. By using a custom middleware to manage locale prefixes and leveraging `laravel-localization`'s helpers for URL generation, `<nome progetto>corrente` can provide a robust multi-language experience for healthcare users while maintaining the simplicity of Folio's page-based routing. This approach ensures accessibility, SEO benefits, and user-friendly navigation across languages.

---

## laravel_localization_implementation

*Consolidated from: `laravel_localization_implementation.md`*

title: "Implementazione della Localizzazione "
module: "Lang"
type: concept
tags: [test]
created: 2026-07-14
updated: 2026-07-14
qmd: "test"
related:
  - "./italian-text-refined-audit-report.md"
---
# Implementazione della Localizzazione 

## Collegamenti correlati
- [Documentazione centrale](/docs/README.md)
- [Collegamenti documentazione](/docs/collegamenti-documentazione.md)
- [Regole Traduzioni Lang](/laravel/Modules/Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Componenti SVG Bandiere](/laravel/Modules/UI/docs/FLAGS_COMPONENTS.md)
- [Implementazione Header](/laravel/Themes/One/docs/sections/HEADER_LANGUAGE_USER_DROPDOWN.md)

## Panoramica

<main module> utilizza il pacchetto `mcamara/laravel-localization` per gestire la localizzazione dell'applicazione. Questo documento descrive come implementare correttamente il selettore di lingue e come utilizzare le funzioni del pacchetto.

## Regole Fondamentali

1. **NON creare rotte personalizzate** per la gestione delle lingue (come `language.switch`)
2. **NON creare controller specifici** per la gestione delle lingue
3. Utilizzare **ESCLUSIVAMENTE** le funzioni native del pacchetto `mcamara/laravel-localization`
4. Filament e Folio gestiscono già la localizzazione, non è necessario implementare logiche personalizzate

## Funzioni del Pacchetto `mcamara/laravel-localization`

### Ottenere la Lingua Corrente

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

$currentLocale = LaravelLocalization::getCurrentLocale();
```

### Ottenere le Lingue Supportate

```php
$supportedLocales = LaravelLocalization::getSupportedLocales();
```

### Generare URL Localizzati

```php
$url = LaravelLocalization::getLocalizedURL('it'); // URL per la lingua italiana
$url = LaravelLocalization::getLocalizedURL('en'); // URL per la lingua inglese
```

## Implementazione Corretta del Selettore di Lingue

### Componente Blade

```blade
@props(['currentLocale' => LaravelLocalization::getCurrentLocale()])

<div x-data="{ open: false }" class="relative">
    <button
        @click="open = !open"
        class="flex items-center space-x-2 px-3 py-2 rounded-lg bg-white/10 hover:bg-white/20 transition-colors duration-200"
        aria-label="{{ __('common.language_selector.toggle_button') }}"
    >
        @php
            $flagCode = $currentLocale === 'en' ? 'gb' : $currentLocale;
        @endphp
        <x-ui-flags.{{ $flagCode }} class="w-6 h-4" />
        <span class="text-sm font-medium text-white">{{ strtoupper($currentLocale) }}</span>
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
    >
        <div class="py-1">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                @php
                    $flagCode = $localeCode === 'en' ? 'gb' : $localeCode;
                @endphp
                <a
                    href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}"
                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $currentLocale === $localeCode ? 'bg-gray-50' : '' }}"
                >
                    <x-ui-flags.{{ $flagCode }} class="w-6 h-4 mr-2" />
                    <span>{{ $properties['native'] }}</span>
                    @if($currentLocale === $localeCode)
                        <svg class="w-4 h-4 ml-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
```

## Errori Comuni da Evitare

### 1. Utilizzo di Rotte Personalizzate

```blade
<!-- ERRATO -->
<a href="{{ route('language.switch', 'it') }}">Italiano</a>

<!-- CORRETTO -->
<a href="{{ LaravelLocalization::getLocalizedURL('it') }}">Italiano</a>
```

### 2. Implementazione di Controller per il Cambio Lingua

```php
// ERRATO
Route::get('language/{locale}', 'LanguageController@switch')->name('language.switch');

// CORRETTO
// Non è necessario implementare controller o rotte personalizzate
// Il pacchetto mcamara/laravel-localization gestisce già tutto
```

### 3. Utilizzo di Helper Personalizzati

```php
// ERRATO
function switchLanguage($locale) {
    // Logica personalizzata per il cambio lingua
}

// CORRETTO
// Utilizzare le funzioni native del pacchetto
$url = LaravelLocalization::getLocalizedURL($locale);
```

## Configurazione del Pacchetto

La configurazione del pacchetto `mcamara/laravel-localization` si trova nel file `config/laravellocalization.php`. Le lingue supportate sono definite nell'array `supportedLocales`:

```php
'supportedLocales' => [
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT'],
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    // Altre lingue...
],
```

## Middleware

Il pacchetto `mcamara/laravel-localization` fornisce diversi middleware per gestire la localizzazione:

1. `LaravelLocalizationRoutes`: Applica il prefisso della lingua alle rotte
2. `LaravelLocalizationRedirectFilter`: Reindirizza alla lingua predefinita se la lingua non è specificata
3. `LaravelLocalizationViewPath`: Imposta il percorso delle viste in base alla lingua

## Conclusione

Seguendo queste linee guida, è possibile implementare correttamente la localizzazione  utilizzando il pacchetto `mcamara/laravel-localization` senza creare rotte o controller personalizzati. Questo approccio è coerente con la filosofia di <main module> di utilizzare Filament e Folio per gestire la maggior parte delle funzionalità dell'applicazione.

---

## laravel_localization_integration

*Consolidated from: `laravel_localization_integration.md`*

title: "Integrazione avanzata: mcamara/laravel-localization + Laravel Folio"
module: "Lang"
type: concept
tags: [migrazione, filament, 4]
created: 2026-07-14
updated: 2026-07-14
qmd: "migrazione filament 4"
related:
  - "./italian-text-refined-audit-report.md"
---
# Integrazione avanzata: mcamara/laravel-localization + Laravel Folio

## 1. Introduzione

Questa guida approfondisce l'integrazione tra [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization) e [Laravel Folio](https://github.com/laravel/folio), con focus su:
- Localizzazione delle route Folio (file-based routing)
- Traduzione degli slug e dei parametri dinamici
- Best practice, criticità e raccomandazioni operative

---

## 2. Analisi tecnica e criticità

### 2.1. Come funziona Folio
- Genera route da `resources/views/pages` (ogni file Blade = una route)
- Supporta parametri dinamici (`[slug].blade.php` → `/qualcosa`)

### 2.2. Come funziona mcamara/laravel-localization
- Wrappa le route in un gruppo con prefisso lingua e middleware
- Permette la traduzione degli slug tramite `lang/{locale}/routes.php`
- Offre helper per URL localizzati e parametri tradotti

### 2.3. Punti critici
- Folio **non supporta nativamente** la traduzione degli slug: serve mappatura manuale
- Cache delle route: usare sempre `php artisan route:trans:cache`
- Parametri dinamici: richiedono override custom (vedi sotto)
- Fallback locale: va gestito sia lato Folio che localization

---

## 3. Passaggi operativi dettagliati

### 3.1. Wrappare tutte le route Folio nel gruppo localizzato

```php
use Laravel\Folio\Facades\Folio;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localizationRedirect', 'localeViewPath'],
], function () {
    Folio::route('pages');
    // ...altre route
});
```

### 3.2. Traduzione degli slug Folio

#### a) File di traduzione degli slug

- Crea `lang/en/routes.php`, `lang/it/routes.php`, ecc.
- Esempio:
  ```php
  // lang/en/routes.php
  return [ 'about' => 'about', 'contact' => 'contact', ];
  // lang/it/routes.php
  return [ 'about' => 'chi-siamo', 'contact' => 'contatti', ];
  ```

#### b) Mappare le route Folio agli slug tradotti

- Folio non supporta la traduzione automatica degli slug: usa i nomi tradotti nei link e, se serve, crea route custom:
  ```php
  Route::get(LaravelLocalization::transRoute('routes.about'), function () {
      return view('pages.about');
  })->name('about');
  ```

#### c) Nei Blade Folio, usa sempre i metodi di LaravelLocalization

```blade
<a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), route('about')) }}">
    {{ __('About us') }}
</a>
```

### 3.3. Gestione avanzata dei parametri dinamici (slug, id, ecc.)

- Per tradurre parametri dinamici (es. `/it/articolo/slug-italiano` vs `/en/article/english-slug`):
  - Implementa l'interfaccia `LocalizedUrlRoutable` nel model
  - Override di `getLocalizedRouteKey($locale)` e `resolveRouteBinding($slug)`

**Esempio:**
```php
class Article extends Model implements \Mcamara\LaravelLocalization\Interfaces\LocalizedUrlRoutable
{
    public function getLocalizedRouteKey($locale)
    {
        return $this->getTranslation('slug', $locale);
    }
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where("slug->{$locale}", $value)->firstOrFail();
    }
}
```

- Richiede che il model abbia un campo `slug` multilingua (es. via spatie/laravel-translatable)

### 3.4. Cache delle route

- Usa **sempre** `php artisan route:trans:cache` per la cache delle route localizzate
- Non usare il comando standard `route:cache`

### 3.5. Testing

- Nei test, imposta il locale con:
  ```php
  protected function refreshApplicationWithLocale($locale)
  {
      self::tearDown();
      putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale);
      self::setUp();
  }
  ```

---

## 4. Best practice e raccomandazioni

- Versiona sempre i file `lang/{locale}/routes.php` e aggiorna la documentazione ad ogni nuova pagina Folio
- Usa sempre i metodi di LaravelLocalization per link e redirect nei Blade
- Testa la localizzazione sia per le route che per i contenuti delle pagine Folio
- Documenta la strategia in `/Modules/Lang/docs/laravel-localization-integration.md` e linka dal README
- Per la cache delle route, usa sempre `php artisan route:trans:cache`

---

## 5. Modifiche consigliate ai file del progetto

- Aggiorna `routes/web.php` per wrappare tutte le route Folio nel gruppo localizzato
- Crea/aggiorna i file `lang/{locale}/routes.php` per tutte le lingue supportate
- Nei Blade Folio, sostituisci tutti i link hardcoded con i metodi di LaravelLocalization
- Se usi parametri dinamici multilingua, aggiorna i model per supportare `LocalizedUrlRoutable`
- Documenta la strategia in `/Modules/Lang/docs/laravel-localization-integration.md` e linka dal README

---

## 6. Checklist finale

- [ ] Tutte le route Folio sono wrappate dal gruppo localizzato
- [ ] I file `lang/{locale}/routes.php` sono completi e versionati
- [ ] I link nei Blade usano i metodi di LaravelLocalization
- [ ] I parametri dinamici sono gestiti in modo multilingua se necessario
- [ ] La cache delle route usa `route:trans:cache`
- [ ] La documentazione è aggiornata e linkata nei README

---

## 7. Collegamenti utili

- [mcamara/laravel-localization - GitHub](https://github.com/mcamara/laravel-localization)
- [Laravel Folio - Docs](https://laravel.com/docs/12.x/folio)
- [Traduzione route con mcamara](https://github.com/mcamara/laravel-localization#translated-routes)
- [Esempio di override parametri dinamici](https://github.com/mcamara/laravel-localization#translatable-route-parameters)

---

## laravel_localization_livewire_volt

*Consolidated from: `laravel_localization_livewire_volt.md`*

title: "Integrazione di mcamara/laravel-localization con Livewire Volt"
module: "Lang"
type: concept
tags: [lang, service, helper, text]
created: 2026-07-14
updated: 2026-07-14
qmd: "lang service helper text fix"
related:
  - "./italian-text-refined-audit-report.md"
---
# Integrazione di mcamara/laravel-localization con Livewire Volt

## Obiettivo
Fornire una guida pratica per integrare la localizzazione delle rotte e dei contenuti con Livewire Volt, sfruttando le potenzialità di mcamara/laravel-localization.

---

## 1. Cos'è Livewire Volt?
Volt è una sintassi semplificata per creare componenti Livewire, che permette di scrivere componenti reattivi direttamente in Blade, con una sintassi più concisa e moderna.

---

## 2. Sfida dell'integrazione
- **Volt** genera componenti Livewire che vengono richiamati tramite rotte Laravel.
- **mcamara/laravel-localization** lavora a livello di routing, aggiungendo il prefisso della lingua e gestendo la localizzazione delle rotte.
- È necessario assicurarsi che i componenti Volt siano accessibili tramite rotte localizzate e che i contenuti siano tradotti correttamente.

---

## 3. Best Practice per l'integrazione

### a) Registrazione delle rotte Volt nel gruppo localizzato
Assicurati che tutte le rotte che richiamano componenti Volt siano dichiarate all'interno del gruppo di localizzazione:

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        // Rotte Volt
        Volt::route('dashboard', 'dashboard');
        Volt::route('profile', 'profile');
        // ...altre rotte Volt
    }
);
```

**Nota:**
Se usi Folio, assicurati che anche le pagine Volt siano registrate nel gruppo localizzato.

---

### b) Traduzione dei contenuti nei componenti Volt
- Usa sempre le funzioni di traduzione Laravel (`__()`, `@lang`) all'interno dei template Blade dei componenti Volt.
- Esempio:
  ```blade
  <h1>{{ __('Welcome') }}</h1>
  <button>{{ __('Logout') }}</button>
  ```
- Per i messaggi dinamici, usa la funzione `__()` anche nel codice PHP del componente Volt:
  ```php
  $this->notify(__('Profile updated successfully!'));
  ```

---

### c) Gestione dei redirect e dei link
- Quando effettui redirect o generi link all'interno dei componenti Volt, usa sempre i nomi delle rotte localizzate:
  ```php
  return redirect()->route(LaravelLocalization::getCurrentLocale().'.dashboard');
  ```
- Nei link Blade:
  ```blade
  <a href="{{ route(LaravelLocalization::getCurrentLocale().'.profile') }}">{{ __('Profile') }}</a>
  ```

---

### d) Middleware e Locale
- Se hai logica custom che dipende dalla lingua, puoi accedere alla lingua corrente tramite:
  ```php
  app()->getLocale()
  ```
- Se necessario, puoi forzare la lingua in un componente Volt:
  ```php
  app()->setLocale($locale);
  ```

---

### e) Traduzione delle rotte Volt
- Se vuoi tradurre anche i path delle rotte Volt (es: `/it/bacheca` invece di `/it/dashboard`), usa la funzionalità di route translation mapping di mcamara/laravel-localization.
- Esempio in `resources/lang/it/routes.php`:
  ```php
  return [
      'dashboard' => 'bacheca',
      'profile' => 'profilo',
  ];
  ```
- E registra le rotte Volt usando le chiavi tradotte:
  ```php
  Volt::route(__('routes.dashboard'), 'dashboard');
  ```

---

## 4. Checklist
- [ ] Tutte le rotte Volt sono dentro il gruppo localizzato.
- [ ] Tutti i testi nei componenti Volt sono tradotti con `__()` o `@lang`.
- [ ] Tutti i link e redirect usano nomi di rotte localizzate.
- [ ] Se necessario, i path delle rotte Volt sono tradotti tramite mapping.
- [ ] Documenta ogni eccezione o workaround in `/Modules/Lang/docs/laravel-localization-livewire-volt.md`.

---

## 5. FAQ e problemi comuni
- **Perché il componente Volt non si localizza?**  
  Verifica che la rotta sia dentro il gruppo localizzato e che il middleware sia applicato.
- **Come traduco i path delle rotte Volt?**  
  Usa il mapping delle rotte in `lang/{locale}/routes.php` e registra le rotte Volt con le chiavi tradotte.
- **Come gestisco la lingua nei redirect?**  
  Usa sempre `LaravelLocalization::getCurrentLocale()` nei redirect e nei link.

---

## 6. Modifiche consigliate ai file del progetto
- **web.php**:  
  Sposta tutte le rotte Volt dentro il gruppo localizzato.
- **lang/{locale}/routes.php**:  
  Aggiungi mapping per i path delle rotte Volt se vuoi path tradotti.
- **Componenti Volt**:  
  Verifica che tutti i testi siano tradotti e che i redirect usino le rotte localizzate.
- **Documentazione**:  
  Aggiorna sempre `/Modules/Lang/docs/laravel-localization-livewire-volt.md` ogni volta che cambi la struttura delle rotte o dei componenti Volt.

---

## 7. Best Practices operative (.mdc)

Vedi file `.cursor/rules/laravel-localization-livewire-volt.mdc` e `.windsurf/rules/laravel-localization-livewire-volt.mdc` per checklist e regole operative. 

---

## laravel_localization_usage

*Consolidated from: `laravel_localization_usage.md`*

title: "Utilizzo di mcamara/laravel-localization "
module: "Lang"
type: concept
tags: [phpstan, level10, fixes, 1]
created: 2026-07-14
updated: 2026-07-14
qmd: "phpstan level10 fixes 1"
related:
  - "./italian-text-refined-audit-report.md"
---
# Utilizzo di mcamara/laravel-localization 

## Collegamenti correlati
- [README modulo Lang](./README.md)
- [Best Practices Chiavi di Traduzione](translation-keys-best-practices.md)
- [Best Practices Chiavi di Traduzione](../../translation-keys-best-practices.md)
- [Implementazione Header con Selettore Lingua](/laravel/Modules/User/docs/HEADER_LANGUAGE_SELECTOR_WITH_FLAGS.md)
- [Collegamenti Documentazione](/docs/collegamenti-documentazione.md)

## Panoramica

Questo documento descrive come utilizzare correttamente il pacchetto `mcamara/laravel-localization`  per gestire la localizzazione delle URL e l'interfaccia multilingua.

## Regole Fondamentali

1. **MAI creare rotte aggiungendole in web.php**
   - Filament e Folio gestiscono automaticamente le rotte
   - Non creare file di rotte personalizzati

2. **MAI creare controller personalizzati**
   - Utilizzare le funzionalità di Filament e Folio
   - Evitare di creare controller HTTP tradizionali

3. **Gestione della Localizzazione**
   - Utilizzare SEMPRE il pacchetto mcamara/laravel-localization
   - Seguire la documentazione ufficiale: https://github.com/mcamara/laravel-localization
   - Assicurarsi che tutti gli URL includano il prefisso della lingua

## Configurazione

Il pacchetto `mcamara/laravel-localization` è già configurato . La configurazione si trova in:
- `/var/www/html/<directory progetto>/laravel/config/laravellocalization.php`

Le lingue supportate sono definite nella chiave `supportedLocales` di questo file.

## Utilizzo Corretto in Blade

### 1. Ottenere la Lingua Corrente

```php
// CORRETTO - Utilizzare LaravelLocalization::getCurrentLocale()
$currentLocale = LaravelLocalization::getCurrentLocale();

// ERRATO - Non utilizzare app()->getLocale() direttamente
$currentLocale = app()->getLocale();
```

### 2. Ottenere le Lingue Supportate

```php
// CORRETTO - Utilizzare LaravelLocalization::getSupportedLocales()
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    // $properties contiene 'name', 'script', 'native', 'regional'
    <span>{{ $properties['native'] }}</span>
@endforeach

// ERRATO - Non utilizzare array hardcoded
@foreach(['it' => 'Italiano', 'en' => 'English'] as $locale => $label)
    <span>{{ $label }}</span>
@endforeach
```

### 3. Generare URL Localizzati

```php
// CORRETTO - Utilizzare LaravelLocalization::getLocalizedURL()
<a href="{{ LaravelLocalization::getLocalizedURL('en') }}">English</a>

// ERRATO - Non costruire URL manualmente
<a href="{{ '/en' . substr(request()->getPathInfo(), 3) }}">English</a>
```

### 4. Esempio di Selettore Lingua Completo

```php
@props(['currentLocale' => LaravelLocalization::getCurrentLocale()])

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" @click.away="open = false">
        <x-dynamic-component 
            :component="'ui-flags.' . ($currentLocale === 'en' ? 'gb' : $currentLocale)" 
        />
        <span>{{ LaravelLocalization::getSupportedLocales()[$currentLocale]['native'] }}</span>
    </button>
    
    <div x-show="open">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                <x-dynamic-component 
                    :component="'ui-flags.' . ($localeCode === 'en' ? 'gb' : $localeCode)" 
                />
                <span>{{ $properties['native'] }}</span>
            </a>
        @endforeach
    </div>
</div>
```

## Utilizzo delle Bandiere SVG

Le bandiere SVG sono disponibili in `/var/www/html/<directory progetto>/laravel/Modules/UI/resources/svg/flags` e sono autoregistrate come componenti Blade con il prefisso `ui-flags`.

### Utilizzo Corretto

```php
// Per la bandiera italiana
<x-ui-flags.it class="w-6 h-6" />

// Per la bandiera inglese (UK)
<x-ui-flags.gb class="w-6 h-6" />

// Utilizzo dinamico
@php
    $flagCode = $locale === 'en' ? 'gb' : $locale;
@endphp
<x-dynamic-component :component="'ui-flags.' . $flagCode" class="w-6 h-6" />
```

## Middleware e Configurazione

Il pacchetto utilizza diversi middleware per gestire la localizzazione:

1. `LaravelLocalizationRedirectFilter` - Reindirizza all'URL localizzato
2. `LaravelLocalizationViewPath` - Imposta il percorso della vista localizzata
3. `LaravelLocalizationRoutes` - Gestisce le rotte localizzate

Questi middleware sono già configurati  e non è necessario modificarli.

## Errori Comuni da Evitare

1. **Utilizzo di route() per rotte localizzate**
   ```php
   // ERRATO
   <a href="{{ LaravelLocalization::getLocalizedURL('it') }}">Italiano</a>
   
   // CORRETTO
   <a href="{{ LaravelLocalization::getLocalizedURL('it') }}">Italiano</a>
   ```

2. **Costruzione manuale degli URL localizzati**
   ```php
   // ERRATO
   <a href="{{ '/' . $locale . '/pages/about' }}">About</a>
   
   // CORRETTO
   <a href="{{ LaravelLocalization::getLocalizedURL($locale, route('pages.about')) }}">About</a>
   ```

3. **Utilizzo di app()->setLocale() direttamente**
   ```php
   // ERRATO
   @php app()->setLocale('it') @endphp
   
   // CORRETTO - Lasciare che il middleware gestisca la locale
   // Non modificare manualmente la locale
   ```

## Esempi Pratici

### Esempio 1: Header con Selettore Lingua

```php
// /laravel/Themes/One/resources/views/components/blocks/language-selector.blade.php
@props(['currentLocale' => LaravelLocalization::getCurrentLocale()])

<div class="relative inline-block text-left" x-data="{ open: false }">
    <button @click="open = !open" @click.away="open = false">
        @php
            $flagCode = $currentLocale === 'en' ? 'gb' : $currentLocale;
        @endphp
        <x-dynamic-component :component="'ui-flags.' . $flagCode" />
        <span>{{ LaravelLocalization::getSupportedLocales()[$currentLocale]['native'] }}</span>
    </button>
    
    <div x-show="open">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            @php
                $flagCode = $localeCode === 'en' ? 'gb' : $localeCode;
            @endphp
            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                <x-dynamic-component :component="'ui-flags.' . $flagCode" />
                <span>{{ $properties['native'] }}</span>
            </a>
        @endforeach
    </div>
</div>
```

### Esempio 2: Configurazione JSON per Header

```json
{
    "name": {
        "it": "Selettore Lingua",
        "en": "Language Selector"
    },
    "type": "language-selector",
    "data": {
        "view": "pub_theme::components.blocks.language-selector"
    }
}
```

## Componenti Bandiera

### Implementazione Corretta
```blade
{{-- Per icone semplici --}}
<x-filament::icon
    :icon="'ui-flags.' . $flagCode"
    class="h-5 w-5 text-gray-500 dark:text-gray-400"
    :label="$flagCode"
    aria-hidden="true"
/>

{{-- Per pulsanti con icone --}}
<x-filament::icon-button
    :icon="'ui-flags.' . $flagCode"
    class="h-5 w-5"
    :label="$flagCode"
    aria-hidden="true"
/>
```

### Vantaggi
1. **Coerenza**: Usa i componenti nativi di Filament
2. **Tema Scuro**: Supporto automatico
3. **Accessibilità**: Componenti ottimizzati
4. **Manutenibilità**: Codice pulito e standardizzato

## Riferimenti

- [Documentazione ufficiale mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
- [Documentazione Laravel Localization](https://laravel.com/docs/10.x/localization)
- [Blade Components Documentation](https://laravel.com/docs/10.x/blade#components)

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04
