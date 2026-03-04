# Folio + Laravel Localization Architecture

## Overview

LaravelPizza.com uses Laravel Folio for file-based routing and Laravel Localization for multilingual support. Due to incompatibility between Laravel Localization's middleware system and Folio's routing architecture, we use a custom solution.

## Architecture

### Custom Middleware: SetFolioLocale

**Location**: `laravel/Modules/Cms/app/Http/Middleware/SetFolioLocale.php`

This middleware extracts the locale from the first URL segment and sets it for the application.

```php
// Extracts locale from URL
// /it/home → sets locale to 'it'
// /en/about → sets locale to 'en'
```

### Folio Registration

**File**: `laravel/Modules/Cms/app/Providers/FolioVoltServiceProvider.php`

```php
// Register Folio with SetFolioLocale middleware
Folio::path($theme_path)
    ->middleware([
        '*' => [
            // Load base middleware from TenantService
            // Add SetFolioLocale for locale detection
            SetFolioLocale::class,
        ],
    ]);
```

## URL Structure

All URLs follow the pattern: `/{locale}/{path}`

```
/it/home       → Italian home page
/en/home       → English home page
/de/chi-siamo  → German about page
/fr/chi-siamo  → French about page
```

## Blade Templates

### HTML lang attribute
```blade
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
```

### Language switcher
```blade
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <a href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
        {{ $properties['native'] }}
    </a>
@endforeach
```

### Current page in different locale
```blade
<a href="{{ LaravelLocalization::getLocalizedURL('en') }}">Switch to English</a>
<a href="{{ LaravelLocalization::getLocalizedURL('it') }}">Passa all'italiano</a>
```

## Configuration

**File**: `laravel/config/laravellocalization.php`

```php
'supportedLocales' => [
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT'],
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    'de' => ['name' => 'German', 'script' => 'Latn', 'native' => 'Deutsch', 'regional' => 'de_DE'],
    'fr' => ['name' => 'French', 'script' => 'Latn', 'native' => 'français', 'regional' => 'fr_FR'],
    'es' => ['name' => 'Spanish', 'script' => 'Latn', 'native' => 'español', 'regional' => 'es_ES'],
    'ru' => ['name' => 'Russian', 'script' => 'Cyrl', 'native' => 'Pусский', 'regional' => 'ru_RU'],
],
'hideDefaultLocaleInURL' => false,  // All URLs must have locale prefix
```

## Translation Files

**Location**: `laravel/lang/{locale}/`

```
laravel/lang/
├── it/
│   ├── home.php
│   ├── about.php
│   └── ...
├── en/
│   ├── home.php
│   ├── about.php
│   └── ...
└── ...
```

## Usage in Volt Components

```php
// In Volt component
$locale = app()->getLocale();
$translatedText = __('home.title');

// In Blade template
<div>{{ __('home.welcome', ['name' => $user->name]) }}</div>
```

## Testing

```bash
# Test Italian
curl http://127.0.0.1:8000/it | grep lang=

# Test English
curl http://127.0.0.1:8000/en | grep lang=

# Test German
curl http://127.0.0.1:8000/de | grep lang=
```

## Common Issues

### Locale not changing
1. Clear cache: `php artisan optimize:clear`
2. Check middleware order in FolioVoltServiceProvider
3. Verify URL structure (must have locale prefix)

### Translation not showing
1. Check translation file exists: `laravel/lang/{locale}/{file}.php`
2. Verify translation key matches file structure
3. Clear view cache: `php artisan view:clear`

### Language switcher not working
1. Verify `LaravelLocalization::getLocalizedURL()` is used
2. Check `supportedLocales` config
3. Ensure URLs have locale prefix

## References

- Laravel Localization: https://github.com/mcamara/laravel-localization
- Laravel Folio: https://laravel.com/docs/folio
- Laravel Localization Helpers: See `laravel/Modules/Xot/docs/laravel-localization-architecture-analysis.md`