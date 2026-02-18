# Block CMS per Event Detail - Frontend

## ⚠️ REGOLA FONDAMENTALE: NO Livewire/Volt per Frontend CMS-Driven!

**Il frontend pubblico utilizza ONLY Block CMS Blade statici. MAI Livewire/Volt!**

## Architettura Corretta

### Frontend (Pubblico) = Block CMS Blade
```
Themes/Meetup/resources/views/components/blocks/events/
├── detail.blade.php           # ✅ Block CMS per dettaglio evento
└── list.blade.php             # ✅ Block CMS per lista eventi
```

### Admin = Filament Widget
```
Modules/Meetup/app/Filament/Widgets/
├── EventStatsOverviewWidget.php   # ✅ Widget per admin
└── CalendarWidget.php             # ✅ Widget per admin
```

## Block CMS per Frontend

### Caratteristiche dei Block CMS

1. **Blade Template Puri**: Nessun Livewire/Volt
2. **Ricevono Dati dal CMS**: `$data`, `$item`, `$container0`, `$slug0`
3. **Caricamento Modello**: Se necessario, caricano il modello direttamente nel template
4. **SEO**: Rendering server-side completo

### Esempio: events/detail.blade.php

```blade
@props([
    'event' => null,
    'item' => null,
    'container0' => null,
    'slug0' => null,
])

@php
use Modules\Meetup\Models\Event;

// Supporto sia 'event' che 'item' (pattern agnostico)
$eventModel = $event ?? $item;

// Se non fornito ma abbiamo slug0, carichiamo il modello
if ($eventModel === null && !empty($slug0)) {
    $eventModel = Event::where('slug', $slug0)->first();
}

// Preparazione dati per la view
if ($eventModel instanceof Event) {
    $title = $eventModel->title;
    // ...
}
@endphp

{{-- Rendering HTML --}}
<div>
    <h1>{{ $title }}</h1>
</div>
```

## Perché NON usare Livewire/Volt per Frontend

| Motivo | Spiegazione |
|--------|-------------|
| **CMS-Driven** | I contenuti sono nel JSON, non nel componente |
| **SEO** | Rendering server-side puro è migliore per SEO |
| **Semplicità** | Meno complessità, meno JavaScript |
| **Performance** | No hydration overhead |
| **Architettura** | Folio + Blade + CMS è sufficiente |

## Quando USARE Filament Widget

I Filament Widget sono per l'**Admin Panel**:
- Dashboard statistiche
- Grafici e chart
- Gestione dati tabular
- Form complessi

```php
// ✅ CORRETTO - Widget per Admin
class EventStatsOverviewWidget extends XotBaseStatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Eventi Totali', Event::count()),
        ];
    }
}
```

## Pattern Corretto: Block con Caricamento Modello

### Block detail.events.blade.php

```blade
@props(['slug0' => null])

@php
// Caricamento modello se non fornito
$event = $event ?? Event::where('slug', $slug0)->first();
@endphp

@if($event)
    <h1>{{ $event->title }}</h1>
    <p>{{ $event->description }}</p>
@else
    <div>Evento non trovato</div>
@endif
```

## ❌ MAI Fare

```blade
{{-- ❌ SBAGLIATO: Livewire nel frontend CMS-driven --}}
@livewire(\Modules\Meetup\Livewire\EventDetail::class)

{{-- ❌ SBAGLIATO: Volt nel frontend CMS-driven --}}
@volt('event.detail')
```

## ✅ CORRETTO: Block CMS Blade

```blade
{{-- ✅ CORRETTO: Block CMS statico --}}
<x-page side="content" :slug="$pageSlug" :data="$data" />

{{-- Il block renderizza i dati dal CMS --}}
@include('pub_theme::components.blocks.events.detail', [
    'slug0' => $data['slug0'] ?? null,
])
```

## Riferimenti

- [Container0 Pattern](./container0-slug0-agnostic-pattern.md)
- [Filament Widget Documentation](./filament-widget-usage.md)
- [CMS Content Blocks](./content-blocks-system.md)
