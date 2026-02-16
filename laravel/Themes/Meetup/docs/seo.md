# SEO Guidelines for Meetup Theme

## Overview
Search Engine Optimization guidelines for the Laravel Pizza Meetup theme to maximize visibility and ranking.

## Philosophy
- **Content-First**: SEO supports content, doesn't replace it
- **User-Centric**: Optimize for users, not bots
- **Semantic**: Use proper HTML structure
- **Performance**: Fast loading = better ranking

## Technical SEO

### Meta Tags
```php
// Page Title (60 characters max)
<x-slot name="title">
    Laravel Pizza Meetups - Join 5,000+ Laravel Developers
</x-slot>

// Description (160 characters max)
<x-slot name="description">
    Join 5,000+ Laravel developers for exclusive meetups, tutorials, and networking. Free access to workshops and community events.
</x-slot>

// Keywords (comma-separated)
<x-slot name="keywords">
    Laravel meetup, PHP community, Laravel tutorials, Laravel workshops, Laravel networking, web development
</x-slot>
```

### Open Graph Tags
```php
// OG Type
<meta property="og:type" content="website">

// OG Title
<meta property="og:title" content="Laravel Pizza Meetups">

// OG Description
<meta property="og:description" content="Join 5,000+ Laravel developers for exclusive meetups">

// OG URL
<meta property="og:url" content="https://laravelpizza.com/it/auth/register">

// OG Image (1200x630px recommended)
<meta property="og:image" content="https://laravelpizza.com/images/og-image.png">

// OG Site Name
<meta property="og:site_name" content="Laravel Pizza Meetups">

// OG Locale
<meta property="og:locale" content="it_IT">
```

### Twitter Cards
```php
// Card Type
<meta name="twitter:card" content="summary_large_image">

// Twitter URL
<meta property="twitter:url" content="https://laravelpizza.com/it/auth/register">

// Twitter Title
<meta name="twitter:title" content="Laravel Pizza Meetups">

// Twitter Description
<meta name="twitter:description" content="Join 5,000+ Laravel developers for exclusive meetups">

// Twitter Image
<meta name="twitter:image" content="https://laravelpizza.com/images/twitter-image.png">
```

### Canonical URL
```php
// Prevent duplicate content
<link rel="canonical" href="https://laravelpizza.com/it/auth/register">
```

### Robots Meta
```php
// Allow indexing
<meta name="robots" content="index, follow">

// No index (for private pages)
<meta name="robots" content="noindex, nofollow">
```

## Semantic HTML

### Heading Structure
```php
// ✅ CORRECT - Proper hierarchy
<h1>Laravel Pizza Meetups</h1>
    <h2>Join Our Community</h2>
        <h3>Benefits</h3>
        <h3>Registration</h3>
    <h2>Upcoming Events</h2>
        <h3>Monthly Meetups</h3>
```

### Structured Data
```php
// Organization Schema
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Laravel Pizza Meetups",
    "url": "https://laravelpizza.com",
    "logo": "https://laravelpizza.com/images/logo.png",
    "sameAs": [
        "https://twitter.com/laravelpizza",
        "https://github.com/laravelpizza"
    ]
}
</script>

// Event Schema
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Event",
    "name": "Laravel Rome Meetup",
    "startDate": "[DATE]T19:00",
    "location": {
        "@type": "Place",
        "name": "Tech Hub Rome",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Via Roma 123",
            "addressLocality": "Rome",
            "postalCode": "00100",
            "addressCountry": "IT"
        }
    }
}
</script>

// Breadcrumb Schema
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "https://laravelpizza.com/it"
    },{
        "@type": "ListItem",
        "position": 2,
        "name": "Registration",
        "item": "https://laravelpizza.com/it/auth/register"
    }]
}
</script>
```

## Performance SEO

### Page Speed
```php
// Critical CSS Inline
<style>
    /* Critical CSS above fold */
</style>

// Lazy Load Images
<img src="placeholder.jpg" data-src="actual-image.jpg" loading="lazy" alt="Description">

// Preload Critical Resources
<link rel="preload" href="/fonts/inter.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="/css/critical.css" as="style">
```

### Image Optimization
```php
// Responsive Images
<picture>
    <source srcset="image.webp" type="image/webp">
    <source srcset="image.jpg" type="image/jpeg">
    <img src="image.jpg" alt="Description" loading="lazy">
</picture>

// WebP Format (smaller file size)
<img src="image.webp" alt="Description">

// Proper Dimensions (specify to prevent layout shift)
<img src="image.jpg" width="800" height="600" alt="Description">
```

### Resource Optimization
```php
// Minify CSS/JS
// Use Vite build process

// Gzip Compression
// Configure in server

// Browser Caching
// Set appropriate cache headers
```

## Content SEO

### Keyword Research
```php
// Primary Keywords
- Laravel meetup
- PHP community
- Laravel tutorials
- Laravel workshops

// Secondary Keywords
- Web development
- Programming
- Software engineering
- Open source

// Long-tail Keywords
- Laravel meetup in Italy
- Best Laravel tutorials 2026
- Laravel networking events
- Free Laravel workshops
```

### Content Optimization
```php
// Title Tag (60 characters)
"Laravel Pizza Meetups - Join 5,000+ Laravel Developers"

// Meta Description (160 characters)
"Join 5,000+ Laravel developers for exclusive meetups, tutorials, and networking. Free access to workshops and community events."

// H1 (include primary keyword)
<h1>Laravel Pizza Meetups - Join Our Community</h1>

// H2 (include secondary keywords)
<h2>Why Join Our Laravel Meetups?</h2>

// Body Content (natural keyword usage)
<p>Our Laravel meetups provide the perfect opportunity to connect with PHP developers...</p>
```

