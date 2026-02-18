# Pattern [container0]/[slug0] - Agnostic CMS-Driven

## 🎯 Principio Fondamentale: Complete Agnosticism

Il file `[container0]/[slug0]/index.blade.php` deve essere **completamente agnostico** e **CMS-driven**. Non deve contenere logica specifica per alcun tipo di contenuto (Event, Article, Product, ecc.).

## ❌ Anti-Pattern: Logica Specifica nel Routing

**NON fare mai questo:**

```php
// ❌ VIETATO - Logica specifica per Event
use Modules\Meetup\Models\Event;

if ($container0 === 'events' && !empty($slug0)) {
    $event = Event::where('slug', $slug0)->first();
    if ($event) {
        return view('pub_theme::components.blocks.events.detail', ['event' => $event]);
    }
}
```

**Problemi:**
- ❌ Violazione DRY: Logica duplicata per ogni tipo di contenuto
- ❌ Rigidità: Ogni nuovo contenuto richiede modifiche al routing
- ❌ Accoppiamento: Routing legato a modelli specifici
- ❌ Manutenzione: Modifiche devono essere replicate

## ✅ Pattern Corretto: Agnostic CMS-Driven

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
    // ✅ INDISPENSABILE: Proprietà pubbliche per injection dei parametri route!
    // Volt popola automaticamente queste proprietà dai parametri Folio [container0] e [slug0]
    public string $container0 = '';
    public string $slug0 = '';
    public array $data = [];
    
    public string $pageSlug = '';

    public function mount(): void
    {
        // ✅ Volt ha già popolato $this->container0 e $this->slug0 automaticamente
        // Lo slug per il JSON è container0.view (es. events.view)
        // Questo permette di caricare il JSON template per il dettaglio del container
        $this->pageSlug = $this->container0 . '.view';
        
        // Popolare $this->data per passare variabili ai componenti inclusi
        // page-content.blade.php fa: array_merge($block->data, $this->data)
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

### Perché le proprietà pubbliche sono INDISPENSABILI

In Volt + Folio:

1. **Route Parameter Injection**: Folio passa i parametri della route (`[container0]`, `[slug0]`) automaticamente
2. **Volt Property Binding**: Volt popola automaticamente le proprietà pubbliche con i valori dei parametri di route
3. **Senza proprietà pubbliche**: Se non dichiari `public string $container0`, `$slug0`, Volt non può iniettare i valori

Esempio:
- URL: `/it/events/laravel-pizza-night`
- Folio estrae: `container0 = 'events'`, `slug0 = 'laravel-pizza-night'`
- Volt inietta: `$this->container0`, `$this->slug0` automaticamente

**Vantaggi:**
- ✅ **Agnostic**: Funziona con qualsiasi tipo di contenuto
- ✅ **CMS-Driven**: Il JSON definisce quale componente renderizzare
- ✅ **DRY**: Un solo file per tutti i contenuti nested
- ✅ **Semplice**: Nessuna logica nel routing

## 📜 Filosofia: Separazione Responsabilità

### Responsabilità del Routing (`[container0]/[slug0]/index.blade.php`)

**SOLO:**
1. Estrarre parametri dalla route (`container0`, `slug0`) tramite proprietà pubbliche nel Component Volt
2. Costruire lo slug del template (`{container0}.view`) - ES. `events.view` per il detail
3. Passare tutto al componente `<x-page>`
4. Rendere disponibili le variabili ai componenti inclusi tramite `$data`

**NON:**
- ❌ Importare modelli specifici (Event, Article, ecc.)
- ❌ Fare query al database
- ❌ Decidere quale componente renderizzare
- ❌ Contenere logica di business

### Responsabilità del CMS (JSON + Content Blocks)

**Il JSON definisce:**
- Quale componente renderizzare (`view` nel content block)
- Quali dati passare al componente (`data` nel content block)
- Come strutturare il contenuto (`content_blocks`)

**Esempio JSON:**

```json
{
    "slug": "events.laravel-beginners-pizza-night",
    "content_blocks": {
        "it": [
            {
                "type": "events",
                "slug": "detail",
                "data": {
                    "view": "pub_theme::components.blocks.events.detail",
                    "event_slug": "laravel-beginners-pizza-night"
                }
            }
        ]
    }
}
```

## 🔄 Flusso Completo Agnostic

```
1. URL: /it/events/laravel-beginners-pizza-night
   ↓
2. Folio Route: [container0]/[slug0]/index.blade.php
   ↓
3. Estrazione Parametri: container0='events', slug0='laravel-beginners-pizza-night'
   ↓
4. Volt Component: $this->container0 = 'events', $this->slug0 = 'laravel-beginners-pizza-night'
   ↓
5. mount(): $this->pageSlug = $this->container0 . '.view' → 'events.view'
   ↓
6. Component: <x-page side="content" slug="events.view" :data="$this->data" />
   ↓
7. Model Lookup: Page::firstWhere('slug', 'events.view')
   ↓
8. JSON File: config/local/laravelpizza/database/content/pages/events_view.json (slug: events.view)
   ↓
9. Content Blocks: Il JSON definisce quale componente renderizzare (events.detail)
   ↓
10. Block Rendering: @include($block->view, array_merge($block->data, $data))
   ↓
11. Component Specifico: Il componente (es. events.detail) riceve container0, slug0 e carica i dati del model
```

**Il routing NON sa quale componente renderizzare - lo decide il JSON!**

## 🎨 Pattern JSON per Contenuti Nested

### Convenzione Naming

```
config/local/laravelpizza/database/content/pages/
├── events.json                                    → /it/events (lista)
├── events.laravel-beginners-pizza-night.json     → /it/events/laravel-beginners-pizza-night
├── articles.json                                  → /it/articles (lista)
└── articles.laravel-filament-guide.json          → /it/articles/laravel-filament-guide
```

**Pattern**: `{container0}_view.json` per il template di dettaglio (es. `events_view.json` con slug `events.view`)

### Struttura Content Block

```json
{
    "slug": "events.view",
    "content_blocks": {
        "it": [
            {
                "type": "events",
                "slug": "detail",
                "data": {
                    "view": "pub_theme::components.blocks.events.detail"
                }
            }
        ]
    }
}
```

**Il componente incluso riceve tramite `$data`:**
- `$container0` → 'events' (da `$this->data` passato da Volt)
- `$slug0` → 'laravel-beginners-pizza-night' (da `$this->data` passato da Volt)
- Il componente `events/detail.blade.php` carica il modello usando `$slug0`

## ✅ Best Practices

1. **Dichiarare SEMPRE le proprietà pubbliche** nel Component Volt (`container0`, `slug0`, `data`, `pageSlug`)
2. **Usare mount()** per costruire `$pageSlug = $container0 . '.view'`
3. **Usare `<x-page>`** direttamente, NON un content-resolver separato
4. **Passare variabili tramite `$data`** al Page component
5. **Lasciare che il JSON definisca** quale componente renderizzare
6. **Mai importare modelli** nel file routing
7. **Mai fare query** nel file routing

## 🚫 Eccezioni (Solo quando necessario)

**Usare logica specifica SOLO se:**
1. **Model Binding Folio**: `pages/events/[.Modules.Meetup.Models.Event].blade.php`
   → Folio risolve automaticamente il modello
2. **Logica completamente diversa**: `pages/auth/login.blade.php`
   → Logica autenticazione specifica

**Regola**: Logica specifica SOLO per ragioni tecniche forti, NON per organizzazione.

## 📝 Naming Route Folio

**Convenzione**: Usare `name('container0.view')` invece di `name('container0.slug0')`.

**Perché:**
- ✅ Semantico: indica che è una "vista" generica per container0
- ✅ Generico: funziona per qualsiasi container0+slug0
- ✅ Consistente: segue il pattern `pages.view`
- ✅ Agnostic: non dipende dai parametri specifici

Vedi: [Folio Route Naming Convention](folio-route-naming-convention.md)

## 🔗 Riferimenti

- [Container0 Use X-Page Not Content Resolver](container0-use-x-page-not-content-resolver.md)
- [Container0 Pattern Philosophy](container0-pattern-philosophy.md)
- [Folio Route Naming Convention](folio-route-naming-convention.md)
- [Folio Routing](folio-routing.md)
- [Routing No Business Logic](routing-no-business-logic.md)
- [CMS JSON Content System](../../Modules/Cms/docs/json-content-system-architecture.md)
