<head>
    <title>{{ $title }}</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SEO Basics --}}
    <meta name="title" content="{{ $title }}">
    <meta name="description" content="{{ $description }}">
    <meta name="keywords" content="{{ $meta->getKeywords() }}">
    <meta name="author" content="{{ $meta->getAuthor() }}">
    <meta name="robots" content="{{ $meta->getRobots() }}">
    <link rel="canonical" href="{{ $meta->getCanonical() }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="{{ $meta->getType() }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ $meta->getCanonical() }}">
    <meta property="og:image" content="{{ $meta->getImage() }}">
    <meta property="og:site_name" content="{{ $meta->getSitename() }}">
    <meta property="og:locale" content="{{ $meta->getLocale() }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $meta->getCurrentUrl() }}">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $meta->getImage() }}">

    {{-- Nessun preconnect verso Google Fonts o Analytics: aprire la connessione invia l'IP del visitatore a terzi prima del consenso --}}

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

    @if(isset($pageSchema) && is_array($pageSchema) && $pageSchema !== [])
        <script type="application/ld+json">{!! json_encode($pageSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR) !!}</script>
    @endif

    {{ $slot }}
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/' . $meta->getPubTheme())
</head>
