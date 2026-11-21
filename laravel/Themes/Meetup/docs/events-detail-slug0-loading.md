# Events Detail Component - Slug0 Model Loading

## 🎯 Principio: Caricamento Automatico Modello da Slug

Il componente `events/detail.blade.php` è una **plain Blade view inclusa dal CMS** (NON Volt, NON Livewire, NON anonymous component Blade) e nel path standard `/it/events/{slug}` deve ricevere l'evento gia' risolto dal route layer.

## ✅ Pattern Corretto: Route Resolver + Include-Safe Plain Blade

```php
<?php

declare(strict_types=1);

/**
 * Event Detail - Plain Blade Component
 * Carica l'evento dallo slug nell'URL
 */

use Modules\Cms\Actions\ResolvePageAction;
use Modules\Meetup\Models\Event;

$container0 = (string) request()->route('container0', '');
$slug0 = (string) request()->route('slug0', '');

$resolved = app(ResolvePageAction::class)->execute($container0, $slug0);

$data = [
    'container0' => $container0,
    'slug0' => $slug0,
];

if ($resolved->item instanceof Event) {
    $data['item'] = $resolved->item;
    $data['event'] = $resolved->item;
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
5. Route Resolver nel Folio page plain Blade: `ResolvePageAction::execute('events', 'laravel-beginners-pizza-night')`
   - risolve `item` come `Modules\Meetup\Models\Event`
   - mantiene `pageSlug = events.view`
   ↓
6. Page Component: `<x-page side="content" slug="events.view" :data="[container0 => events, slug0 => laravel-beginners-pizza-night, item => Event]" />`
   ↓
7. JSON Lookup: Page::firstWhere('slug', 'events.view')
   ↓
8. JSON File: events_view.json
   ↓
9. Content Blocks: Carica blocchi dal JSON (view: 'pub_theme::components.blocks.events.detail')
   ↓
10. Block Rendering: page-content.blade.php fa array_merge($block->data, $this->data)
    ↓
11. Component Include: @include('pub_theme::components.blocks.events.detail', merged_data)
    ↓
12. Variabili PHP semplici: `$event`, `$item`, `$slug0`
    ↓
13. Rendering: il block presenta l'evento senza query DB nel Blade
```

## Regola su `x-page`

`x-page` non deve avere props dedicate per `container0` o `slug0`.

Questi valori fanno parte del contesto route e devono vivere in `data`, insieme a eventuali livelli successivi (`container1`, `slug1`, ...).

Questo mantiene il componente CMS generico e riusabile anche se il routing futuro aggiunge piu' segmenti dinamici.

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

**Il componente `events/detail.blade.php` non deve fare query al DB nel percorso standard del dettaglio**: l'evento va risolto una sola volta nel route layer e passato a `x-page`.

## ✅ Vantaggi

1. **KISS**: il block resta presenter puro
2. **DRY**: la risoluzione del modello resta in `ResolvePageAction`
3. **Robustezza**: niente query fragile nel Blade
4. **Manutenibile**: route layer decide il dato, block decide il rendering

## 🔴 MAI Fare

❌ Non usare Volt/Livewire nei block components
❌ Non usare `wire:` directives nei block components  
❌ Non usare `@props([...])` in una view renderizzata via `@include`
❌ Non fare query `Event::query()->where('slug', ...)` nel block di dettaglio standard
❌ Non passare dati complessi nel JSON block

## ✅ Best Practices

1. **Blade Puro** per block components (rendering)
2. **ResolvePageAction** nel route layer per i dettagli dinamici
3. **Filament Widgets** per interattività server-side

## 🔗 Riferimenti

- [Filament Widgets NOT Livewire Critical Rule](filament-widgets-not-livewire-critical-rule.md)
- [Events Detail Volt Class Pattern](events-detail-volt-class-pattern.md)
- [Container0 Slug0 Agnostic Pattern](container0-slug0-agnostic-pattern.md)
- [CMS JSON Content System](../../modules/cms/docs/json-content-system-architecture.md)
