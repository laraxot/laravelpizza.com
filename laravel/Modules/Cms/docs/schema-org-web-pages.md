# schema.org web page types

Reference: https://schema.org/WebPage and subtypes.

## Type hierarchy

```
Thing
  CreativeWork
    WebPage
      AboutPage
      CheckoutPage
      CollectionPage
        MediaGallery
      ContactPage
      FAQPage
      ItemPage
      ProfilePage
      QAPage
      SearchResultsPage
```

## Type definitions and when to use each

### WebPage

The base type for any web page. Use it when no more specific subtype fits.

Key own properties:

| Property | Type | Description |
|---|---|---|
| `breadcrumb` | BreadcrumbList, Text | Navigation hierarchy for the page. |
| `lastReviewed` | Date | Date the content was last reviewed for accuracy. |
| `mainContentOfPage` | WebPageElement | The primary content area of the page. |
| `primaryImageOfPage` | ImageObject | The main image shown on the page. |
| `relatedLink` | URL | Links to related pages. |
| `reviewedBy` | Organization, Person | Who reviewed the content. |
| `significantLink` | URL | High-traffic non-navigation links on the page. |
| `speakable` | SpeakableSpecification, URL | Sections suitable for text-to-speech. |
| `specialty` | Specialty | Domain speciality of the content. |

Key inherited properties from `CreativeWork`:

| Property | Type | Description |
|---|---|---|
| `headline` | Text | The page title. Maps to the HTML `<title>`. |
| `description` | Text | Short description; maps to meta description. |
| `datePublished` | Date, DateTime | Publication date. |
| `dateModified` | Date, DateTime | Last modification date. |
| `author` | Person, Organization | Content author. |
| `publisher` | Person, Organization | Site or brand publishing the content. |
| `image` | ImageObject, URL | Representative image. |
| `keywords` | DefinedTerm, Text, URL | Relevant topics. |
| `inLanguage` | Language, Text | Content language (e.g. `'it'`, `'en'`). |
| `mainEntity` | Thing | The primary subject described by the page. |
| `about` | Thing | The topic the page is about. |

Key inherited properties from `Thing`:

| Property | Type | Description |
|---|---|---|
| `name` | Text | Page name. |
| `url` | URL | Canonical URL of the page. |
| `identifier` | PropertyValue, Text, URL | Unique identifier. |
| `sameAs` | URL | URLs of related pages (other locales, social profiles). |
| `alternateName` | Text | Alternative names. |

### ProfilePage

Use for pages that represent an individual person's or organization's profile.
It has no properties of its own beyond those inherited from `WebPage`. The type
itself signals the semantic purpose to search engines.

Use on: user profile pages, speaker pages, author pages.

Recommended additional markup: set `mainEntity` to the `Person` or `Organization`
described by the page.

### ItemPage

Use for pages devoted to a single item: a product, a hotel, an event, an article.

The type signals to search engines that this page is the canonical detail view for
one discrete entity. Combine it with the `mainEntity` property pointing to the
relevant type (e.g. `Event`, `Article`, `Product`).

Use on: single event detail pages, single article pages.

### CollectionPage

Use for pages that aggregate multiple related items: a list of events, an archive,
a gallery.

Subtype `MediaGallery` is available for collections of media items.

Use on: events listing page, articles archive, search results (but prefer
`SearchResultsPage` for search result pages).

### SearchResultsPage

Use for pages showing search results. Inherits all `WebPage` properties. The
type declaration alone is the signal; there are no additional own properties.

### ContactPage

Use for contact pages. No additional own properties.

### FAQPage

Use for FAQ pages. Combine with `mainEntity` containing `Question`/`Answer` markup
for individual FAQ entries.

### AboutPage

Use for about/company pages.

## Page-to-type mapping for LaravelPizza

| Page slug | JSON file | schema.org type | Notes |
|---|---|---|---|
| `home` | `home.json` | `WebPage` | General landing page. |
| `events` | `events.json` | `CollectionPage` | List of events. |
| `events.view` (event detail) | `events_view.json` | `ItemPage` | Single event. Combine with `Event` as `mainEntity`. |
| `about` | `about.json` | `AboutPage` | Community about page. |
| `contact` | `contact.json` | `ContactPage` | Contact form page. |
| `privacy` | `privacy.json` | `WebPage` | Legal page; no more specific type exists. |
| `terms` | `terms.json` | `WebPage` | Legal page; no more specific type exists. |
| User profile (future) | — | `ProfilePage` | Set `mainEntity` to `Person`. |
| Articles archive (future) | — | `CollectionPage` | |
| Single article (future) | — | `ItemPage` | Combine with `Article` as `mainEntity`. |

## How to add JSON-LD to CMS-driven pages

### Approach

Add a `schema-org` block to the `content_blocks` of each page JSON. The block
renders a `<script type="application/ld+json">` tag in the page head or body.

The block component receives a `schema` object with the structured data. It must
output the JSON-LD script tag and nothing else visible.

### Block structure in the page JSON

```json
{
    "type": "schema-org",
    "slug": "schema-home",
    "data": {
        "view": "pub_theme::components.blocks.schema-org.webpage",
        "schema": {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": "Laravel Pizza Meetups",
            "description": "The community for Laravel, Filament and Livewire developers.",
            "url": "https://laravelpizza.com/it/",
            "inLanguage": "it",
            "publisher": {
                "@type": "Organization",
                "name": "Laravel Pizza",
                "url": "https://laravelpizza.com"
            }
        }
    }
}
```

