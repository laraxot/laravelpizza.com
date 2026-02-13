# Localization Standards (mcamara/laravel-localization)

## Overview
We use `mcamara/laravel-localization` to manage multi-language support. This package provides robust tools for handling localized routes, URL generation, and middleware.

## Best Practices

### 1. Retrieving Supported Locales
**❌ Bad:** Accessing config directly.
```php
$locales = config('laravellocalization.supportedLocales');
```

**✅ Good:** Using the Facade.
```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Get all supported locales details
$locales = LaravelLocalization::getSupportedLocales();

// Get just the keys (e.g., ['en', 'it', 'es'])
$keys = LaravelLocalization::getSupportedLanguagesKeys();
```

### 2. Generating Localized URLs
**❌ Bad:** Manually building strings.
```php
$url = '/'.$locale.'/about';
```

**✅ Good:** Using `getLocalizedURL`.
```php
// Generate URL for current page in specific locale
$url = LaravelLocalization::getLocalizedURL('it');

// Generate URL for specific path
$url = LaravelLocalization::getLocalizedURL('it', '/about');
```

### 3. Setting Locale (Middleware)
We use `SetLocaleFromUrl` middleware to automatically set the app locale based on the first URL segment.
```php
public function handle(Request $request, Closure $next)
{
    // ... logic to detect segment ...
    if ($isSupported) {
        LaravelLocalization::setLocale($locale);
        app()->setLocale($locale);
    }
}
```

### 4. Configuration
The configuration is located in `config/laravellocalization.php`. It defines:
- `supportedLocales`: Array of enabled languages.
- `hideDefaultLocaleInURL`: Whether to hide the default language code (e.g., `/it` vs `/`).

## Common Pitfalls
- **`getSupportedLocalesKeys()` does not exist.** Use `getSupportedLanguagesKeys()`.
- **Middleware Order:** Ensure localization middleware runs early to set the environment before other logic.
- **Caching:** Route caching can be tricky with localized routes. Ensure you use `php artisan route:trans:cache` if adhering to strict package guidelines, though we typically rely on standard Laravel caching.

## Agent Team: Localization Expert
For complex localization tasks, refer to the "Localization Expert" agent.
