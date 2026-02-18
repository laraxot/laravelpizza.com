# Folio Dynamic Routing with [container0]

## Philosophy

Using `[container0]` is a **dynamic, generic routing pattern** that follows the same philosophy as the CMS catch-all `[slug].blade.php`.

### Why [container0]?

1. **DRY (Don't Repeat Yourself)**: One blade file handles ALL sections, not just "events"
2. **Consistency**: Same pattern as root-level `[slug]` for CMS pages
3. **Flexibility**: Add new sections (blog, docs, etc.) without creating new directories
4. **Simplicity**: Single routing structure for all dynamic content

## The Pattern

```
pages/
├── [slug].blade.php              → /{slug} (CMS pages like /about, /contact)
├── [container0]/
│   ├── index.blade.php          → /{container0} (section list like /events)
│   └── [slug0]/
│       └── index.blade.php      → /{container0}/{slug0} (section detail like /events/laravel-pizza)
```

### How It Works

| URL | container0 | slug0 | File |
|-----|------------|-------|------|
| `/events` | `events` | - | `[container0]/index.blade.php` |
| `/events/laravel-pizza` | `events` | `laravel-pizza` | `[container0]/[slug0]/index.blade.php` |
| `/blog` | `blog` | - | `[container0]/index.blade.php` |
| `/blog/my-post` | `blog` | `my-post` | `[container0]/[slug0]/index.blade.php` |

## Implementation

### Principio: Pagina Folio AGNOSTICA

La pagina Folio **NON deve contenere logica di business**. Deve solo:
1. Estrarre i parametri dalla route
2. Passarli al componente resolver

### [container0]/index.blade.php

```php
<?php
declare(strict_types=1);

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('container0');
middleware(PageSlugMiddleware::class);

new class extends Component {
    // ✅ Volt auto-inietta i parametri della route!
    public string $container0 = '';
    public string $slug0 = '';
    public array $data = [];
};
?>

<x-layouts.app>
    @volt('container0')
    <div>
        {{-- SOLO passaggio parametri - NESSUNA logica! --}}
        <x-page side="content" :slug="$container0" />
    </div>
    @endvolt
</x-layouts.app>
```

### [container0]/[slug0]/index.blade.php

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

### Content Resolver (DOVE VA LA LOGICA)

```php
// components/blocks/content-resolver.blade.php
@props(['container0' => '', 'slug0' => ''])

@php
// Logica di risoluzione - QUI, non nella pagina Folio!
if ($container0 === 'events' && !empty($slug0)) {
    $event = \Modules\Meetup\Models\Event::where('slug', $slug0)->first();
    if ($event) {
        echo view('pub_theme::components.blocks.events.detail', ['event' => $event])->render();
        return;
    }
}
// Fallback CMS...
@endphp

<x-page :slug="$container0" />
```

## Key Concepts

### 1. Route Precedence

Folio matches routes by specificity:
1. Exact match → `index.blade.php`
2. Single param → `[container0]/index.blade.php` → `/{container0}`
3. Two params → `[container0]/[slug].blade.php` → `/{container0}/{slug}`

### 2. Conditional Logic

The blade can handle different sections differently:

```php
if ($this->container0 === 'events') {
    // Handle events
} elseif ($this->container0 === 'blog') {
    // Handle blog
}
```

### 3. Fallback to CMS

If no special handling exists, fallback to CMS-driven page:
```php
$fullSlug = $this->container0 . '.' . ($this->slug ?? '');
<x-page side="content" slug="$fullSlug" />
```

## Advantages Over Hardcoded Directories

| Hardcoded | Dynamic [container0] |
|-----------|---------------------|
| `pages/events/[slug].blade.php` | `[container0]/[slug].blade.php` |
| Separate file for each section | One file for all sections |
| Must create new directory for new section | Works automatically |
| Duplicated routing logic | Single routing pattern |

## Current Routes

```
GET /it/{container0}        → [container0]/index.blade.php
GET /it/{container0}/{slug} → [container0]/[slug].blade.php
```

This replaces the old structure:
- `pages/events/index.blade.php` → `/events`
- `pages/events/[slug].blade.php` → `/events/{slug}`
