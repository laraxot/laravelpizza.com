# CMS-Driven Pages System

## Overview

The CMS-driven pages system allows content management through JSON files stored in `config/local/{tenant}/database/content/pages/`. Each JSON file defines a page with its content blocks.

## JSON Page Structure

```json
{
    "id": "1",
    "title": {
        "it": "Page Title",
        "en": "Page Title"
    },
    "slug": "page-slug",
    "middleware": null,
    "content": null,
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "slug": "hero-1",
                "data": {
                    "view": "pub_theme::components.blocks.hero.main",
                    "title": "Hero Title",
                    "subtitle": "Hero subtitle"
                }
            }
        ]
    },
    "sidebar_blocks": {
        "it": []
    },
    "footer_blocks": {
        "it": []
    }
}
```

## Block Types

### Plain Blade Component (PREFERITO!)
Plain Blade è la scelta migliore quando NON serve interactivity (server interaction).

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
    ...
</div>
```

### Livewire/Volt Component
Solo quando serve interactivity (form, modali, dropdown, ecc.):

```json
{
    "type": "events",
    "data": {
        "view": "pub_theme::components.blocks.events.list",
        "query": {
            "model": "Modules\\Meetup\\Models\\Event"
        }
    }
}
```

## Container0/Slug0 Pattern

The `container0` and `slug0` parameters enable nested page rendering.

### Flow

1. **URL**: `/it/events/laravel-11-release-pizza-party-1`
   - `container0` = "events"
   - `slug0` = "laravel-11-release-pizza-party-1"

2. **Folio Route** (`[container0]/[slug0]/index.blade.php`):

```php
<?php
declare(strict_types=1);

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('container0.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public string $container0 = '';
    public string $slug0 = '';
    public string $pageSlug = '';
    public array $data = [];

    public function mount(): void
    {
        $this->pageSlug = $this->container0 . '.view';
        $this->data = [
            'container0' => $this->container0,
            'slug0' => $this->slug0,
        ];
    }
};
?>

<x-layouts.app>
    @volt('container0.view')
        <x-page 
            side="content" 
            :slug="$pageSlug" 
            :data="$data"
        />
    @endvolt
</x-layouts.app>
```

## Common Errors

### 1. Usare Volt quando Plain Blade è sufficiente
**ERRATO**: Creare un componente Volt per visualizzare dati statici
**CORRETTO**: Usare Plain Blade con PHP inline

### 2. Undefined variable in Volt
**Cause**: Usare `$variabile` invece di `$this->variabile` nel template
**Solution**: Includere nel blocco `@volt` e usare `$this->`

### 3. Volt property not found
**Cause**: Props non passate correttamente al componente
**Solution**: Usare Plain Blade + `Request::segment(n)` per ottenere parametri URL

## Regola d'Oro

> **Plain Blade > Volt** quando NON serve interactivity

Solo creare componenti Volt/Livewire quando serve:
- Form con validazione server
- Modali interattive
- Dropdown dinamici
- Real-time updates
- Callbacks al server

Per tutto il resto: **Plain Blade**!

## Key Files

| File | Purpose |
|------|---------|
| `Modules/Cms/app/View/Components/Page.php` | Main Page component |
| `Modules/Cms/resources/views/components/page.blade.php` | Page template |
| `Modules/Cms/resources/views/components/page-content.blade.php` | Block renderer |
| `Modules/Cms/app/Http/Middleware/PageSlugMiddleware.php` | Page middleware |
| `config/local/laravelpizza/database/content/pages/*.json` | Page definitions |

## See Also
- [Componenti Blocchi Contenuto](./componenti-blocchi-contenuto.md)
- [Content Management](./content-management.md)
- [Folio Volt Architecture](../meetup/docs/folio-volt-filament-architecture.md)
