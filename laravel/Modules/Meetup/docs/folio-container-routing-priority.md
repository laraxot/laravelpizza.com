# Folio Container Routing Priority: index.blade.php vs [slug].blade.php

## Problema

Per la URL `/it/events/laravel-beginners-pizza-night`, Folio usa `[container0]/[container1]/index.blade.php` invece di `[container0]/[slug].blade.php`.

## Causa Tecnica: La Pipeline di Folio

Il file `vendor/laravel/folio/src/Router.php` (linee 55-81) esegue un ciclo `for` su ogni segmento URL. Per ogni segmento, passa lo stato attraverso una **Pipeline** con quest'ordine **fisso e non modificabile**:

```
Step 1: MatchRootIndex                               → /
Step 2: MatchDirectoryIndexViews                      → dir/index.blade.php (dir letterale)
Step 3: MatchWildcardViewsThatCaptureMultipleSegments → [...param].blade.php
Step 4: MatchLiteralDirectories                       → events/ (cartella statica, ContinueIterating)
Step 5: MatchWildcardDirectories                      → [param]/ (cartella parametrica)
Step 6: MatchLiteralViews                             → about.blade.php (file letterale)
Step 7: MatchWildcardViews                            → [slug].blade.php (file parametrico)
```

**Il primo step che trova un match restituisce `MatchedView` e la pipeline si ferma.** Gli step successivi non vengono mai eseguiti.

### Il Codice Sorgente Chiave

**Router.php** — Il ciclo principale:
```php
for ($i = 0; $i < $state->uriSegmentCount(); $i++) {
    $value = (new Pipeline)
        ->send($state->forIteration($i))
        ->through([
            new MatchRootIndex,                              // Step 1
            new MatchDirectoryIndexViews,                    // Step 2
            new MatchWildcardViewsThatCaptureMultipleSegments, // Step 3
            new MatchLiteralDirectories,                     // Step 4
            new MatchWildcardDirectories,                    // Step 5
            new MatchLiteralViews,                           // Step 6
            new MatchWildcardViews,                          // Step 7
        ])->then(fn () => new StopIterating);

    if ($value instanceof MatchedView) return $value;       // STOP!
    elseif ($value instanceof ContinueIterating) continue;  // Prossimo segmento
    elseif ($value instanceof StopIterating) break;         // Nessun match
}
```

**MatchWildcardDirectories.php** — Il colpevole:
```php
public function __invoke(State $state, Closure $next): mixed
{
    if ($directory = $this->findWildcardDirectory($state->currentDirectory())) {
        $currentState = $state->withData(/* ... */)->replaceCurrentUriSegmentWith(/* ... */);

        if (! $currentState->onLastUriSegment()) {
            return new ContinueIterating($currentState);  // Non ultimo segmento → avanti
        }

        // Ultimo segmento + index.blade.php esiste → MATCH IMMEDIATO
        if (file_exists($path = $currentState->currentUriSegmentDirectory().'/index.blade.php')) {
            return new MatchedView($path, $currentState->data);
        }
    }
    return $next($state);  // Nessun match → passa a Step 6, 7
}
```

**MatchWildcardViews.php** — Mai raggiunto:
```php
public function __invoke(State $state, Closure $next): mixed
{
    if ($state->onLastUriSegment() &&
        $path = $this->findWildcardView($state->currentDirectory())) {
        return new MatchedView(/* ... */);  // Troverebbe [slug].blade.php
    }
    return $next($state);
}
```

## Trace Completo per `/events/laravel-beginners-pizza-night`

Struttura sul disco:
```
pages/
├── [container0]/
│   ├── index.blade.php
│   ├── [slug].blade.php          ← QUESTO VORREMMO
│   └── [container1]/
│       └── index.blade.php       ← QUESTO VINCE
└── [slug].blade.php
```

### Iterazione 0 — Segmento `events` (indice 0 di 2)

`onLastUriSegment()` = FALSE (0 != 1)

| Step | Classe | Cosa fa | Risultato |
|------|--------|---------|-----------|
| 1 | MatchRootIndex | URI = `/`? NO | `$next()` |
| 2 | MatchDirectoryIndexViews | `onLastUriSegment()`? NO | `$next()` |
| 3 | MatchWildcardViews...Multi | `onLastUriSegment()`? NO | `$next()` |
| 4 | MatchLiteralDirectories | `is_dir('pages/events')`? NO (la cartella si chiama `[container0]`, non `events`) | `$next()` |
| **5** | **MatchWildcardDirectories** | Trova `[container0]/` → match! Non ultimo segmento → | **ContinueIterating** |

Stato aggiornato: `data = {container0: 'events'}`, segmenti = `['[container0]', 'laravel-beginners-pizza-night']`

### Iterazione 1 — Segmento `laravel-beginners-pizza-night` (indice 1 di 2)

`onLastUriSegment()` = TRUE (1 == 1). `currentDirectory()` = `pages/[container0]`

