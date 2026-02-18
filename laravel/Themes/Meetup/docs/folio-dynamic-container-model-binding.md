# Folio Container Routing - Pattern Agnostic

## Principio Fondamentale: Separazione Router/Resolver

**La pagina Folio DEVE essere completamente agnostica** - non deve contenere alcuna logica di business, loading di modelli, o risoluzione di contenuti.

```
[container0]/[slug0]/index.blade.php  → SOLO router (passa parametri)
content-resolver.blade.php            → LOGICA di risoluzione
```

### Perché questa separazione?

1. **Separazione responsabilità (SRP)**: Folio page = routing, Resolver = business logic
2. **Testabilità**: Il resolver può essere testato separatamente
3. **Manutenzione**: Cambiare logica non tocca le route
4. **DRY**: Un resolver per tutte le pagine container
5. **Estensibilità**: Aggiungere nuovi container senza toccare le route

## Struttura Corretta

### File: `[container0]/[slug0]/index.blade.php` (AGNOSTICO)

```php
<?php
declare(strict_types=1);

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('container0.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    // ✅ INDISPENSABILE - Necessario per passare le variabili a Volt!
    public string $container0;
    public string $slug0;
    public array $data = [];
    public string $pageSlug = '';

    public function mount(): void
    {
        // ✅ CORRETTO: Lo slug per il JSON del dettaglio è 'container.view'
        // es: events.view → events.view.json
        $this->pageSlug = $this->container0 . '.view';
        
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
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

**Nota**: Lo slug del JSON è `{container}.view` (es. `events.view.json`), non `{container}.{slug}`. Il resolver usa lo slug per caricare il template e poi cerca il modello usando `$slug0`.

### File: `components/blocks/content-resolver.blade.php` (LOGICA)

```php
<?php

declare(strict_types=1);

use Modules\Meetup\Models\Event;

?>

@props([
    'container0' => '',
    'slug0' => '',
])

@php
$content = null;
$contentType = null;
$view = null;

// Logica di risoluzione - QUI VA TUTTA LA LOGICA
if ($container0 === 'events' && !empty($slug0)) {
    $content = Event::where('slug', $slug0)->first();
    $contentType = 'event';
    $view = 'blocks.events.detail';
} elseif ($container0 === 'blog' && !empty($slug0)) {
    $contentType = 'blog';
    $view = 'blocks.blog.detail';
}
// Aggiungi altri container qui...
@endphp

@if($content && $view)
    @include($view, ['item' => $content, 'container0' => $container0, 'slug0' => $slug0])
@else
    <x-page side="content" :slug="$container0" :container0="$container0" :slug0="$slug0" />
@endif
```

## ❌ Anti-Pattern: Logica nella Pagina Folio

**SBAGLIATO - Mai fare questo:**

```php
// [container0]/[slug0]/index.blade.php - MAI!
new class extends Component {
    public function mount(): void {
        // MAI caricare modelli qui!
        $this->event = Event::where('slug', $slug0)->first();
    }
    
    private function resolveContent(): void {
        // MAI avere metodi di risoluzione!
    }
    
    private function loadDynamicModel(): ?object {
        // MAI caricare modelli dinamicamente!
    }
};
```

**Problemi:**
- ❌ Viola SRP (Single Responsibility Principle)
- ❌ Difficile da testare
- ❌ Logica mixed con routing
- ❌ Non estensibile

### Componente: `Themes/Meetup/resources/views/components/blocks/content-resolver.blade.php`

```php
<?php

declare(strict_types=1);

use Modules\Meetup\Models\Event;

?>

@props([
    'container0' => '',
    'slug0' => '',
])

@php
$content = null;
$contentType = null;
$view = null;

// Content resolution logic based on container type
if ($container0 === 'events' && !empty($slug0)) {
    $content = Event::where('slug', $slug0)->first();
    $contentType = 'event';
    $view = 'blocks.events.detail';
} elseif ($container0 === 'blog' && !empty($slug0)) {
    // Future: Blog post resolution
    $contentType = 'blog';
    $view = 'blocks.blog.detail';
} elseif ($container0 === 'pages' && !empty($slug0)) {
    // Future: Custom page resolution
    $contentType = 'page';
    $view = 'blocks.page.detail';
}
@endphp

@if($content && $view)
    @include($view, ['event' => $content, 'container0' => $container0, 'slug0' => $slug0])
@else
    {{-- Fallback to CMS page rendering --}}
    <x-page side="content" :slug="$container0" :container0="$container0" :slug0="$slug0" />
@endif
```

## Vantaggi dell'Approccio Agnastico

1. **Separazione delle responsabilità**: La pagina Folio non conosce i modelli
2. **Estensibilità**: Aggiungere nuovi container è facile
3. **Manutenibilità**: Logica centralizzata nel resolver
4. **Testabilità**: Il resolver può essere testato separatamente

## Route Folio Attive

```bash
php artisan folio:list | grep container0
```

Output:
```
GET  /it/{container0}           → [container0]/index.blade.php
GET  /it/{container0}/{slug0}   → [container0]/[slug0]/index.blade.php
```

## Route Folio NON Valide

I seguenti file sono **NON validi** per Folio:

- `[container0]/[container1]/index.blade.php` - NON valido (due parametri diversi)
- `[container0]/[container1]/[container2]/index.blade.php` - NON valido

Folio supporta solo:
- `[param].blade.php` - Un parametro
- `[param0]/index.blade.php` - Un parametro con index
- `[...params].blade.php` - Parametri multipli (catch-all)

**Nota**: Quando si usano due parametri nella stessa cartella, devono avere lo **stesso nome**:
- ✅ `[container0]/[slug0]/index.blade.php` - Entrambi `slug0` (stesso nome!)
- ❌ `[container0]/[slug]/index.blade.php` - Nomi diversi - NON FUNZIONA!

## Route CMS Backup

Se il content-resolver non trova un modello, Fallsback al rendering CMS standard:
- `/it/events` → cerca pagina CMS con slug `events`
- `/it/events/laravel-beginners-pizza-night` → prima cerca Event, poi CMS `events`

## Estendere per Altri Container

Per aggiungere supporto per altri container (es. blog, news), modifica solo `content-resolver.blade.php`:

```php
if ($container0 === 'events' && !empty($slug0)) {
    $content = Event::where('slug', $slug0)->first();
    $contentType = 'event';
    $view = 'blocks.events.detail';
} elseif ($container0 === 'blog' && !empty($slug0)) {
    $content = BlogPost::where('slug', $slug0)->first();
    $contentType = 'blog';
    $view = 'blocks.blog.detail';
}
// Aggiungi altri container qui...
```
