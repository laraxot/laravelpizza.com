# Laravel Localization (mcamara) — Consolidated Reference

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

1. **Module `Lang` owns localization** — other modules must not duplicate this logic
2. **Always use redirect middleware** — prevents SEO duplicate content
3. **Never hardcode locale strings** — use `LaravelLocalization::getCurrentLocale()`
4. **Short array syntax `[]`** only in all PHP code
5. **Filament panels** integrate via `XotBasePanelProvider`

## Related Docs

- [Skill: laravel-localization](../../../../.agent/skills/laravel-localization/SKILL.md)
- [Filament Integration](./filament-integration.md)
- [Philosophy](./philosophy.md)
