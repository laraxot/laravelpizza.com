# Events Detail Component - Slug0 Model Loading

## 🎯 Principio: Caricamento Automatico Modello da Slug0

Il componente `events/detail.blade.php` può ricevere `$slug0` tramite i content blocks JSON e caricare automaticamente il modello Event quando necessario.

## 📜 Flusso Completo

### 1. JSON Content Block + Slug0 dalla Route

**File**: `config/local/laravelpizza/database/content/pages/events_view.json`

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

**Nota**: Il JSON NON contiene `slug0` nel `data` block. Il `slug0` viene passato automaticamente tramite `$data` dal componente `<x-page>` che unisce i dati del block con i dati passati dalla route (`container0` e `slug0`).

### 2. Component Riceve Slug0

Il componente `events/detail.blade.php` riceve `$slug0` tramite `@props`:

```blade
@props([
    'event' => null,
    'item' => null,
    'container0' => null,
    'slug0' => null,
])
```

### 3. Caricamento Automatico Modello

Se `$event` e `$item` sono null ma `$slug0` è disponibile, il componente carica automaticamente il modello:

```php
@php
use Modules\Meetup\Models\Event;

// Support both 'event' (specific) and 'item' (generic) props
$eventModel = $event ?? $item;

// If no event/item provided but slug0 is available, load the Event model
if ($eventModel === null && !empty($slug0)) {
    $eventModel = Event::where('slug', $slug0)->first();
}
@endphp
```

### 4. Rendering con Dati Evento

Il componente renderizza usando i dati del modello Event caricato:

```blade
@if($eventModel instanceof Event)
    {{-- Renderizza con dati evento --}}
    {{ $eventModel->title }}
    {{ $eventModel->description }}
    {{-- ... --}}
@endif
```

## 🔄 Flusso Completo: URL → JSON → Component → Model → Render

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
5. Page Component: <x-page side="content" slug="events.view" :data="['container0' => 'events', 'slug0' => 'laravel-beginners-pizza-night']" />
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

## ✅ Vantaggi

1. **Flessibilità**: Il componente può ricevere il modello direttamente O solo lo slug
2. **CMS-Driven**: Il JSON definisce quale evento mostrare tramite slug0
3. **Agnostic**: Il componente gestisce sia modelli passati che caricamento da slug
4. **DRY**: Logica di caricamento centralizzata nel componente

## 📝 Pattern JSON per Event Detail

### Opzione 1: Passare Slug0 (Consigliata)

```json
{
    "content_blocks": {
        "it": [
            {
                "type": "events",
                "slug": "detail",
                "data": {
                    "view": "pub_theme::components.blocks.events.detail",
                    "slug0": "laravel-beginners-pizza-night",
                    "container0": "events"
                }
            }
        ]
    }
}
```

**Vantaggi:**
- ✅ Il componente carica automaticamente il modello
- ✅ Il JSON definisce quale evento mostrare
- ✅ Flessibile: cambia evento modificando solo il JSON

### Opzione 2: Passare Modello Direttamente

```json
{
    "content_blocks": {
        "it": [
            {
                "type": "events",
                "slug": "detail",
                "data": {
                    "view": "pub_theme::components.blocks.events.detail",
                    "event": {
                        "id": 1,
                        "slug": "laravel-beginners-pizza-night",
                        "title": "Laravel Beginners Pizza Night"
                    }
                }
            }
        ]
    }
}
```

**Nota**: Richiede serializzazione del modello nel JSON (meno comune).

## 🎨 Implementazione Component

Il componente ora usa una **Helper Class** ispirata al pattern Volt Class API per migliore organizzazione del codice. Vedi [Events Detail Volt Class Pattern](events-detail-volt-class-pattern.md) per dettagli.

```blade
@props([
    'event' => null,
    'item' => null,
    'container0' => null,
    'slug0' => null,
])

<?php
// Initialize helper with props from Blade @props directive
$helper = new EventDetailHelper(
    event: $event instanceof Event ? $event : null,
    item: $item,
    container0: $container0,
    slug0: $slug0,
);

// Get computed values (pattern simile a computed properties di Volt)
$eventModel = $helper->getEventModel();
$eventData = $helper->getEventData();
@endphp
```

## ✅ Best Practices

1. **Sempre passare slug0 nel JSON** quando si vuole mostrare un evento specifico
2. **Il componente gestisce il caricamento** automaticamente
3. **Fallback graceful** se il modello non viene trovato
4. **Supporto multiplo**: `$event`, `$item`, o `$slug0` - tutti funzionano

## 🔗 Riferimenti

- [Events Detail Volt Class Pattern](events-detail-volt-class-pattern.md) - Pattern Helper Class ispirato a Volt
- [Container0 Slug0 Agnostic Pattern](container0-slug0-agnostic-pattern.md)
- [Container0 Pattern Philosophy](container0-pattern-philosophy.md)
- [CMS JSON Content System](../../Modules/Cms/docs/json-content-system-architecture.md)
