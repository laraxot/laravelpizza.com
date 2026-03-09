# Event Model - Schema.org Implementation

> Stato reale: implementazione baseline presente, ma non sufficiente da sola per dichiarare copertura completa `schema.org/Event`. Vedi anche `schema-org-model-governance.md`.

## Overview

The Event model in LaravelPizza is designed to be fully compliant with **Schema.org/Event** for SEO optimization. This enables rich snippets in search results and better visibility on Google Events.

## Current Baseline

### Properties Implemented

| Schema.org Property | Model Field | Type |
|---------------------|-------------|------|
| `@type` | - | Event |
| `name` | `title` | Text |
| `description` | `description` | Text |
| `startDate` | `start_date` | DateTime |
| `endDate` | `end_date` | DateTime |
| `eventStatus` | `event_status` | EventStatusType |
| `eventAttendanceMode` | `event_attendance_mode` | EventAttendanceModeEnumeration |
| `location` | `location` | Place |
| `image` | `cover_image` | URL |
| `organizer` | `organizer` | Organization/Person |
| `offers` | `offers` | Offer |
| `url` | `url` | URL |
| `inLanguage` | `in_language` | Language |
| `duration` | `duration` | Duration (ISO 8601) |
| `maximumAttendeeCapacity` | `max_attendees` | Integer |
| `remainingAttendeeCapacity` | - | Computed |

### Enums

```php
// EventStatus (event_status)
EventStatus::SCHEDULED      // https://schema.org/EventScheduled
EventStatus::CANCELLED       // https://schema.org/EventCancelled
EventStatus::POSTPONED       // https://schema.org/EventPostponed
EventStatus::RESCHEDULED    // https://schema.org/EventRescheduled
EventStatus::COMPLETED      // https://schema.org/EventCompleted

// EventAttendanceMode (event_attendance_mode)
EventAttendanceMode::ONLINE      // https://schema.org/OnlineEventAttendanceMode
EventAttendanceMode::OFFLINE     // https://schema.org/OfflineEventAttendanceMode
EventAttendanceMode::MIXED       // https://schema.org/MixedEventAttendanceMode
```

## JSON Data Import

### Location
```
Modules/Meetup/database/json/events.json
```

### Format
```json
[
    {
        "status": "upcoming",
        "title": "Laravel 11 Release Pizza Party",
        "description": "Celebrate the release of Laravel 11 with fellow developers!",
        "date": "December 15, 2025",
        "time": "6:00 PM - 9:00 PM",
        "location": "Tech Hub Downtown, 123 Main St",
        "attendees_current": 5,
        "attendees_max": 30,
        "url": "/it/events/1"
    }
]
```

### Import Action

```bash
# Import all events from JSON
php artisan meetup:import-events

# Or via tinker
php artisan tinker --execute="echo app(Modules\Meetup\Actions\Event\ImportEventsFromJsonAction::class)->execute();"
```

### Action Classes

| Action | Purpose |
|--------|---------|
| `ImportEventsFromJsonAction` | Import events from JSON file |
| `SeedEventsFromJsonAction` | Seed events with validation |
| `CreateEventAction` | Create single event |
| `UpdateEventAction` | Update existing event |
| `DeleteEventAction` | Delete event |

## Usage in Blade Templates

### Basic Usage
```php
$event = Modules\Meetup\Models\Event::first();

// Get Schema.org JSON-LD
$schema = $event->toSchemaOrg();
```

### Output Example
```json
{
    "@context": "https://schema.org",
    "@type": "Event",
    "name": "Laravel 11 Release Pizza Party",
    "startDate": "[DATE]T18:00:00+01:00",
    "endDate": "[DATE]T21:00:00+01:00",
    "eventStatus": "https://schema.org/EventScheduled",
    "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
    "location": {
        "@type": "Place",
        "name": "Tech Hub Downtown, 123 Main St"
    },
    "description": "Celebrate the release of Laravel 11...",
    "url": "/it/events/1",
    "inLanguage": "it",
    "duration": "PT180M",
    "maximumAttendeeCapacity": 30
}
```

### In Blade Template
```blade
@php $event = Modules\Meetup\Models\Event::first(); @endphp

<script type="application/ld+json">
    @json($event->toSchemaOrg())
</script>
```

## SEO Benefits

1. **Google Events Rich Snippets** - Events appear with rich formatting in search results
2. **Social Media Preview** - Better previews when links are shared
3. **Structured Data Validation** - Passes Google's Structured Data Testing Tool
4. **Accessibility** - Semantic HTML improves screen reader compatibility

## Related Files

- `Modules/Meetup/app/Models/Event.php` - Main model
- `Modules/Meetup/app/Enums/EventStatus.php` - Event status enum
- `Modules/Meetup/app/Enums/EventAttendanceMode.php` - Attendance mode enum
- `Modules/Meetup/app/Actions/Event/ImportEventsFromJsonAction.php` - Import action
- `Modules/Meetup/database/json/events.json` - Sample events data

## References

- [Schema.org Event](https://schema.org/Event)
- [Google Events Structured Data](https://developers.google.com/search/docs/appearance/structured-data/event)
- [ISO 8601 Duration Format](https://en.wikipedia.org/wiki/ISO_8601#Durations)
