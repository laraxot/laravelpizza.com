# Events System - CMS-Driven Pages

## Overview

The events system uses CMS-driven pages with JSON files and Plain Blade components to display event lists and event details.

## REGOLA D'ORO: Plain Blade > Volt!

> **Plain Blade è la scelta migliore quando NON serve interactivity!**

Solo usare Volt/Livewire quando serve:
- Form con validazione server
- Modali interattive
- Dropdown dinamici
- Real-time updates

Per la visualizzazione di eventi: **Plain Blade**!

## Pages

### Events List (`/it/events`)
- **Route**: `route('events.index')`
- **JSON**: `config/local/laravelpizza/database/content/pages/events.json`
- **View**: `pub_theme::components.blocks.events.list`

### Event Detail (`/it/events/{slug}`)
- **Route**: Folio catch-all `[container0]/[slug0]/index.blade.php`
- **JSON**: `config/local/laravelpizza/database/content/pages/events_view.json`
- **View**: `pub_theme::components.blocks.events.detail` (Plain Blade!)

## JSON Configuration

### events.json (List)
```json
{
    "slug": "events",
    "content_blocks": {
        "it": [
            {
                "type": "events",
                "slug": "events-list",
                "data": {
                    "view": "pub_theme::components.blocks.events.list",
                    "title": "Upcoming Events"
                }
            }
        ]
    }
}
```

### events_view.json (Detail)
```json
{
    "slug": "events.view",
    "content_blocks": {
        "it": [
            {
                "type": "events",
                "slug": "event-detail",
                "data": {
                    "view": "pub_theme::components.blocks.events.detail"
                }
            }
        ]
    }
}
```

## Plain Blade Component Pattern (PREFERITO!)

```php
// themes/meetup/resources/views/components/blocks/events/detail.blade.php
<?php

declare(strict_types=1);

/**
 * Event Detail - Plain Blade Component
 * Carica l'evento dallo slug nell'URL
 */

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Models\Event;

// Carica l'evento dallo slug
$slug0 = $slug0 ?? '';
$slugToUse = $slug0;
if (empty($slugToUse)) {
    $slugToUse = Request::segment(3);
}
$event = null;
if (!empty($slugToUse)) {
    $event = Event::where('slug', $slugToUse)->first();
}

$eventsUrl = LaravelLocalization::localizeUrl('/events');
$isUpcoming = $event?->start_date?->isFuture() ?? true;
?>

<div>
    <h1>{{ $event?->title ?? 'Event Title' }}</h1>
    <!-- resto del template -->
</div>
```

## Container0/Slug0 Pattern

Used for nested page rendering:
- `container0`: First URL segment after locale (e.g., "events")
- `slug0`: Full slug (e.g., "laravel-11-release-pizza-party-1")

### URL Structure
```
/it/events                     → container0="events", slug0=""
/it/events/laravel-11-release  → container0="events", slug0="laravel-11-release"
```

## Theme Namespace

Always use `pub_theme::` namespace (NOT theme name):
```blade
{{-- Correct --}}
@include('pub_theme::components.blocks.events.detail')
<x-pub_theme::components.layouts.main>

{{-- Wrong --}}
@include('meetup::components.blocks.events.detail')
```

## Translations

Theme translations use `pub_theme::` namespace:
```
pub_theme::event.back_to_events.label
pub_theme::event.date.label
pub_theme::event.time.label
pub_theme::event.location.label
pub_theme::event.about_this_event.label
pub_theme::event.join_event.label
pub_theme::event.book_your_spot.label
```

## Common Issues

### 1. Usare Volt quando Plain Blade è sufficiente
**ERRATO**: Creare un componente Volt per visualizzare dati statici
**CORRETTO**: Usare Plain Blade con PHP inline

### 2. Property not found in Volt
**Cause**: Props non passate correttamente al componente
**Fix**: Usare Plain Blade + `Request::segment(n)` per ottenere parametri URL

### 3. View not found
**Cause**: Block references non-existent view path
**Fix**: Verify view exists in `Themes/Meetup/resources/views/components/blocks/events/`

## Files

| File | Purpose |
|------|---------|
| `config/local/.../pages/events.json` | Events list page definition |
| `config/local/.../pages/events_view.json` | Event detail page definition |
| `Themes/Meetup/resources/views/pages/[container0]/[slug0]/index.blade.php` | Folio catch-all route |
| `Themes/Meetup/resources/views/components/blocks/events/list.blade.php` | Events list component (Volt se serve interactivity) |
| `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php` | Event detail component (Plain Blade!) |
| `Themes/Meetup/lang/it/event.php` | Italian translations |
| `Themes/Meetup/lang/en/event.php` | English translations |

## See Also
- [CMS-Driven Pages System](../cms/docs/cms-driven-pages-system.md)
- [Folio Volt Architecture](./folio-volt-filament-architecture.md)
