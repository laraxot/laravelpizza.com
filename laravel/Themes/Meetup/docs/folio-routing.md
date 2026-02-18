# Laravel Folio - Page Based Routing

## Overview

Laravel Folio is a page-based router for Laravel that simplifies routing by using Blade templates in the `resources/views/pages` directory.

## Basic Concepts

### Route Parameters

Folio uses square brackets in filenames to capture URL segments:

```
pages/users/[id].blade.php      → /users/1, /users/123
pages/events/[slug].blade.php  → /events/laravel-11-release-pizza-party
```

### Nested Routes

```
pages/events/index.blade.php    → /events (index of events)
pages/events/[slug].blade.php  → /events/{slug}
```

### Model Binding

Folio automatically resolves Eloquent models using two syntaxes:

**Simple (model in App\Models):**
```
pages/users/[User].blade.php       → /users/1 (resolves User model by id)
pages/events/[Event:slug].blade.php → /events/laravel-11 (resolves by slug)
```

**FQCN (model in module namespace — dots replace backslashes):**
```
pages/events/[.Modules.Meetup.Models.Event].blade.php → /events/{slug}
```
Folio converts dots to backslashes: `.Modules.Meetup.Models.Event` → `Modules\Meetup\Models\Event`.
The model's `getRouteKeyName()` determines which column is used for binding.

## Common Issues

### 1. Pattern [container0] - Filosofia Architetturale

**Approccio Corretto:** Il pattern `[container0]` è la **filosofia architetturale** di LaravelPizza per contenuti CMS-driven nested.

**Struttura:**
```
pages/
├── [slug].blade.php              → /{slug} (CMS catch-all)
└── [container0]/
    ├── index.blade.php           → /{container} (CMS: events.json)
    └── [slug0]/index.blade.php  → /{container}/{slug} (CMS: events.view)
```

**Vantaggi:**
- ✅ DRY: Un solo file gestisce tutti i contenuti nested
- ✅ Scalabilità: Nuovi contenuti senza modificare struttura file
- ✅ CMS-Driven: Contenuti in JSON, non nella struttura directory
- ✅ Agnostic: Nessuna logica di business nel file routing

**⚠️ CRITICAL: Volt Properties Injection**
Il file `[container0]/[slug0]/index.blade.php` deve usare proprietà pubbliche per ricevere i parametri:

```php
// ✅ CORRETTO - Volt inietta automaticamente i parametri!
name('container0.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public string $container0 = '';  // Volt popola dalla route!
    public string $slug0 = '';        // Volt popola dalla route!
    public array $data = [];         // Per passare dati
    public string $pageSlug = '';    // Per il JSON lookup

    public function mount(): void
    {
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
        <x-page side="content" :slug="$this->pageSlug" :data="$this->data" />
    </div>
    @endvolt
</x-layouts.app>
```

**⚠️ ANTI-PATTERN: MAI usare request()->route()**
```php
// ❌ SBAGLIATO
public function mount(): void
{
    $this->container0 = request()->route('container0') ?? '';  // NO!
}
```

**Importante:** Rimuovere `[container0]/[container1]/index.blade.php` se esiste (file di test) per dare precedenza a `[container0]/[slug].blade.php`.

Vedi: [Container0 Pattern Philosophy](container0-pattern-philosophy.md)

### 2. CMS Catch-All vs Event Detail

**Problem:** `/events` might not work because `[slug].blade.php` handles it as a CMS page.

**Solution:** In LaravelPizza, `/it/events` is a CMS-driven page loaded from `events.json`. The events list page does NOT have a separate `events/index.blade.php`. Only the event detail uses Folio model binding: `events/[.Modules.Meetup.Models.Event].blade.php`.

### 3. Route Order

Folio matches routes in this order:
1. Exact matches (index.blade.php)
2. Static routes (about.blade.php)
3. Nested routes (users/profile.blade.php)
4. Parameter routes ([slug].blade.php)

**Important:** Nested directory parameters (`[container0]/index.blade.php`) take priority over single-parameter catch-alls (`[slug].blade.php`).

**Critical:** When both `[container0]/[container1]/index.blade.php` and `[container0]/[slug].blade.php` match the same URL, Folio prefers `index.blade.php` because it's considered more specific. See [Folio Container Routing Priority](folio-container-routing-priority.md) for details and solutions.

## File Structure (LaravelPizza)

### Pattern [container0] Generico (Consigliato)

```
Themes/Meetup/resources/views/pages/
├── index.blade.php                    → / (home)
├── [slug].blade.php                   → /{slug} (CMS: home.json, about.json)
└── [container0]/
    ├── index.blade.php                → /{container} (CMS: events.json, articles.json)
    └── [slug].blade.php               → /{container}/{slug} (CMS: events.{slug}.json)
```

**Filosofia**: Pattern generico DRY + CMS-driven. Vedi [Container0 Pattern Philosophy](container0-pattern-philosophy.md)

**Convenzione JSON**: 
- `events.json` → `/it/events` (lista)
- `events.laravel-beginners-pizza-night.json` → `/it/events/laravel-beginners-pizza-night` (dettaglio)

### Pattern Directory Specifica (Solo Eccezioni)

```
pages/events/[.Modules.Meetup.Models.Event].blade.php → /events/{slug} (model binding)
```

**Usare SOLO** quando serve model binding Folio diretto o logica completamente specifica.

## Key Files in Meetup Theme

- `Themes/Meetup/resources/views/pages/[slug].blade.php` - CMS catch-all (loads pages from JSON)
- `Themes/Meetup/resources/views/pages/events/[.Modules.Meetup.Models.Event].blade.php` - Event detail (Folio model binding by slug)

## Commands

```bash
# List all Folio routes
php artisan folio:list

# Create a new page
php artisan folio:page path/to/page

# Install Folio
php artisan folio:install
```

## Best Practices

1. For CMS pages, use JSON in `config/local/laravelpizza/database/content/pages/` — do NOT create separate Blade files
2. Use FQCN model binding (`[.Modules.Meetup.Models.Event]`) when models are in module namespaces
3. Keep `getRouteKeyName()` returning `'slug'` for SEO-friendly URLs
4. Always use `LaravelLocalization::localizeUrl()` for links in templates
5. Test routes with `php artisan folio:list`
6. After removing/adding Folio pages, always clear view cache: `php artisan view:clear`
