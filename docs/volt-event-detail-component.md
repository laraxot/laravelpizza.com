# Volt Component per Block CMS - Pattern Corretto

## ⚠️ REGOLA CRITICA: Volt Inline nei Block CMS

**Il frontend CMS-driven usa componenti Volt inline, NON classi PHP separate!**

## Struttura File

```
Themes/Meetup/resources/views/livewire/blocks/events/
└── detail.blade.php    # ✅ Componente Volt inline
```

## Pattern Corretto: Volt Inline

Il file DEVE iniziare con `<?php` - NULLUNO output (neanche commenti) prima!

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Models\Event;

new class extends Component {
    // Proprietà pubbliche per i parametri dalla route/CMS
    public ?string $container0 = null;
    public ?string $slug0 = null;
    public $event = null;
    public $item = null;
    public $eventModel = null;

    // Mount - inizializzazione
    public function mount(): void
    {
        $model = $this->event ?? $this->item;
        if ($model === null && $this->slug0 !== null) {
            $model = Event::where('slug', $this->slug0)->first();
        }
        $this->eventModel = $model;
    }

    // Computed properties
    #[Computed]
    public function eventData(): array { ... }
    
    #[Computed]
    public function eventsUrl(): string { ... }
    
    #[Computed]
    public function badgeClass(): string { ... }
}; ?>

{{-- Blade template - inizia DOPO la classe PHP --}}
<div>
    {{ $this->eventData['title'] }}
</div>
```

## ❌ SBAGLIATO

```blade
{{-- Commento PRIMA del PHP - SBAGLIATO! --}}
<?php
// Questo causa errore "strict_types must be first"
```

## Attivazione dal JSON

Nel JSON della pagina CMS:

```json
{
    "type": "events",
    "data": {
        "livewire": "blocks.events.detail",
        "slug0": "laravel-pizza-night"
    }
}
```

## Differenza Admin vs Frontend

| Contesto | Tipo Componente | Esempio |
|----------|----------------|---------|
| **Frontend CMS** | Volt inline in `livewire/` | `blocks.events.detail` |
| **Admin Panel** | Filament Widget | `Modules/Meetup/app/Filament/Widgets/` |

## Utilizzo

```blade
@livewire('blocks.events.detail', ['slug0' => $slug0])
```

## Riferimenti

- [Pattern container0/slug0](./container0-slug0-agnostic-pattern.md)
- [Laravel Folio](https://laravel.com/docs/12.x/folio)
- [Livewire Volt](https://livewire.laravel.com/docs/4.x/volt)
