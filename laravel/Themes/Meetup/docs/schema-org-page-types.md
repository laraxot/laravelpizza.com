# Schema.org Compliance — Theme Integration

## Page Type Mapping

Every page rendered by the Meetup theme must include a `<script type="application/ld+json">` tag with the correct Schema.org `@type`.

### Page Types

| Page Route | Schema.org `@type` | Notes |
|---|---|---|
| `/it` (home) | `WebPage` | Standard homepage |
| `/it/events` | `CollectionPage` | `mainEntity` = `ItemList` of `Event`s |
| `/it/events/{slug}` | `WebPage` | `mainEntity` = `Event` (from model) |
| `/it/profile/{id}` | `ProfilePage` | `mainEntity` = `Person` |
| `/it/terms` | `WebPage` | Legal page |
| `/it/privacy` | `WebPage` | Legal page |
| `/it/about` | `AboutPage` | `mainEntity` = `Organization` |
| `/it/contact` | `ContactPage` | `contactPoint` info |

### ProfilePage Requirements

According to [schema.org/ProfilePage](https://schema.org/ProfilePage), a profile page must:

1. Set `@type` to `ProfilePage`
2. Include `mainEntity` as `Person` with:
   - `givenName`, `familyName`
   - `email`
   - `image` (avatar)
   - `sameAs` (social links)
   - `jobTitle`, `affiliation` (if available)
3. Include `dateCreated` and `dateModified`

### WebPage Common Properties

All pages should include:

- `@type` (specific page type)
- `name` (page title)
- `description` (meta description)
- `url` (canonical URL)
- `inLanguage` (current locale)
- `isPartOf` → `WebSite` with `name` and `url`
- `breadcrumb` → `BreadcrumbList`
- `datePublished` / `dateModified`

### Event Detail Page Properties

Must include the full `Event` object from `Event::toSchemaOrg()` as `mainEntity`.

## Implementation

The Schema.org JSON-LD must be emitted via the `<x-metatags />` component (in `x-layouts.main`).
The metatags component should accept a `schemaOrg` prop containing the structured data array.

## References

- [Schema.org types for page types](https://schema.org/WebPage)
- [Module docs](../../Modules/Meetup/docs/schema-org-full-compliance-plan.md)
