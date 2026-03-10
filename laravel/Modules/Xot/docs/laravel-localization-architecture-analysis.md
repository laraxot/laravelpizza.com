# Laravel Localization Architecture Analysis

## Critical Discovery: Laravel Localization + Folio Incompatibility

### The Problem
Laravel Localization package is designed for traditional Laravel routing (`Route::group()`), NOT for Laravel Folio's file-based routing system. The middleware architecture required by Laravel Localization does not integrate well with Folio's middleware handling.

### Evidence of Incompatibility
1. **Middleware Order Requirements**: Laravel Localization requires specific middleware execution order (Routes → SessionRedirect → RedirectFilter)
2. **Folio's Middleware System**: Folio has its own middleware handling that doesn't fully support Laravel Localization's complex middleware chain
3. **Route Prefix Management**: Laravel Localization manages URL prefixes internally, but Folio's `->uri()` method creates conflicts

## Solution: Custom Middleware for Folio

### SetFolioLocale Middleware
Since Laravel Localization doesn't work well with Folio, we created a custom middleware `SetFolioLocale` that:
- Extracts locale from the first URL segment
- Sets the application locale using `app()->setLocale()`
- Uses Laravel Localization's `supportedLocales` config for validation
- Falls back to default locale if no valid locale is found

**File**: `laravel/Modules/Cms/app/Http/Middleware/SetFolioLocale.php`

```php
public function handle(Request $request, Closure $next)
{
    $segments = $request->segments();
    $firstSegment = $segments[0] ?? '';

    $supportedLocales = array_keys(config('laravellocalization.supportedLocales', []));
    $defaultLocale = config('app.locale', 'it');

    if (in_array($firstSegment, $supportedLocales, true)) {
        app()->setLocale($firstSegment);
    } else {
        app()->setLocale($defaultLocale);
    }

    return $next($request);
}
```

## Current Architecture

### FolioVoltServiceProvider Registration
```php
// Load base middleware from TenantService
$base_middleware = [];

// Add SetFolioLocale middleware for locale detection
$base_middleware[] = \Modules\Cms\Http\Middleware\SetFolioLocale::class;

// Register Folio ONCE (not for each locale)
Folio::path($theme_path)
    ->middleware([
        '*' => $base_middleware,
    ]);
```

### bootstrap/app.php Configuration
```php
->withMiddleware(function (Middleware $middleware): void {
    // Laravel Localization middleware aliases (kept for reference, not used with Folio)
    $middleware->alias([
        'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        'localeCookieRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
        'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
    ]);
});
```

## Laravel Localization Package Usage

### What We USE from the Package
1. **Configuration** (`config/laravellocalization.php`): 
   - `supportedLocales`: Defines available languages
   - `useAcceptLanguageHeader`: Browser language detection
   - `hideDefaultLocaleInURL`: URL prefix visibility

2. **Helpers** (for URL generation in Blade):
   ```blade
   <a href="{{ LaravelLocalization::getLocalizedURL('en') }}">English</a>
   <a href="{{ LaravelLocalization::getLocalizedURL('it') }}">Italiano</a>
   ```

### What We DON'T USE
1. **Middleware**: Laravel Localization's middleware chain (incompatible with Folio)
2. **Route Groups**: Traditional `Route::group()` with locale prefix
3. **Automatic Locale Detection**: We handle this manually in SetFolioLocale

## Configuration Analysis

### Current Config (config/laravellocalization.php)
```php
return [
    'supportedLocales' => [
        'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT'],
        'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
        'de' => ['name' => 'German', 'script' => 'Latn', 'native' => 'Deutsch', 'regional' => 'de_DE'],
        'fr' => ['name' => 'French', 'script' => 'Latn', 'native' => 'français', 'regional' => 'fr_FR'],
        'es' => ['name' => 'Spanish', 'script' => 'Latn', 'native' => 'español', 'regional' => 'es_ES'],
        'ru' => ['name' => 'Russian', 'script' => 'Cyrl', 'native' => 'Pусский', 'regional' => 'ru_RU'],
    ],
    'useAcceptLanguageHeader' => true,
    'hideDefaultLocaleInURL' => false,  // All URLs show locale prefix
    'localesOrder' => ['it', 'en', 'de', 'fr', 'es', 'ru'],
    'httpMethodsIgnored' => ['POST', 'PUT', 'PATCH', 'DELETE'],
];
```

**Note:** With `hideDefaultLocaleInURL = false`, all URLs MUST have locale prefix (e.g., `/it/home`, `/en/home`).

## Testing Results

All locales work correctly:
- `/it` → `lang="it"`
- `/en` → `lang="en"`
- `/de` → `lang="de"`
- `/fr` → `lang="fr"`
- `/es` → `lang="es"`
- `/ru` → `lang="ru"`

## Architecture Summary

### Layer Separation
1. **URL Structure**: Managed by Folio (`/it/home`, `/en/home`)
2. **Locale Detection**: Managed by `SetFolioLocale` middleware
3. **Locale Config**: Provided by Laravel Localization package
4. **URL Generation**: Uses Laravel Localization helpers
5. **Translation Files**: Managed by Laravel's built-in localization

### Key Benefits
- **Simplicity**: Custom middleware is simple and <nome progetto>able
- **Performance**: No complex middleware chain overhead
- **Maintainability**: Easy to understand and debug
- **Flexibility**: Works with Folio's file-based routing

## Required Actions

### ✅ Completed
1. ✅ Removed redundant `SetLocaleFromUrl` middleware
2. ✅ Created `SetFolioLocale` middleware for Folio integration
3. ✅ Updated `FolioVoltServiceProvider` with correct middleware
4. ✅ Updated `bootstrap/app.php` with middleware aliases
5. ✅ Tested all locales successfully

### 📝 Documentation Updates Needed
1. Update `Modules/Cms/docs/` with new architecture
2. Update `Modules/Lang/docs/` with Folio integration notes
3. Update `Modules/UI/docs/` with usage patterns
4. Update `Themes/Meetup/docs/` with implementation details

## References

- Laravel Localization GitHub: https://github.com/mcamara/laravel-localization
- Laravel Folio Documentation: https://laravel.com/docs/folio
- Note: Laravel Localization is designed for traditional routing, not Folio