| Step | Classe | Cosa fa | Risultato |
|------|--------|---------|-----------|
| 1 | MatchRootIndex | URI = `/`? NO | `$next()` |
| 2 | MatchDirectoryIndexViews | `is_dir('pages/[container0]/laravel-beginners-pizza-night')`? NO (non esiste cartella con quel nome letterale) | `$next()` |
| 3 | MatchWildcardViews...Multi | Cerca `[...param].blade.php`? NON TROVATO | `$next()` |
| 4 | MatchLiteralDirectories | `is_dir('pages/[container0]/laravel-beginners-pizza-night')`? NO | `$next()` |
| **5** | **MatchWildcardDirectories** | `findWildcardDirectory('pages/[container0]/')` → trova `[container1]/`! `onLastUriSegment()`? SI → `file_exists('[container1]/index.blade.php')`? **SI** → | **MatchedView** |
| 6 | MatchLiteralViews | **MAI RAGGIUNTO** | — |
| **7** | **MatchWildcardViews** | **MAI RAGGIUNTO** (troverebbe `[slug].blade.php`) | — |

**Conclusione:** `MatchWildcardDirectories` (Step 5) trova `[container1]/index.blade.php` e restituisce il match. `MatchWildcardViews` (Step 7), che troverebbe `[slug].blade.php`, non viene mai eseguito.

## Regola Fondamentale

Per l'ultimo segmento di un URL, la priorita' effettiva e':

```
1. cartella letterale + index.blade.php     → MatchDirectoryIndexViews (Step 2)
2. cartella parametrica [x]/ + index.blade.php → MatchWildcardDirectories (Step 5)
3. file letterale nome.blade.php            → MatchLiteralViews (Step 6)
4. file parametrico [param].blade.php       → MatchWildcardViews (Step 7)
```

**`[container1]/index.blade.php` (tipo 2) vince SEMPRE su `[slug].blade.php` (tipo 4).**

## Soluzioni per Dare Priorita' a `[slug].blade.php`

### Soluzione 1: Rimuovere `[container1]/index.blade.php` (Consigliata)

Se `[container1]/index.blade.php` non serve, rimuoverlo. Quando `MatchWildcardDirectories` non trova un `index.blade.php` nella cartella wildcard, passa a `$next()` e `MatchWildcardViews` (Step 7) cattura `[slug].blade.php`.

```bash
rm "Themes/Meetup/resources/views/pages/[container0]/[container1]/index.blade.php"
# Se la cartella e' vuota, rimuovere anche la cartella:
rmdir "Themes/Meetup/resources/views/pages/[container0]/[container1]/"
php artisan view:clear && php artisan route:clear
```

**Risultato**: `/it/events/laravel-beginners-pizza-night` usera' `[container0]/[slug].blade.php`.

### Soluzione 2: Usare Cartelle Letterali per Route Note (Consigliata per LaravelPizza)

Creare cartelle con nomi espliciti invece di catch-all generici:

```
pages/
├── [slug].blade.php                   → /{slug} (CMS catch-all)
└── events/
    └── [slug].blade.php               → /events/{slug} (dettaglio evento)
```

La cartella `events/` e' un match **letterale** (Step 4: `MatchLiteralDirectories`), che ha priorita' su `[container0]/` (Step 5: `MatchWildcardDirectories`). Nessuna interferenza possibile.

### Soluzione 3: Folio Model Binding con FQCN (Usata in LaravelPizza)

```
pages/
├── [slug].blade.php                                    → /{slug} (CMS catch-all)
└── events/
    └── [.Modules.Meetup.Models.Event].blade.php        → /events/{slug} (model binding)
```

Folio converte i punti in backslash e risolve automaticamente `Modules\Meetup\Models\Event`. Il `getRouteKeyName()` del modello determina la colonna (es. `slug`). La cartella letterale `events/` (Step 4) vince su qualsiasi `[container0]/` (Step 5).

### Soluzione 4: Middleware nel `[container0]/[slug0]/index.blade.php`

Se servono ENTRAMBI i pattern (container generico + slug specifico):

```php
<?php
declare(strict_types=1);
use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('container0.view');

middleware(PageSlugMiddleware::class);

new class extends Component {
    public string $container0;
    public string $slug0;
    public array $data = [];
    public string $pageSlug = '';

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
        {{-- IMPORTANTE: dentro @volt usare $pageSlug e $data (plain vars), NON $this-> --}}
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

**Funziona SOLO se `[container1]/index.blade.php` e' stato rimosso.**

## Architettura Consigliata per LaravelPizza

```
pages/
├── index.blade.php                                    → / (home)
├── [slug].blade.php                                   → /{slug} (CMS catch-all)
└── events/
    └── [.Modules.Meetup.Models.Event].blade.php       → /events/{slug} (model binding)
