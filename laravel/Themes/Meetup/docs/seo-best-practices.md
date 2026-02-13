# SEO Best Practices - Meetup Theme

## Core Principles

- **Crawlability and Indexability**: Ensure search engines can easily access and understand your content.
- **Relevant Content**: Create high-quality, relevant content that matches user intent.
- **User Experience**: A good user experience (fast loading, mobile-friendly) contributes significantly to SEO.

## Implementation Guidelines

- **Meta Tags**: Optimize `<title>` tags and `<meta name="description">` for each page.
    - **Title**: Should be unique, concise (50-60 characters), and include relevant keywords.
    - **Description**: Compelling and descriptive (150-160 characters), summarizing the page content.
- **Schema.org Markup**: Use structured data (JSON-LD) to provide search engines with rich information about events, organizations, and other entities.
- **Image Optimization**: Use descriptive `alt` tags for all images. Optimize image file sizes for faster loading.
- **Mobile-Friendliness**: Ensure the theme is fully responsive and provides a seamless experience on all devices.
- **Fast Page Load Times**: Optimize CSS, JavaScript, and images. Leverage browser caching.
- **Clear URLs**: Use clean, descriptive, and keyword-rich URLs.
- **Internal Linking**: Implement a logical internal linking structure to help search engines discover important pages and pass link equity.
- **XML Sitemaps**: Generate and submit XML sitemaps to search engines to aid crawling.
- **Robots.txt**: Use `robots.txt` to guide search engine crawlers and prevent indexing of irrelevant content.
- **Semantic HTML**: Use appropriate HTML5 semantic tags (e.g., `<header>`, `<nav>`, `<main>`, `<article>`, `<section>`, `<footer>`) to clearly define content structure.

## Example (Folio Page Metadata)

```php
// In your Folio page Blade file
<x-layouts.app>
    <x-slot:title>Laravel Meetup - Next Event</x-slot:title>
    <x-slot:description>Find and join local Laravel meetups in your city. Stay updated with the latest events and network with fellow developers.</x-slot:description>

    {{-- Schema.org Markup for an Event --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Event",
      "name": "Monthly Laravel Meetup",
      "startDate": "2024-03-20T18:00:00+01:00",
      "endDate": "2024-03-20T20:00:00+01:00",
      "location": {
        "@type": "Place",
        "name": "Tech Hub",
        "address": {
          "@type": "PostalAddress",
          "streetAddress": "123 Main St",
          "addressLocality": "City",
          "addressRegion": "State",
          "postalCode": "12345",
          "addressCountry": "Country"
        }
      },
      "image": "https://example.com/images/meetup-banner.jpg",
      "description": "Join us for our monthly Laravel meetup to discuss new features, best practices, and network with local developers.",
      "organizer": {
        "@type": "Organization",
        "name": "Laravel Pizza Community",
        "url": "https://laravelpizza.com"
      }
    }
    </script>
</x-layouts.app>
```
