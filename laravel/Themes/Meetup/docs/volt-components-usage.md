# Volt Components nel Tema Meetup

## Introduzione

Il tema Meetup utilizza Laravel Folio per il routing e Livewire Volt per i componenti interattivi. Questo documento descrive come utilizzare correttamente i componenti Volt nel contesto del CMS-driven pages.

## Pattern: Routing Agnostic con Volt

### Struttura File

```
Themes/Meetup/resources/views/pages/
├── [container0]/
│   ├── index.blade.php           # Lista container
│   └── [slug0]/
│       └── index.blade.php       # Dettaglio item (Volt)
└── ...
```

### Componente Volt nel Routing

```php
<?php
declare(strict_types=1);

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('container0.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    // ✅ PROPRIETÀ OBBLIGATORIE - Volt popola automaticamente dalla route
    public string $container0;
    public string $slug0;
    public array $data = [];
    public string $pageSlug = '';

    public function mount(): void
    {
        // Lo slug per il JSON è container0.view (es. events.view)
        $this->pageSlug = $this->container0 . '.view';
        
        // $data per passare variabili ai componenti inclusi
        $this->data = [
            'container0' => $this->container0,
            'slug0' => $this->slug0,
        ];
    }
};
?>

<x-layouts.app>
    @volt('container0.view')
    <div>
        <x-page side="content" :slug="$this->pageSlug" :data="$this->data" />
    </div>
    @endvolt
</x-layouts.app>
```

## Block Components con Volt

### Composizione

I block components possono essere:
1. **Statici**: Blade template semplici
2. **Interattivi**: Componenti Livewire/Volt

### Esempio: EventDetail Volt Component

**Location**: `Modules/Meetup/app/Livewire/EventDetail.php`

```php
<?php
declare(strict_types=1);

namespace Modules\Meetup\Livewire;

use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Volt\Component;
use Modules\Meetup\Models\Event;

class EventDetail extends Component
{
    public ?Event $event = null;
    public string $title = '';
    public string $status = 'upcoming';
    // ...

    public function mount(?string $slug = null, ?Event $event = null): void
    {
        // Inizializzazione
    }

    public function render(): View
    {
        return view('pub_theme::components.blocks.events.detail-volt')
            ->with([...]);
    }
}
```

## Vantaggi del Pattern

1. **Separazione Responsabilità**: Logica nel componente, rendering nel template
2. **Testabilità**: Componenti testabili separatamente
3. **Interattività**: Possibilità di aggiungere funzionalità dinamiche
4. **Type Safety**: PHPStan compatibility con proprietà tipizzate

## Riferimenti

- [Laravel Folio](https://laravel.com/docs/12.x/folio)
- [Livewire Volt](https://livewire.laravel.com/docs/4.x/volt)
- [Container0 Pattern](./container0-slug0-agnostic-pattern.md)