```

- `/it/events` → `[slug].blade.php` con `slug = 'events'` → carica `events.json` → lista eventi
- `/it/events/laravel-11` → `events/[.Modules.Meetup.Models.Event].blade.php` → model binding → dettaglio

**I file `[container0]/` dovrebbero essere rimossi** perche' intercettano tutte le route a 1-2-3 segmenti con match generici.

## Riferimenti

- Codice sorgente: `vendor/laravel/folio/src/Router.php` (linee 55-81)
- Pipeline step 2: `vendor/laravel/folio/src/Pipeline/MatchDirectoryIndexViews.php`
- Pipeline step 5: `vendor/laravel/folio/src/Pipeline/MatchWildcardDirectories.php`
- Pipeline step 7: `vendor/laravel/folio/src/Pipeline/MatchWildcardViews.php`
- State class: `vendor/laravel/folio/src/Pipeline/State.php`
- [Folio Routing Documentation](folio-routing.md)
- [Laravel Folio GitHub](https://github.com/laravel/folio)

## Soluzione Implementata: Pattern [container0]/[slug0] Agnostico

### Filosofia

Il pattern `[container0]/[slug0]/index.blade.php` deve essere **completamente agnostico** - non contiene logica specifica per nessun container (Event, Blog, ecc.). Segue i principi **DRY** e **KISS**.

### Struttura Attuale

```
pages/
├── index.blade.php                      → /
├── [slug].blade.php                    → /{slug} (CMS catch-all)
├── auth/
│   └── ...
└── [container0]/
    ├── index.blade.php                 → /{container0}
    └── [slug0]/
        └── index.blade.php             → /{container0}/{slug0}
```

### Principio Fondamentale (REGOLA OBBLIGATORIA)

**Il file di routing NON DEVE contenere logica di business!**

- ❌ `resolveContent()` - VIETATO
- ❌ `loadDynamicModel()` - VIETATO  
- ❌ Model mapping/config - VIETATO
- ✅ `$pageSlug` e `$data` passati al componente `<x-page>`

Il componente `<x-page>` carica il JSON (es. `events_view.json`) che contiene i blocchi. Il view path nel JSON gestisce il rendering.

**Perché?**
1. **Separation of Concerns**: Il file di routing gestisce solo il routing
2. **Testabilità**: Ogni componente testabile separatamente
3. **Manutenibilità**: Cambiare logica ≠ modificare routing
4. **Estendibilità**: Nuovi container senza toccare il file di routing

Il nome della route usa `name('container0.view')` - "view" indica che è una pagina generica di rendering, non i parametri URL.

```php
// pages/[container0]/[slug0]/index.blade.php
// AGNOSTICO - Nome semantico per il tipo di pagina
name('container0.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public string $container0 = '';
    public string $slug0 = '';
    public array $data = [];
    public string $pageSlug = '';

    public function mount(): void
    {
        // Lo slug per il JSON del dettaglio è 'container0.view' (es. events.view)
        $this->pageSlug = $this->container0 . '.view';

        // Passa container0 e slug0 ai componenti inclusi
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
        {{-- IMPORTANTE: dentro @volt usare $pageSlug e $data (plain vars), NON $this-> --}}
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

### Perché `container0.view` e non `container0.slug0`

Il nome della route in Folio (`name()`) è **semantico** - descrive cosa fa la pagina, non i parametri URL:

- `container0.view` → "una view generica che usa container0 come parametro"
- `container0.slug0` → ❌ Sembra descrivere i parametri, non il tipo di pagina

Questo segue le convenzioni Folio:
- `pages.events.show` → route per mostrare eventi
- `pages.view` → route generica per visualizzare contenuti
- `container0.view` → route generica per visualizzare container

### Flusso di Rendering

Il flusso corretto è:

1. **Routing file** `[container0]/[slug0]/index.blade.php`
   - `$pageSlug = container0.view` (es. `events.view`)
   - Passa `$pageSlug` e `$data` a `<x-page>`

2. **Componente `<x-page>`**
   - Carica il JSON (es. `events_view.json`)
   - Renderizza i blocchi definiti nel JSON

3. **Blocco nel JSON**
   - View: `components.blocks.events.detail`
   - Il componente riceve `$container0` e `$slug0` da `$data`
   - Carica l'Event model usando `$slug0`

### JSON Template

```json
// config/local/laravelpizza/database/content/pages/events_view.json
{
    "slug": "events.view",
    "content_blocks": {
        "it": [
            {
                "type": "events",
                "slug": "events-detail",
                "data": {
                    "view": "pub_theme::components.blocks.events.detail",
                    "title": "Event Details"
                }
            }
        ]
    }
}
```

Il blocco include `pub_theme::components.blocks.events.detail` che gestisce il rendering del dettaglio.

### Route Generate

```
GET  /it/{container0}              → [container0]/index.blade.php
GET  /it/{container0}/{slug0}      → [container0]/[slug0]/index.blade.php
```

### Vantaggi

1. **Completamente Agnostico**: Il file di routing è lo stesso per tutti i container
2. **Estendibile**: Aggiungi nuovi container senza toccare il routing
3. **Manutenibile**: La logica di risoluzione è centralizzata in un solo componente
4. **Testabile**: Ogni componente può essere testato separatamente

### Esempio URL

| URL | container0 | slug0 | Risultato |
|-----|------------|-------|------------|
| `/it/events` | events | - | Lista eventi (CMS) |
| `/it/events/laravel-pizza` | events | laravel-pizza | Dettaglio evento (via content-resolver) |
| `/it/blog` | blog | - | Lista blog (CMS) |
| `/it/blog/my-post` | blog | my-post | Dettaglio post (via content-resolver) |
