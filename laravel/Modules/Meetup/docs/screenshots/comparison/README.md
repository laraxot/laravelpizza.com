# Event Detail Page - Comparison with laravelpizza.com

## URLs

- **Local**: `http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party`
- **Reference**: `https://laravelpizza.com/events/1`

## Screenshots Comparison

- **Local (current)**: `docs/screenshots/comparison/local-event-detail.png`
- **Reference (laravelpizza.com)**: `docs/screenshots/comparison/laravelpizza-event-detail.png`

## Implementation Files

### Folio Page
`Themes/Meetup/resources/views/pages/events/[slug].blade.php`

### Component
`Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`

### Model
`Modules/Meetup/app/Models/Event.php`

## Current Features

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
- Schema.org JSON-LD

## TODO: Match laravelpizza.com Design

The local page needs to match the design of laravelpizza.com. Key differences to address:
- Layout structure
- Color scheme
- Typography
- Spacing
- Components
