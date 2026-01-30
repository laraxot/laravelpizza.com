<head>
    <title>{{ $meta->getTitle() }}</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SEO Basics --}}
    <meta name="title" content="{{ $meta->getTitle() }}">
    <meta name="description" content="{{ $meta->getDescription(limit: 160) }}">
    <meta name="keywords" content="{{ $meta->getKeywords() }}">
    <meta name="author" content="{{ $meta->getAuthor() }}">
    <meta name="robots" content="{{ $meta->getRobots() }}">
    <link rel="canonical" href="{{ $meta->getCanonical() }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="{{ $meta->getType() }}">
    <meta property="og:site_name" content="{{ $meta->getSitename() }}">
    <meta property="og:title" content="{{ $meta->getTitle() }}">
    <meta property="og:description" content="{{ $meta->getDescription(limit: 160) }}">
    <meta property="og:url" content="{{ $meta->getCanonical() }}">
    <meta property="og:image" content="{{ $meta->getImage() }}">
    <meta property="og:site_name" content="{{ $meta->getSitename() }}">
    <meta property="og:locale" content="{{ $meta->getLocale() }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $meta->getCurrentUrl() }}">
    <meta name="twitter:title" content="{{ $meta->getTitle() }}">
    <meta name="twitter:description" content="{{ $meta->getDescription(limit: 160) }}">
    <meta name="twitter:image" content="{{ $meta->getImage() }}">

    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="//www.google-analytics.com">

    {{-- Favicon (multi-size) --}}
    <link rel="icon" type="image/x-icon" href="{{ $meta->getPubThemeAsset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ $meta->getFaviconBySize(size: '32x32', format: 'png') }}"
        sizes="32x32">
    <link rel="icon" type="image/png" href="{{ $meta->getFaviconBySize(size: '16x16', format: 'png') }}"
        sizes="16x16">
    <link rel="apple-touch-icon" href="{{ $meta->getFaviconBySize(size: '180x180', format: 'png') }}">
    <link rel="manifest" href="{{ $meta->getSiteWebmanifest() }}">

    {{-- Theme color and localized routes (commented out for now)
    <meta name="theme-color" content="#ffffff">
    --}}

    {{ $slot }}
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/' . $meta->getPubTheme())
</head>