### URL Structure
```php
// ✅ CORRECT - SEO-friendly URLs
/it/auth/register
/it/events/laravel-rome-meetup
/it/tutorials/laravel-10-authentication

// ❌ WRONG - Poor URLs
/it/register.php
/it/events?id=123
/it/tutorials?slug=laravel-auth
```

## Multilingual SEO

### hreflang Tags
```php
// For each language version
<link rel="alternate" hreflang="it" href="https://laravelpizza.com/it/auth/register">
<link rel="alternate" hreflang="en" href="https://laravelpizza.com/en/auth/register">
<link rel="alternate" hreflang="de" href="https://laravelpizza.com/de/auth/register">
<link rel="alternate" hreflang="fr" href="https://laravelpizza.com/fr/auth/register">
<link rel="alternate" hreflang="es" href="https://laravelpizza.com/es/auth/register">
<link rel="alternate" hreflang="ru" href="https://laravelpizza.com/ru/auth/register">
<link rel="alternate" hreflang="x-default" href="https://laravelpizza.com/it/auth/register">
```

### Language-Specific Content
```php
// Italian
<title>Meetup Laravel Pizza - Unisciti a 5.000+ Sviluppatori</title>

// English
<title>Laravel Pizza Meetups - Join 5,000+ Developers</title>

// German
<title>Laravel Pizza Meetups - Werden Sie Teil unserer Community</title>
```

## Technical Implementation

### Sitemap.xml
```php
// Generate sitemap for all pages
// Include all language versions
// Submit to Google Search Console

// Example structure
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://laravelpizza.com/it/auth/register</loc>
        <lastmod>[DATE]</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
</urlset>
```

### Robots.txt
```php
// Allow all bots
User-agent: *
Allow: /

// Disallow admin areas
Disallow: /admin/
Disallow: /filament/

// Sitemap location
Sitemap: https://laravelpizza.com/sitemap.xml
```

### 404 Page
```php
// Custom 404 page
// Provide helpful navigation
// Return 404 status code
```

## Local SEO

### Google My Business
```php
// Claim business listing
// Add photos
// Encourage reviews
// Post updates
```

### Local Keywords
```php
// Include location in content
"Laravel Rome Meetup"
"PHP Developers in Italy"
"Tech Events in Milan"
```

### NAP Consistency
```php
// Name, Address, Phone
// Keep consistent across all platforms
```

## Analytics

### Google Analytics 4
```php
// Install GA4 tracking
// Set up events
// Track conversions
// Monitor user behavior
```

### Google Search Console
```php
// Verify ownership
// Submit sitemap
// Monitor indexed pages
// Check for errors
```

## Common Mistakes

### 1. Duplicate Content
```php
// ❌ WRONG - Same content on multiple URLs
/it/events/rome
/it/events/rome?page=1

// ✅ CORRECT - Canonical URL
<link rel="canonical" href="/it/events/rome">
```

### 2. Missing Alt Text
```php
// ❌ WRONG - No alt text
<img src="meetup.jpg">

// ✅ CORRECT - Descriptive alt text
<img src="meetup.jpg" alt="Laravel Rome Meetup with 50 developers">
```

### 3. Poor Heading Structure
```php
// ❌ WRONG - Skipped headings
<h1>Meetup</h1>
<h3>Registration</h3>

// ✅ CORRECT - Proper hierarchy
<h1>Meetup</h1>
<h2>Registration</h2>
<h3>Form Fields</h3>
```

### 4. Slow Page Load
```php
// ❌ WRONG - Unoptimized images
<img src="huge-image.jpg">

// ✅ CORRECT - Optimized images
<img src="image.webp" width="800" height="600" loading="lazy">
```

### 5. No Mobile Optimization
```php
// ❌ WRONG - Not mobile-friendly
<meta name="viewport" content="width=device-width">

// ✅ CORRECT - Mobile-first
<meta name="viewport" content="width=device-width, initial-scale=1">
```

## SEO Checklist

### On-Page SEO
- [ ] Unique title tag (60 chars)
- [ ] Meta description (160 chars)
- [ ] Proper heading hierarchy (H1 → H2 → H3)
- [ ] Keywords in first paragraph
- [ ] Internal links to related pages
- [ ] External links to authoritative sources
- [ ] Optimized images (alt text, dimensions)
- [ ] URL includes keywords

### Technical SEO
- [ ] Canonical URL
- [ ] Robots meta tag
- [ ] Structured data (schema.org)
- [ ] Sitemap.xml submitted
- [ ] Robots.txt configured
- [ ] HTTPS enabled
- [ ] Fast page load (< 3s)
- [ ] Mobile-friendly

### Content SEO
- [ ] High-quality, unique content
- [ ] Keyword research done
- [ ] Content length appropriate
- [ ] Multimedia included
- [ ] Regularly updated
- [ ] User-friendly formatting
- [ ] Clear CTAs
- [ ] Social sharing buttons

## Related Documentation
- [Layout System](./layout-system.md)
- [Typography System](./typography.md)
- [WCAG Accessibility](./wcag-accessibility.md)

## Credits
- SEO Guidelines: Google Webmaster Guidelines
- Structured Data: Schema.org
- Philosophy: User-centric, content-first, performance-driven