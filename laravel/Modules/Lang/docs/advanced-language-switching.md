# Advanced Language Switching Strategies

## Overview
In a healthcare application like `<nome progetto>`, providing a seamless multi-language experience is crucial for accessibility and user satisfaction. This document explores advanced strategies for language switching, building upon our existing URL-based approach.

## Combined URL and Session-Based Language Switching

For optimal user experience and SEO benefits, `<nome progetto>` can implement a hybrid approach combining URL-based language prefixes with session/database storage.

### Benefits
- SEO friendly URLs with language prefix (e.g., `/en/services`)
- Persistent user language preference even after browser closure
- Automatic language detection for new users based on browser settings
- Manual override capability through UI selector

### Implementation Steps
1. **Configuration**: Store available locales in `config/app.php` as `available_locales`.
2. **User Model**: Add a `language` field to store user preferences in the database.
3. **Middleware**: Enhance the existing `SetLocale` middleware to consider user preferences and session data alongside URL prefixes.
4. **Controller**: Create a `ChangeLanguageController` for handling user language selection.
5. **UI**: Implement a language selector dropdown in the navigation bar.

### Code Examples

#### Middleware Enhancement
```php
// app/Http/Middleware/SetLocale.php
public function handle(Request $request, Closure $next): Response
{
    $locale = $request->segment(1);
    if (in_array($locale, config('app.available_locales'))) {
        app()->setLocale($locale);
        Carbon::setLocale($locale);
        session()->put('locale', $locale);
    } elseif (Auth::check()) {
        app()->setLocale(Auth::user()->language);
        Carbon::setLocale(Auth::user()->language);
    } elseif (session()->has('locale')) {
        app()->setLocale(session('locale', config('app.locale')));
        Carbon::setLocale(session('locale', config('app.locale')));
    } else {
        // Detect browser language or fallback to default
        $browserLocale = substr($request->server('HTTP_ACCEPT_LANGUAGE') ?? '', 0, 2);
        $locale = in_array($browserLocale, config('app.available_locales')) ? $browserLocale : config('app.locale');
        app()->setLocale($locale);
        Carbon::setLocale($locale);
        session()->put('locale', $locale);
    }
    return $next($request);
}
```

#### Language Switch Controller
```php
// app/Http/Controllers/ChangeLanguageController.php
public function __invoke($locale)
{
    if (!in_array($locale, config('app.available_locales'))) {
        return redirect()->back();
    }
    if (Auth::check()) {
        Auth::user()->update(['language' => $locale]);
    }
    session()->put('locale', $locale);
    app()->setLocale($locale);
    Carbon::setLocale($locale);
    // Redirect to the current page with the new locale prefix
    $url = url()->current();
    $segments = explode('/', $url);
    if (in_array($segments[3] ?? '', config('app.available_locales'))) {
        $segments[3] = $locale;
    } else {
        array_splice($segments, 3, 0, $locale);
    }
    return redirect(implode('/', $segments));
}
```

## Routes
Add a dedicated route for language switching while maintaining URL prefixes:

```php
// routes/web.php
Route::get('lang/{locale}', [ChangeLanguageController::class, '__invoke'])->name('change-locale');
```

## View Integration
Integrate a language selector in the navigation bar for easy access:

```php
// resources/views/layouts/navigation.blade.php
@foreach(config('app.available_locales') as $locale)
    <x-nav-link :href="route('change-locale', $locale)" :active="app()->getLocale() == $locale">
        {{ strtoupper($locale) }}
    </x-nav-link>
@endforeach
```

This approach ensures that users can manually select their preferred language while maintaining SEO-friendly URLs with language prefixes.
