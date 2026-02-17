# Event Detail Page - February 2026

## URL Structure

- **Local**: `http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party`
- **Target**: `https://laravelpizza.com/events/1` (site currently down)

## Implementation

### Route (Folio)
- File: `Themes/Meetup/resources/views/pages/events/[slug].blade.php`
- Uses Volt component with Livewire
- Model binding by slug (SEO-friendly URLs)

### Component
- File: `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`
- Displays full event information:
  - Breadcrumb navigation
  - Cover image / placeholder
  - Status badge (Upcoming/Past)
  - Title
  - Date, time, location
  - Language (if set)
  - Attendees count
  - Description
  - CTA button (Register Now)
  - Back to events link

### Model
- File: `Modules/Meetup/app/Models/Event.php`
- `getRouteKeyName()` returns `slug` for SEO URLs
- `toSchemaOrg()` generates JSON-LD structured data

## Screenshots

- Desktop: `docs/screenshots/event-detail-desktop.png`
- Mobile: `docs/screenshots/event-detail-mobile.png`

## Features

- SEO-friendly URLs with slugs
- Schema.org JSON-LD structured data
- Responsive design (mobile/desktop)
- Breadcrumb navigation
- Event status badge
- Attendee tracking display
- Back to events link

## Related Files

- `Modules/Meetup/docs/events-page-implementation-feb2026.md`
- `Themes/Meetup/docs/events-page-theme.md`
