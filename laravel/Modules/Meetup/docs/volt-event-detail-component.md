# Volt Component per Event Detail

## Panoramica

Questo documento descrive come implementare componenti Livewire/Volt per la visualizzazione di contenuti CMS-driven nel tema Meetup.

## Pattern Volt + Folio

### Struttura del Componente Volt

I componenti Volt per i block CMS si trovano in:
```
Modules/Meetup/app/Livewire/
├── EventDetail.php              # Componente per il detail dell'evento
└── ...
```

### Esempio: EventDetail.php

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Livewire;

use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Volt\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Models\Event;

class EventDetail extends Component
{
    public ?Event $event = null;

    public string $title = '';
    public string $slug = '';
    public string $status = 'upcoming';
    // ... altre proprietà

    public function mount(?string $slug = null, ?Event $event = null): void
    {
        // Logica di inizializzazione
    }

    public function render(): View
    {
        return view('pub_theme::components.blocks.events.detail-volt')
            ->with([...]);
    }
}
```

### Caratteristiche del Pattern

1. **Proprietà Pubbliche**: Dichiarate con type hint per PHPStan
2. **Metodo mount()**: Per inizializzazione dei dati
3. **Metodo render()**: Restituisce la view con i dati
4. **Supporto per Model Binding**: Accetta sia il modello che lo slug

### Utilizzo nel Template Blade

```blade
<x-meetup::event-detail :slug="$slug0" />
```

oppure

```blade
@livewire(\Modules\Meetup\Livewire\EventDetail::class, ['slug' => $slug0])
```

## Differenza tra Block Statico e Volt

| Aspetto | Block Statico | Componente Volt |
|---------|---------------|-----------------|
| Interattività | Nessuna | Possibile |
| Data Fetching | Nel template | Nel componente |
| State Management | Nessuno | Gestito da Livewire |
| SEO | Server-side | Server-side |

## Best Practices

1. **Usare proprietà tipizzate**: `public string $title = ''`
2. **Mount con default**: `mount(?string $slug = null, ?Event $event = null)`
3. **View dedicata**: Template in `components/blocks/{type}-volt.blade.php`
4. **Separazione logica**: Logica nel componente, rendering nel template

## Riferimenti

- [Laravel Folio](https://laravel.com/docs/12.x/folio)
- [Livewire Volt](https://livewire.laravel.com/docs/4.x/volt)
- [Documentazione Locale Folio](./folio-dynamic-routing.md)
