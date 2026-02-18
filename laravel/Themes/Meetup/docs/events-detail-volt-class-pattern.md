# Events Detail Component - Plain Blade Pattern

## 🎯 Principio: Componente Blade Puro

Il componente `events/detail.blade.php` è un **Plain Blade Component** (NON Volt, NON Livewire). 
Carica l'evento direttamente dallo slug nell'URL.

## ✅ Pattern Corretto (Blade Puro)

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

$eventsUrl = LaravelLocalization::localizeUrl('/events');
$isUpcoming = $event?->start_date?->isFuture() ?? true;
$statusLabel = $isUpcoming ? 'Upcoming' : 'Past Event';
$badgeClass = $isUpcoming ? 'bg-green-600' : 'bg-slate-500';
$availableSpots = ($event?->max_attendees ?? 100) - ($event?->attendees_count ?? 0);
$currentAttendees = $event?->attendees_count ?? 0;
?>

<div>
    ... rendering con $event, $eventsUrl, etc.
</div>
```

## 📜 Flusso Completo

1. **URL**: `/it/events/laravel-beginners-pizza-night`
2. **Folio Route**: `[container0]/[slug0]/index.blade.php`
3. **JSON Lookup**: `events_view.json` (slug: `events.view`)
4. **Block**: `{type: "events", view: "pub_theme::components.blocks.events.detail"}`
5. **Component**: `events/detail.blade.php` - carica Event da slug
6. **Render**: Visualizza i dati dell'evento

## 🔴 MAI USARE

❌ **NON usare Volt/Livewire** nei block components
❌ **NON usare `@volt()`** nel block component
❌ **NON usare `wire:` directives** nei block components

## ✅ Quando Usare Cosa

| Tipo | Uso | Esempio |
|------|-----|---------|
| **Blade Puro** | Rendering statico | Block components, liste, dettagli |
| **Filament Widget** | Interattività server | Form, azioni, modali |
| **Volt** | Solo nella routing page | `[container0]/[slug0]/index.blade.php` |

## Riferimenti

- [Volt Components Usage](volt-components-usage.md)
- [Filament Widgets NOT Livewire Critical Rule](filament-widgets-not-livewire-critical-rule.md)
- [Events Detail Slug0 Loading](events-detail-slug0-loading.md)
- [Container0 Slug0 Agnostic Pattern](container0-slug0-agnostic-pattern.md)
