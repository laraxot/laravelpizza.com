# Event Detail Page - Theme Implementation

## Status

Updated on 2026-03-09 after a real review of `/it/events/id-id-quidem-quae-eveniet-Jy1p`.

## Current route/component chain

- Folio route: `Themes/Meetup/resources/views/pages/[container0]/[slug0]/index.blade.php`
- CMS page slug: `events.view`
- Theme presenter: `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`

## Improvements applied

- kept the detail page on localized slug URLs (`/it/events/{slug}`)
- preserved schema.org JSON-LD and social share support
- added clearer event summary badges:
  - status
  - attendance mode
  - free entry
- improved location usefulness:
  - multiline rendering
  - direct map CTA
- added event metadata section when available:
  - organizer
  - registration opening date
  - audience
  - age range
  - topics/keywords
- replaced the misleading fake RSVP state with a real booking modal backed by:
  - `POST /events/{slug}/book`
  - `Themes/Meetup/Http/Controllers/EventBookingController.php`
- improved the attendees empty state when nobody has joined yet

## Review outcome on the real page

The page was not broken structurally anymore, but it still underused available event data and showed a CTA that looked actionable without clearly completing a real flow.

The theme presenter now aims to be:

- more informative
- more honest about booking behavior
- still DRY and presenter-only

## Related documentation

- `Themes/Meetup/docs/troubleshooting/undefined-pageslug-container0-view.md`
- `Modules/Meetup/docs/event-detail-page-status.md`
