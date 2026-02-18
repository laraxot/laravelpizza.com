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
1. **Statici**: Blade template in `resources/views/components/blocks/` (inclusi con `@include`)
2. **Volt (stesso pattern di [container0]/[slug0]/index)**: file in `resources/views/livewire/`; il CMS li renderizza con `@livewire` quando nel blocco è presente `"livewire": "nome.componente"`

### Path montati da Volt

- **Pagine Folio**: `Themes/Meetup/resources/views/pages` (e moduli `.../resources/views/pages`) — vedi `FolioVoltServiceProvider`
- **Block Volt del tema**: `resources/views/livewire` (nome tipo `blocks.events.detail`) e `resources/views/components/blocks` (nome tipo `events.detail`) — montati nello stesso provider se le directory esistono.

Esempio: `components/blocks/events/detail.blade.php` → nome componente **`events.detail`**.

### Attivazione da JSON pagina

Nel JSON della pagina, nel `data` del blocco aggiungere la chiave `livewire`:

```json
"data": {
    "view": "pub_theme::components.blocks.events.detail",
    "livewire": "events.detail",
    "title": "Upcoming Events",
    ...
}
```

Se `livewire` è presente, `page-content.blade.php` (modulo Cms) usa `@livewire($name, $merged)` invece di `@include($block->view, ...)`. Stesso pattern di presentazione di `[container0]/[slug0]/index`: `mount()`, proprietà pubbliche, computed (`#[Computed]`).

### Esempio: Event Detail Volt (single-file)

**Location**: `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php` — nome componente **`events.detail`**

- Classe: `new class extends Component` con `mount()`, proprietà pubbliche, `#[Computed]` (stesso standard di `[container0]/[slug0]/index`)
- Proprietà: `container0`, `slug0`, `event`, `item`, `eventModel` (impostato in `mount()`)
- Computed: `eventData()`, `eventsUrl()`, `badgeClass()`
- Usato per **presentazione**; per form/azioni server-side si usano Filament Widgets (vedi [filament-widgets-not-livewire-critical-rule](filament-widgets-not-livewire-critical-rule.md))

## Vantaggi del Pattern

1. **Separazione Responsabilità**: Logica nel componente, rendering nel template
2. **Testabilità**: Componenti testabili separatamente
3. **Interattività**: Possibilità di aggiungere funzionalità dinamiche
4. **Type Safety**: PHPStan compatibility con proprietà tipizzate

## Riferimenti

- [Laravel Folio](https://laravel.com/docs/12.x/folio)
- [Livewire Volt](https://livewire.laravel.com/docs/4.x/volt)
- [Container0 Pattern](./container0-slug0-agnostic-pattern.md)
