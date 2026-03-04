# Routing File: NO Business Logic - Critical Rule

## 🚨 REGOLA CRITICA: Nessuna Logica di Business nel Routing

Il file `[container0]/[slug0]/index.blade.php` **NON DEVE MAI** contenere logica di business, query al database, o decisioni su quale componente renderizzare.

## ❌ SBAGLIATO: Logica nel Routing

**NON fare MAI questo:**

```php
<?php
// ❌ VIETATO ASSOLUTAMENTE
use Modules\Cms\Models\Page as PageModel;
use Modules\Meetup\Models\Event;

new class extends Component {
    public function mount(): void
    {
        // ❌ VIETATO: Query al database nel routing
        $page = PageModel::firstWhere('slug', $fullSlug);
        
        // ❌ VIETATO: Caricare modelli nel routing
        $item = Event::where('slug', $this->slug0)->first();
        
        // ❌ VIETATO: Decidere quale componente renderizzare
        if ($item !== null) {
            $this->renderMode = 'model';
        }
    }
    
    // ❌ VIETATO: Metodi di business logic
    private function resolveContent(): void { ... }
    private function loadDynamicModel(): ?object { ... }
};
?>
```

**Perché è SBAGLIATO:**

1. **Violazione Agnosticismo**: Il routing diventa dipendente da modelli specifici
2. **Violazione DRY**: Logica duplicata per ogni tipo di contenuto
3. **Rigidità**: Ogni nuovo contenuto richiede modifiche al routing
4. **Accoppiamento**: Routing legato a logica di business
5. **Manutenzione**: Modifiche devono essere replicate in più punti
6. **Testabilità**: Difficile testare routing con logica complessa
7. **Separazione Responsabilità**: Il routing deve solo passare parametri, non decidere cosa fare

## ✅ CORRETTO: Routing Agnostic Dispatcher

**Implementazione corretta:**

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

## 📜 Responsabilità del Routing

**Il routing DEVE SOLO:**

1. ✅ Dichiarare proprietà pubbliche per i parametri della route
2. ✅ Popolare `$data` in `mount()` con `view_slug = 'container.view'`
3. ✅ Passare i parametri al componente resolver
4. ✅ NON contenere alcuna logica di business

**Il routing NON DEVE MAI:**

1. ❌ Importare modelli specifici (`Event`, `Article`, ecc.)
2. ❌ Fare query al database (`PageModel::firstWhere()`, `Event::where()`, ecc.)
3. ❌ Decidere quale componente renderizzare (`if ($item) { ... }`)
4. ❌ Contenere metodi di business logic (`resolveContent()`, `loadDynamicModel()`, ecc.)
5. ❌ Contenere mapping container→modello (`$knownMappings`, `$modelMap`, ecc.)
6. ❌ Gestire fallback o priorità di risoluzione

## 🎯 Chi Gestisce la Logica?

### 1. Content Resolver (`content-resolver.blade.php`)

Il componente `content-resolver` è l'UNICO posto dove va la logica:

```php
// components/blocks/content-resolver.blade.php
@props(['container0' => '', 'slug0' => ''])

@php
// ✅ QUI va la logica di risoluzione
if ($container0 === 'events' && !empty($slug0)) {
    $event = Event::where('slug', $slug0)->first();
    if ($event) {
        echo view('pub_theme::components.blocks.events.detail', ['event' => $event])->render();
        return;
    }
}
// Fallback al CMS...
@endphp

<x-page :slug="$container0" />
```

### 2. Sistema CMS (`<x-page>` Component)

Il componente `<x-page>` cerca il JSON corrispondente allo slug e carica i content blocks.

**Flusso:**
```
<x-page slug="events.laravel-beginners-pizza-night" />
  ↓
Page::firstWhere('slug', 'events.laravel-beginners-pizza-night')
  ↓
JSON: events.laravel-beginners-pizza-night.json
  ↓
Content Blocks definiscono quale componente renderizzare
```

