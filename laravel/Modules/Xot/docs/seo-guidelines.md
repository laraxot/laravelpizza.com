# SEO Guidelines

## Overview

This document outlines SEO best practices for <nome progetto> Meetups.

## Meta Tags

### Required Meta Tags
```blade
<x-slot name="title">
    {{ __('Page Title') }} - <nome progetto> Community
</x-slot>

<x-slot name="description">
    {{ __('Page description with relevant keywords') }}
</x-slot>

<x-slot name="keywords">
    Laravel meetup, Laravel community, PHP developer, etc.
</x-slot>
```

### Open Graph
```blade
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $imageUrl }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
```

### Twitter Cards
```blade
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $imageUrl }}">
```

## Structured Data

### JSON-LD for Organization
```blade
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "<nome progetto> Meetups",
    "url": "https://<nome progetto>.com",
    "logo": "https://<nome progetto>.com/logo.png",
    "sameAs": [
        "https://twitter.com/<nome progetto>",
        "https://github.com/laraxot/<nome progetto>"
    ]
}
</script>
```

### JSON-LD for Events
```blade
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Event",
    "name": "{{ $event->title }}",
    "startDate": "{{ $event->start_date->toIso8601String() }}",
    "location": {
        "@type": "VirtualEvent",
        "name": "Online"
    }
}
</script>
```

## URL Structure

### Best Practices
- Use lowercase
- Use hyphens (not underscores)
- Include keywords
- Keep URLs short
- Use HTTPS

### Examples
```
/it/auth/register     ✓
/en/auth/register    ✓
/it/registrazione    ✓
/RegisterPage        ✗
```

## Multilingual SEO

### hreflang Implementation
```blade
<link rel="alternate" hreflang="it" href="{{ localizeUrl('/auth/register', 'it') }}">
<link rel="alternate" hreflang="en" href="{{ localizeUrl('/auth/register', 'en') }}">
<link rel="alternate" hreflang="x-default" href="{{ localizeUrl('/auth/register', 'en') }}">
```

## Performance SEO

### Core Web Vitals
- **LCP** (Largest Contentful Paint): < 2.5s
- **FID** (First Input Delay): < 100ms
- **CLS** (Cumulative Layout Shift): < 0.1

### Optimization Techniques
1. Image optimization (WebP, lazy loading)
2. CSS/JS minification
3. Font display: swap
4. Preload critical assets

## Content SEO

### Keyword Strategy
1. Primary keyword in title (H1)
2. Secondary keywords in H2/H3
3. Keywords in first paragraph
4. Natural keyword density (1-2%)
5. LSI keywords for context

### Internal Linking
- Link related content
- Use descriptive anchor text
- Maintain logical hierarchy

## Technical SEO Checklist

- [ ] XML sitemap
- [ ] Robots.txt
- [ ] Canonical URLs
- [ ] 404 page custom
- [ ] HTTPS everywhere
- [ ] Mobile-friendly (responsive)
- [ ] Fast loading (< 3s)
- [ ] Clean URL structure
- [ ] hreflang for multilingual

## Translation Keys for SEO

All translatable SEO content should use translation files:
```php
// modules/Gdpr/lang/it/register.php
'seo' => [
    'title' => 'Registrati - <nome progetto>',
    'description' => 'Iscriviti alla community...',
]
```

## Related Documentation
- [UI/UX Guidelines](./ui-ux-guidelines.md)
- [WCAG Accessibility](./wcag-accessibility-guidelines.md)
- [Clickbait & Conversion](./clickbait-conversion-guidelines.md)
