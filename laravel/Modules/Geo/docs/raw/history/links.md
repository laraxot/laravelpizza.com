If you need to translate just the text and want to build your own UI - Spatie package is a good choice.
If you need to translate the routes - Mcamara package
If you need to translate just the text but don't want to build your UI - You can use Nikaia package or MohmmedAshraf package
If there's a need for text and routes - look into combining the packages. For example, you can use Mcamara package and any of the remaining ones for the text.




https://github.com/Laravel-Lang/lang/blob/main/locales/it/php.json
https://github.com/LaravelDaily/laravel11-localization-course/tree/lesson/ui-switching
https://github.com/LaravelDaily/laravel11-localization-course/tree/lesson/packages/spatie
https://github.com/Astrotomic/laravel-translatable
https://github.com/mcamara/laravel-localization
https://github.com/MohmmedAshraf/laravel-translations

~~~php
if(! function_exists('formatCurrency')) {
    function formatCurrency($amount, $locale = 'en_US', $currency = 'USD')
    {
        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, $currency);
    }
}
~~~

file Http/Middleware/SetLocale.php

~~~php
use Auth;
use Carbon\Carbon;
 
// ...
 
 public function handle(Request $request, Closure $next): Response
{
    // Logged-in users use their own language preference
    if (Auth::check()) {
        app()->setLocale(Auth::user()->language);
        Carbon::setLocale(Auth::user()->language);
    // Guests use the language set in the session
    } else {
        app()->setLocale(session('locale', 'en'));
        Carbon::setLocale(session('locale', 'en'));
    }
 
    return $next($request);
}
~~~

file resources/views/layouts/navigation.blade.php

~~~php
{{-- ... --}}
@foreach(config('app.available_locales') as $locale)
    <x-nav-link
            :href="route('change-locale', $locale)"
            :active="app()->getLocale() == $locale">
        {{ strtoupper($locale) }}
    </x-nav-link>
@endforeach
<x-dropdown align="right" width="48">
{{-- ... --}}
~~~

with mcamara
https://laraveldaily.com/lesson/multi-language-laravel/mcamara-laravel-localization
https://github.com/LaravelDaily/laravel11-localization-course/tree/lesson/packages/mcamara-laravel-localization
~~~php
{{-- ... --}}
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <x-nav-link rel="alternate" hreflang="{{ $localeCode }}"
                :active="$localeCode === app()->getLocale()"
                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
        {{ ucfirst($properties['native']) }}
    </x-nav-link>
@endforeach
<x-dropdown align="right" width="48">
{{-- ... --}}
~~~

~~~bash
php artisan route:trans:list {locale}
~~~


with google sheet 
https://github.com/LaravelDaily/laravel11-localization-course/tree/lesson/packages/nikaia-translation-sheet

a nice administration
outhebox/laravel-translations