### 2. Componenti Block (`events/detail.blade.php`)

I componenti block possono caricare modelli quando necessario usando `$slug0`:

```blade
@php
// ✅ CORRETTO: Logica nel componente, non nel routing
if ($eventModel === null && !empty($slug0)) {
    $eventModel = Event::where('slug', $slug0)->first();
}
@endphp
```

### 3. JSON Content Blocks

Il JSON definisce quale componente renderizzare e quali dati passare:

```json
{
    "slug": "events.laravel-beginners-pizza-night",
    "content_blocks": {
        "it": [
            {
                "type": "events",
                "data": {
                    "view": "pub_theme::components.blocks.events.detail"
                }
            }
        ]
    }
}
```

## 🔄 Flusso Corretto

```
1. URL: /it/events/laravel-beginners-pizza-night
   ↓
2. Folio Route: [container0]/[slug0]/index.blade.php
   ↓
3. Routing (AGNOSTIC):
   - Estrae: container0='events', slug0='laravel-beginners-pizza-night'
   - Costruisce: fullSlug='events.laravel-beginners-pizza-night'
   - Passa a: <x-page slug="events.laravel-beginners-pizza-night" />
   ↓
4. CMS Component (<x-page>):
   - Cerca JSON: events.laravel-beginners-pizza-night.json
   - Se non trovato, cerca: events.view.json (fallback gestito dal CMS)
   - Carica content blocks dal JSON
   ↓
5. Block Component (events/detail.blade.php):
   - Riceve $slug0 tramite $data
   - Carica modello: Event::where('slug', $slug0)->first()
   - Renderizza con dati evento
```

## ✅ Vantaggi del Pattern Corretto

1. **Agnostic**: Funziona con qualsiasi tipo di contenuto senza modifiche
2. **CMS-Driven**: Il JSON definisce tutto, non il routing
3. **DRY**: Un solo file routing per tutti i contenuti nested
4. **Scalabile**: Nuovi contenuti senza modifiche al routing
5. **Testabile**: Routing semplice da testare
6. **Manutenibile**: Logica centralizzata nel CMS e nei componenti
7. **Separazione Responsabilità**: Ogni layer ha una responsabilità chiara

## 🚫 Eccezioni (Solo quando necessario)

**Usare logica specifica SOLO se:**

1. **Model Binding Folio**: `pages/events/[.Modules.Meetup.Models.Event].blade.php`
   → Folio risolve automaticamente il modello (pattern nativo Folio)

2. **Logica completamente diversa**: `pages/auth/login.blade.php`
   → Logica autenticazione specifica (non è routing generico)

**Regola**: Logica specifica SOLO per ragioni tecniche forti (pattern nativo framework), NON per organizzazione o convenienza.

## 📝 Checklist Pre-Commit

Prima di commitare modifiche a `[container0]/[slug0]/index.blade.php`, verifica:

- [ ] ❌ NON ci sono `use` di modelli (`Event`, `Article`, ecc.)
- [ ] ❌ NON ci sono query al database (`PageModel::firstWhere()`, ecc.)
- [ ] ❌ NON ci sono metodi di business logic (`resolveContent()`, `loadDynamicModel()`, ecc.)
- [ ] ❌ NON ci sono `if` che decidono quale componente renderizzare
- [ ] ❌ NON ci sono `mount()` con `request()->route()` — Volt auto-inietta i parametri
- [ ] ✅ SOLO proprietà pubbliche per i parametri della route
- [ ] ✅ SOLO passaggio dati al componente resolver

## 🔗 Riferimenti

- [Container0 Slug0 Agnostic Pattern](container0-slug0-agnostic-pattern.md)
- [Container0 Pattern Philosophy](container0-pattern-philosophy.md)
- [Events Detail Slug0 Loading](events-detail-slug0-loading.md)
