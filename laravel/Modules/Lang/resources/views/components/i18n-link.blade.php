@props([
    'url' => null,
    'locale' => null,
    'forceLocale' => false
])

@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
    
    // If URL is provided, generate localized URL
    if ($url) {
        // Fourth parameter true forces locale prefix even when hideDefaultLocaleInURL=true
        $localizedUrl = LaravelLocalization::getLocalizedURL($locale, $url, [], $forceLocale);
    } else {
        // No URL provided, use current URL
        $localizedUrl = LaravelLocalization::getLocalizedURL($locale, null, [], $forceLocale);
    }
@endphp

<a href="{{ $localizedUrl }}" {{ $attributes->merge(['class' => '']) }}>
    {{ $slot }}
</a>
