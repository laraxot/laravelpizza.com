<?php

declare(strict_types=1);

?>
<meta charset="utf-8">
<meta name="application-name" content="{{ $_theme->metatag('sitename') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="{{ $_theme->metatag('description') }}">
<meta name="robots" content="index,follow">
<meta nome="googlebot" content="index,follow">
<link rel="icon" type="image/x-icon" href="{{ $_theme->asset(config('metatag.logo_square')) }}">
<title>{{ $_theme->metatag('title') }}</title>


{{-- https://www.advancedwebranking.com/blog/meta-tags-important-in-seo --}}
{{-- <meta property="og:type" content="article" />
<meta property="og:title" content="TITLE OF YOUR POST OR PAGE" />
<meta property="og:description" content="DESCRIPTION OF PAGE CONTENT" />
<meta property="og:image" content="LINK TO THE IMAGE FILE" />
<meta property="og:url" content="PERMALINK" />
<meta property="og:site_name" content="SITE NAME" /> --}}

{{-- <meta name="twitter:title" content="TITLE OF POST OR PAGE">
<meta name="twitter:description" content="DESCRIPTION OF PAGE CONTENT">
<meta name="twitter:image" content="LINK TO IMAGE">
<meta name="twitter:site" content="@USERNAME">
<meta name="twitter:creator" content="@USERNAME"> --}}

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
