# Volt Component Pattern - Flat Properties

## Overview

Questo documento definisce il pattern standard per i componenti Volt nel tema Meetup, con l'uso di **flat public properties** popolate nel metodo `mount()`.

## Pattern Standard

### Struttura Base

```php
<?php

use Livewire\Volt\Component;
use Modules\Meetup\Models\Event;
use Illuminate\Support\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

new class extends Component {
    // Proprietà di input (da props o route)
    public ?Event $event = null;
    public ?Event $item = null;
    public string $container0 = '';
    public string $slug0 = '';
    
    // Flat properties popolate in mount()
    public string $title = 'Event Title';
    public string $slug = '';
    public string $status = 'upcoming';
    public string $statusLabel = 'Upcoming';
    public ?string $description = null;
    public string $date = '';
    public string $time = '';
    public string $location = 'Location TBA';
    public int $attendeesCurrent = 0;
    public int $attendeesMax = 100;
    public ?string $coverImage = null;
    public int $availableSpots = 100;
    public string $eventsUrl = '';
    public string $badgeClass = 'bg-green-600';

    public function mount(): void
    {
        $eventModel = $this->event ?? $this->item;
        
        if ($eventModel === null && !empty($this->slug0)) {
            $eventModel = Event::where('slug', $this->slug0)->first();
        }

        if ($eventModel instanceof Event) {
            $startDate = $eventModel->start_date ?? Carbon::now();
            $endDate = $eventModel->end_date ?? $startDate;
            
            $this->title = $eventModel->title;
            $this->slug = $eventModel->slug;
            $this->description = $eventModel->description;
            $this->date = $startDate->format('l, F j, Y');
            $this->time = $startDate->format('g:i A') . ' - ' . $endDate->format('g:i A');
            $this->location = $eventModel->location ?? 'Location TBA';
            $this->attendeesCurrent = $eventModel->attendees_count ?? 0;
            $this->attendeesMax = $eventModel->max_attendees ?? 100;
            $this->coverImage = $eventModel->cover_image;
            $this->availableSpots = ($eventModel->max_attendees ?? 100) - ($eventModel->attendees_count ?? 0);
            
            $this->status = $startDate->isFuture() ? 'upcoming' : 'past';
            $this->statusLabel = $this->status === 'upcoming' ? 'Upcoming' : 'Past Event';
            $this->badgeClass = $this->status === 'upcoming' ? 'bg-green-600' : 'bg-slate-500';
        }

        $this->eventsUrl = LaravelLocalization::localizeUrl('/events');
    }
};
?>
```

## Vantaggi del Pattern Flat Properties

### 1. **Chiarezza e Trasparenza**
- Tutte le proprietà sono esplicitamente dichiarate
- Nessuna logica nascosta in computed properties
- Facile debug e tracing

### 2. **Performance**
- I dati sono calcolati una sola volta in `mount()`
- Nessuna ricalcolo su ogni render
- Ottimale per componenti di sola lettura

### 3. **Testabilità**
- Facile mock delle proprietà pubbliche
- Nessuna dipendenza da logica interna
- Test di unità diretti

### 4. **Type Safety**
- Ogni proprietà ha un tipo esplicito
- PHPStan può verificare tutti gli accessi
- Riduce errori runtime

## Confronto: Flat Properties vs Computed Properties

### ❌ Anti-pattern: Computed Properties per dati statici
```php
public function eventData(): array {
    $event = $this->event;
    return [
        'title' => $event->title,
        'date' => $event->start_date->format(...),
        // ...
    ];
}
```
**Problemi:**
- Ricalcolo ad ogni render
- Non type-safe
- Difficile da debuggare

### ✅ Pattern: Flat Properties
```php
public string $title;
public string $date;

public function mount(): void {
    $this->title = $event->title;
    $this->date = $event->start_date->format(...);
}
```
**Vantaggi:**
- Calcolo una tantum
- Type-safe
- Debug immediato

## Quando Usare Computed Properties

Le computed properties sono appropriate SOLO per:
1. **Dati derivati che cambiano frequentemente** (es. contatori live)
2. **Filtraggio dinamico** basato su input utente
3. **Calcoli complessi** che dipendono da stato reattivo

## Best Practices

### 1. Valori di Default
Sempre fornire valori di default significativi:
```php
public string $title = 'Event Title';  // Placeholder user-friendly
public int $attendeesMax = 100;        // Default ragionevole
```

### 2. Nullable per Dati Opzionali
```php
public ?string $description = null;  // Può essere null
public ?string $coverImage = null;  // Immagine opzionale
```

### 3. Formattazione in mount()
Tutta la logica di formattazione nel mount:
```php
$this->date = $startDate->format('l, F j, Y');
$this->time = $startDate->format('g:i A') . ' - ' . $endDate->format('g:i A');
```

### 4. Localizzazione URL
```php
$this->eventsUrl = LaravelLocalization::localizeUrl('/events');
```

## CMS Integration

Per montare il componente Volt via CMS:

### 1. page-content.blade.php
```blade
@if(isset($block->livewire) && $block->livewire)
    @livewire($block->view, array_merge($block->data, $this->data))
@else
    @include($block->view, array_merge($block->data, $this->data))
@endif
```

### 2. events_view.json
```json
{
    "view": "pub_theme::components.blocks.events.detail",
    "livewire": true,
    "data": {
        "container0": "events",
        "slug0": "{{slug}}"
    }
}
```

## Collegamenti

- [Helper Class Pattern](./helper-class-pattern.md) - Per componenti non-Volt
- [Agnostic Routing](./agnostic-routing.md) - Pattern routing Folio
- [Filament Widgets](../filament-widgets.md) - Per interattività avanzata

---

## File di Riferimento

- `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php` - Esempio completo
- `Modules/Cms/resources/views/components/page-content.blade.php` - Integrazione CMS
- `config/local/laravelpizza/database/content/pages/events_view.json` - Configurazione pagina
