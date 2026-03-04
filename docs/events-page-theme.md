# Events Page - Theme Implementation

## Status: ✅ WORKING

The events page at `http://127.0.0.1:8000/it/events` is now displaying events from the database.

## Component

`Themes/Meetup/resources/views/components/blocks/events/list.blade.php`

## Features

- Events loaded dynamically from `Modules\Meetup\Models\Event`
- Scope filtering: `upcoming` scope
- Ordering: by `start_date` ascending
- SEO-friendly URLs with slugs

## Screenshots

- Desktop: `docs/screenshots/events-page-desktop.png`
- Mobile: `docs/screenshots/events-page-mobile.png`

## Related Documentation

- `Modules/Meetup/docs/events-page-implementation-feb2026.md`
