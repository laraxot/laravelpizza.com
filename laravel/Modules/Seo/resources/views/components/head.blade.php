<!DOCTYPE html>
<html {{ $attributes->get('lang', app()->getLocale()) }}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#0f2b46">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $documentTitle ?? $title ?? config('app.name') }}">
    <meta property="og:description" content="{{ $description ?? '' }}">
    <meta property="og:url" content="{{ $url ?? request()->url() }}">
    <meta property="og:image" content="{{ $image ?? asset('images/og-default.jpg') }}">
    <meta property="og:site_name" content="{{ $siteName ?? config('app.name') }}">
    <meta property="og:locale" content="{{ $locale ?? app()->getLocale() }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $documentTitle ?? $title ?? config('app.name') }}">
    <meta name="twitter:description" content="{{ $description ?? '' }}">
    <meta name="twitter:image" content="{{ $image ?? asset('images/og-default.jpg') }}">

    {{-- Schema.org JSON-LD --}}
    @php
        $websiteSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $siteName ?? config('app.name'),
            'url' => $url ?? url('/'),
            'inLanguage' => $locale ?? app()->getLocale(),
            'description' => $description ?? '',
        ];
    @endphp
    <script type="application/ld+json">
        {{ json_encode($websiteSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}
    </script>

    {{-- Additional SEO links from layouts --}}
    @include('layouts.seo-links')

    {{-- Laravel Head package output --}}
    @headMeta
    @headLink
    @headScript
    @headStyle

    {{-- Dark mode inline script (FOUC prevention) --}}
    <script>
        (function() {
            try {
                var theme = localStorage.getItem('theme');
                var systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (theme === 'dark' || (!theme && systemDark)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {}
        })();
    </script>

    {{-- Alpine.js bootstrap (if not already loaded) --}}
    @if (!isset($alpineLoaded))
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @php $alpineLoaded = true; @endphp
    @endif

    {{-- Critical CSS inline to prevent FOUC --}}
    <style>
        [x-cloak] { display: none !important; }
        .dark [x-cloak] { display: none !important; }
    </style>

    {{-- Filament & Livewire styles --}}
    @livewireStyles
    @filamentStyles

    {{-- Vite CSS (Tailwind, custom) --}}
    @vite('resources/css/app.css')
</head>
<body {{ $attributes->class(['font-sans antialiased']) }}>
    {{-- Component slot content --}}
    {{ $slot }}
</body>
</html>