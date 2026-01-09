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
