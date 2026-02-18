# Events Detail Component - Slug0 Model Loading

## 🎯 Principio: Caricamento Automatico Modello da Slug

Il componente `events/detail.blade.php` è un **Plain Blade Component** (NON Volt, NON Livewire) che carica automaticamente l'evento dallo slug nell'URL.

## ✅ Pattern Corretto: Plain Blade

```php
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

// Variabili per il template
$eventsUrl = LaravelLocalization::localizeUrl('/events');
$isUpcoming = $event?->start_date?->isFuture() ?? true;
$statusLabel = $isUpcoming ? 'Upcoming' : 'Past Event';
$badgeClass = $isUpcoming ? 'bg-green-600' : 'bg-slate-500';
$availableSpots = ($event?->max_attendees ?? 100) - ($event?->attendees_count ?? 0);
$currentAttendees = $event?->attendees_count ?? 0;
?>
```

## 📜 Flusso Completo: URL → JSON → Component → Model → Render

```
1. URL: /it/events/laravel-beginners-pizza-night
   ↓
2. Folio Route: [container0]/[slug0]/index.blade.php
   ↓
3. Estrazione: container0='events', slug0='laravel-beginners-pizza-night'
   ↓
4. Resolve Content (in [container0]/[slug0]/index.blade.php):
   a) Cerca JSON con slug esatto: 'events.laravel-beginners-pizza-night' → non trovato
   b) Cerca JSON con slug generico: 'events.view' → trovato ✅
   ↓
5. Page Component: <x-page side="content" slug="events.view" :data="[container0 => events, slug0 => laravel-beginners-pizza-night]" />
   ↓
6. JSON Lookup: Page::firstWhere('slug', 'events.view')
   ↓
7. JSON File: events_view.json
   ↓
8. Content Blocks: Carica blocchi dal JSON (view: 'pub_theme::components.blocks.events.detail')
   ↓
9. Block Rendering: page-content.blade.php fa array_merge($block->data, $this->data)
   ↓
10. Component Include: @include('pub_theme::components.blocks.events.detail', merged_data)
    ↓
11. Component Props: $slug0 = 'laravel-beginners-pizza-night' (da $data passato da Page)
    ↓
12. Model Loading: Event::where('slug', $slug0)->first() (nel componente events/detail.blade.php)
    ↓
13. Rendering: Component renderizza con dati Event caricato
```

## 📝 Pattern JSON per Event Detail

Il JSON content block referenzia solo la view, SENZA logica:

```json
{
    "slug": "events.view",
    "content_blocks": {
        "it": [
            {
                "type": "events",
                "slug": "events-list",
                "data": {
                    "view": "pub_theme::components.blocks.events.detail"
                }
            }
        ]
    }
}
```

**Il componente `events/detail.blade.php` carica autonomamente l'evento dallo slug** - non serve passare dati aggiuntivi nel JSON.

## ✅ Vantaggi

1. **Semplicità**: Il componente è auto-sufficiente
2. **Agnostico**: Funziona con qualsiasi slug passato dalla route
3. **DRY**: Nessuna logica duplicata nel JSON
4. **Manutenibile**: Logica centralizzata nel componente

## 🔴 MAI Fare

❌ Non usare Volt/Livewire nei block components
❌ Non usare `wire:` directives nei block components  
❌ Non passare dati complessi nel JSON block

## ✅ Best Practices

1. **Blade Puro** per block components (rendering)
2. **Filament Widgets** per interattività server-side
3. **Volt** solo nelle routing pages (`[container0]/[slug0]/index.blade.php`)

## 🔗 Riferimenti

- [Filament Widgets NOT Livewire Critical Rule](filament-widgets-not-livewire-critical-rule.md)
- [Events Detail Volt Class Pattern](events-detail-volt-class-pattern.md)
- [Container0 Slug0 Agnostic Pattern](container0-slug0-agnostic-pattern.md)
- [CMS JSON Content System](../../Modules/Cms/docs/json-content-system-architecture.md)