### ItemPage example for event detail

```json
{
    "type": "schema-org",
    "slug": "schema-event-detail",
    "data": {
        "view": "pub_theme::components.blocks.schema-org.webpage",
        "schema": {
            "@context": "https://schema.org",
            "@type": "ItemPage",
            "name": "Event Details - Laravel Pizza Meetups",
            "description": "Details for this Laravel Pizza meetup event.",
            "url": "https://laravelpizza.com/it/events/event-slug",
            "inLanguage": "it",
            "mainEntity": {
                "@type": "Event",
                "name": "Laravel Pizza Roma",
                "startDate": "2026-04-15T19:00:00+02:00",
                "location": {
                    "@type": "Place",
                    "name": "Roma, Italia"
                }
            }
        }
    }
}
```

For event detail pages the `mainEntity` values are dynamic. The Blade component
should accept dynamic overrides from the Volt page rather than reading them only
from the JSON.

### CollectionPage example for events list

```json
{
    "type": "schema-org",
    "slug": "schema-events-list",
    "data": {
        "view": "pub_theme::components.blocks.schema-org.webpage",
        "schema": {
            "@context": "https://schema.org",
            "@type": "CollectionPage",
            "name": "Upcoming Events - Laravel Pizza Meetups",
            "description": "Browse all upcoming Laravel developer meetups.",
            "url": "https://laravelpizza.com/it/events",
            "inLanguage": "it",
            "publisher": {
                "@type": "Organization",
                "name": "Laravel Pizza",
                "url": "https://laravelpizza.com"
            }
        }
    }
}
```

### ProfilePage example

```json
{
    "type": "schema-org",
    "slug": "schema-profile",
    "data": {
        "view": "pub_theme::components.blocks.schema-org.webpage",
        "schema": {
            "@context": "https://schema.org",
            "@type": "ProfilePage",
            "name": "User Profile - Laravel Pizza",
            "url": "https://laravelpizza.com/it/profile/username",
            "inLanguage": "it",
            "mainEntity": {
                "@type": "Person",
                "name": "Mario Rossi",
                "url": "https://laravelpizza.com/it/profile/mario-rossi"
            }
        }
    }
}
```

## Blade component for schema-org block

The component lives at:
`Themes/Meetup/resources/views/components/blocks/schema-org/webpage.blade.php`

Minimal implementation:

```blade
@php
    $output = json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
@endphp
<script type="application/ld+json">
{!! $output !!}
</script>
```

The component must be pushed to the `<head>` section. Use Laravel's `@push`
directive if the layout supports a `head` stack:

```blade
@push('head')
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush
```

## URL canonicalization with mcamara/laravel-localization

The `url` field in JSON-LD must always use the localized canonical URL. In Blade:

```blade
@php
    $canonicalUrl = LaravelLocalization::getLocalizedURL(
        LaravelLocalization::getCurrentLocale(),
        null,
        [],
        true
    );
@endphp
```

For pages where the URL is static (home, events list, contact), the value can be
hardcoded in the JSON file per locale. For dynamic pages (event detail, user profile)
the URL must be generated at render time and passed to the block component from the
Volt page.

## hreflang and sameAs

Use the `sameAs` property to cross-reference the same page in other locales:

```json
{
    "@type": "WebPage",
    "url": "https://laravelpizza.com/it/events",
    "inLanguage": "it",
    "sameAs": [
        "https://laravelpizza.com/en/events",
        "https://laravelpizza.com/de/events"
    ]
}
```

This complements the `<link rel="alternate" hreflang="...">` tags in the page head.

## Properties used in this project per page type

### Minimum required for all page types

- `@context`: always `"https://schema.org"`
- `@type`: the appropriate type from the mapping table above
- `name`: page title (matches the JSON `title` field)
- `url`: localized canonical URL
- `inLanguage`: current locale code (e.g. `"it"`, `"en"`)

### Recommended additions

- `description`: a short description of the page
- `publisher`: the `Organization` object for Laravel Pizza
- `datePublished` / `dateModified`: from the JSON `created_at` / `updated_at` fields
- `breadcrumb`: for deep pages (event detail, user profile)
- `primaryImageOfPage`: for pages with a hero image
- `mainEntity`: for `ItemPage` and `ProfilePage`

### Organization object (reuse across all pages)

```json
{
    "@type": "Organization",
    "name": "Laravel Pizza",
    "url": "https://laravelpizza.com",
    "logo": {
        "@type": "ImageObject",
        "url": "https://laravelpizza.com/images/logo.png"
    }
}
```

## What not to include

- Do not include properties without values. Omit rather than set to `null` or `""`.
- Do not include `datePublished` / `dateModified` on static legal pages unless
  the dates are meaningful.
- Do not use `SearchResultsPage` for the events list. That type is for pages
  showing results of a user-initiated search query. Use `CollectionPage` instead.

## References

- https://schema.org/WebPage
- https://schema.org/ProfilePage
- https://schema.org/ItemPage
- https://schema.org/CollectionPage
- https://schema.org/SearchResultsPage
- `laravel/Modules/Cms/docs/content-blocks-system.md`
- `laravel/Modules/Lang/docs/laravel-localization-complete-guide.md`
