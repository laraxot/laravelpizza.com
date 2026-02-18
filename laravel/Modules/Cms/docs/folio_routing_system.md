# Sistema di Routing e Localizzazione con Laravel Folio + Volt

## Risorse Ufficiali
- [Laravel Folio Documentation](https://laravel.com/docs/12.x/folio)
- [Livewire Volt Documentation](https://livewire.laravel.com/docs/volt)
- [Volt Class-based API](https://laravel-news.com/livewire-volt-class-based-api)

## Collegamenti correlati
- [Indice documentazione CMS](/laravel/Modules/Cms/project_docs/index.md)
- [Gestione Route Folio](/laravel/Modules/Cms/project_docs/gestione-route-folio.md)
- [Frontoffice Flow](/laravel/Modules/Cms/project_docs/frontoffice-flow.md)
- [Volt Folio Structure](/laravel/Modules/Cms/project_docs/volt_folio_structure.md)
- [Documentazione generale progetto](/project_docs/README.md)

## Panoramica

Il modulo CMS utilizza **Laravel Folio** per gestire le rotte del frontoffice, incluse le rotte localizzate come `/it`, `/en`, ecc. Questo sistema permette di creare pagine dinamiche basate su file di view senza dover definire esplicitamente le rotte.

## Architettura

### Laravel Folio
- **Folio** gestisce automaticamente le rotte basandosi sulla struttura dei file nelle directory `pages`
- Le rotte sono registrate automaticamente nel `CmsServiceProvider`
- Supporta la localizzazione attraverso parametri URI dinamici

### Localizzazione
- Utilizza **Laravel Localization** per gestire le lingue supportate
- Le rotte sono prefissate con il codice lingua (es. `/it`, `/en`)
- La lingua corrente viene determinata automaticamente da `LaravelLocalization::setLocale()`

## Configurazione nel CmsServiceProvider

```php
public function registerFolio(): void
{
    // Ottiene i middleware di base dal TenantService
    $middleware = TenantService::config('middleware');
    $base_middleware = Arr::get($middleware, 'base', []);
    
    // Aggiunge middleware per la localizzazione
    $base_middleware[] = \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class;
    $base_middleware[] = \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class;

    // Ottiene il percorso del tema corrente
    $theme_path = XotData::make()->getPubThemeViewPath('pages');
    
    // Ottiene la lingua corrente
    $currentLocale = LaravelLocalization::setLocale() ?? app()->getLocale();

    // Registra le pagine del tema con prefisso lingua
    Folio::path($theme_path)
        ->uri($currentLocale)
        ->middleware(['*' => $base_middleware]);

    // Registra le pagine dei moduli
    $modules = Module::collections();
    foreach ($modules as $module) {
        $path = $module->getPath().'/resources/views/pages';
        if (File::exists($path)) {
            Folio::path($path)
                ->uri($currentLocale)
                ->middleware(['*' => $base_middleware]);
        }
    }

    // Monta i percorsi per Volt
    Volt::mount($paths);
}
```

## Struttura delle Directory

### Tema Principale
```
Themes/{theme_name}/resources/views/pages/
├── index.blade.php          # Homepage (/)
├── about.blade.php          # Pagina about (/about)
├── contact/
│   └── index.blade.php      # Pagina contatti (/contact)
├── events/
│   ├── index.blade.php      # Lista eventi (/events)
│   └── [slug].blade.php     # Dettaglio evento (/events/{slug})
├── [slug].blade.php         # Catch-all per altre pagine CMS
└── ...
```

### Moduli
```
Modules/{ModuleName}/resources/views/pages/
├── index.blade.php          # Pagina principale del modulo
├── {feature}/
│   └── index.blade.php      # Pagina specifica della feature
└── ...
```

## Ordine di Precedenza delle Route Folio

Folio risolve le route in base alla **specificità del path**. Ecco l'ordine di priorità (dal più alto al più basso):

1. **File esatti**: `index.blade.php`, `about.blade.php` → `/`, `/about`
2. **Directory specifica**: `events/index.blade.php` → `/events`
3. **Route con parametri in directory specifica**: `events/[slug].blade.php` → `/events/{slug}`
4. **Catch-all generico**: `[slug].blade.php` → `/{slug}`
5. **Route annidate con parametri**: `[container0]/[slug].blade.php` → `/{container0}/{slug}`

### Esempio Pratico

Per la URL `/it/events/laravel-beginners-pizza-night`:

| Pattern | Route | Precedenza |
|---------|-------|-------------|
| `pages/events/index.blade.php` | `/it/events` | ✅ Solo path esatto |
| `pages/events/[slug].blade.php` | `/it/events/{slug}` | **✅ PIÙ ALTA** |
| `pages/[container0]/index.blade.php` | `/it/{container0}` | ❌ Non matcha |
| `pages/[container0]/[slug].blade.php` | `/it/{container0}/{slug}` | ❌ Meno specifico |
| `pages/[container0]/[container1]/index.blade.php` | `/it/{container0}/{container1}` | ❌ Meno specifico |
| `pages/[slug].blade.php` | `/it/{slug}` | ❌ Catch-all |

**Regola chiave**: Folio preferisce sempre la route più **specifica**. 
- `events/[slug].blade.php` ha priorità su `[container0]/[slug].blade.php` perché `events` è più specifico di `[container0]`.

### Come Dare Precedenza a una Route

Per dare priorità a una route specifica:

1. **Usare directory specifica** (consigliato):
   ```
   pages/events/[slug].blade.php  ✅
   pages/[container0]/[slug].blade.php  ❌
   ```

2. **Rimuovere file non necessari**:
   ```bash
   rm -rf pages/[container0]
   ```

## Pattern Container0/Slug0 per CMS-Driven Dinamico

### Filosofia

Il pattern `[container0]/[slug0]` permette di gestire **qualsiasi container dinamico** (events, blog, community, etc.) con un singolo set di file Blade. Questo segue i principi **DRY** (Don't Repeat Yourself) e **KISS** (Keep It Simple).

### Struttura

```
pages/
├── index.blade.php                    → / (homepage)
├── [slug].blade.php                   → /{slug} (CMS catch-all)
├── [container0]/
│   └── index.blade.php               → /{container0} (lista container)
└── [container0]/
    └── [slug0]/
        └── index.blade.php            → /{container0}/{slug0} (dettaglio)
```

### Esempio: Router Agnostico

Il file `[container0]/[slug0]/index.blade.php` deve essere **completamente agnostico** - solo un router che passa i parametri al sistema di risoluzione contenuti:

```php
<?php
declare(strict_types=1);

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('container0.view');  // Semantico: view = pagina generica di rendering
middleware(PageSlugMiddleware::class);

new class extends Component {
    // ✅ Volt auto-inietta i parametri della route!
    public string $container0 = '';
    public string $slug0 = '';
    public array $data = [];
    public string $pageSlug = '';
    
    // ✅ mount() prepara i dati da passare alla pagina CMS
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
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

**Principio chiave (REGOLA OBBLIGATORIA):** 
- Il file di routing **NON DEVE** contenere logica di business
- Deve **SOLO** passare `$pageSlug` e `$data` al componente `<x-page>`
- Il componente `<x-page>` carica il JSON (es. `events_view.json`) che contiene i blocchi
- Il view path nel JSON (es. `components.blocks.events.detail`) gestisce il rendering

**Perché?**
1. **Separation of Concerns**: Il file di routing gestisce solo il routing, non la business logic
2. **Testabilità**: Ogni componente può essere testato separatamente
3. **Manutenibilità**: Cambiare la logica di risoluzione non richiede modifiche al routing
4. **Estendibilità**: Nuovi container possono essere aggiunti senza toccare il file di routing
5. **Agnosticità**: Il file è lo stesso per tutti i container (events, blog, community, etc.)
- La naming convention segue lo stile Laravel: `resource.action`
  - `[container0]/index.blade.php` → `name('container0')`
  - `[container0]/[slug0]/index.blade.php` → `name('container0.view')`

### Content Resolver Block

La logica di risoluzione contenuti è spostata nel blocco `content-resolver.blade.php`:

```php
@props([
    'container0' => '',
    'slug0' => '',
])

@php
$content = null;
$contentType = null;
$view = null;
$pageSlug = '';

// Build full slug: events.laravel-beginners-pizza-night
$fullSlug = $container0 . '.' . $slug0;

// Priority 1: Try to load dynamic model (specific item)
$knownMappings = [
    'events' => \Modules\Meetup\Models\Event::class,
];

if (isset($knownMappings[$container0]) && !empty($slug0)) {
    $modelClass = $knownMappings[$container0];
    $item = $modelClass::where('slug', $slug0)->first();
    
    if ($item !== null) {
        $content = $item;
        $contentType = $container0;
        $view = 'blocks.' . $container0 . '.detail';
    }
}

// Priority 2: Check if exact CMS page exists
if ($content === null) {
    $page = \Modules\Cms\Models\Page::firstWhere('slug', $fullSlug);
    if ($page !== null) {
        $pageSlug = $fullSlug;
    }
}

// Priority 3: Fallback to container.view (e.g., events.view)
if ($content === null && $pageSlug === '') {
    $viewSlug = $container0 . '.view';
    $viewPage = \Modules\Cms\Models\Page::firstWhere('slug', $viewSlug);
    if ($viewPage !== null) {
        $pageSlug = $viewSlug;
    }
}

// Priority 4: Last resort - use exact slug
if ($content === null && $pageSlug === '') {
    $pageSlug = $fullSlug;
}
@endphp

@if($content && $view)
    @include($view, [
        'item' => $content,
        'container0' => $container0,
        'slug0' => $slug0,
    ])
@elseif($pageSlug)
    <x-page side="content" :slug="$pageSlug" :container0="$container0" :slug0="$slug0" />
@endif
```

### ⚠️ ANTI-PATTERN: MAI mettere logica nel Router

**SBAGLIATO** - Non mettere mai metodi `resolveContent()` o `loadDynamicModel()` nel file `[container0]/[slug0]/index.blade.php`:

```php
// ❌ ERRORE GRAVE - MAI FARE QUESTO
new class extends Component {
    public string $container0;
    public string $slug0;
    public ?object $item = null;
    
    public function mount(): void
    {
        $this->container0 = request()->route('container0') ?? '';
        $this->slug0 = request()->route('slug0') ?? '';
        // ❌ SBAGLIATO - Volt gestisce automaticamente l'iniezione dei parametri route grazie all'integrazione con Laravel Folio
        $this->resolveContent();  // ❌ VIOLA il principio agnostico
    }
    
    // ❌ MAI - Questo va nel Content Resolver, non nel Router!
    private function resolveContent(): void
    {
        // Logica specifica Event, PageModel, ecc.
        $item = $this->loadDynamicModel();
        if ($item !== null) {
            $this->item = $item;
        }
    }
    
    // ❌ MAI - Mapping dei modelli nel router!
    private function loadDynamicModel(): ?object
    {
        $knownMappings = [
            'events' => 'Modules\\Meetup\\Models\\Event',
        ];
        // ... logica di caricamento
    }
};
```

**Perché è sbagliato:**
1. **Violazione Separation of Concerns**: Il router conosce troppi dettagli
2. **Non riutilizzabile**: Aggiungere un nuovo container richiede modificare il router
3. **Difficile da testare**: Non si può testare la logica isolatamente
4. **Accoppiamento stretto**: Il router è accoppiato a specifici modelli (Event, PageModel)

**CORRETTO** - Il router deve essere completamente agnostico:

```php
// ✅ CORRETTO - Il routing file passa solo i parametri al content-resolver
new class extends Component {
    // ✅ Volt auto-inietta i parametri della route!
    public string $container0 = '';
    public string $slug0 = '';
    public array $data = [];
    
    // ✅ mount() per preparare i dati per il content-resolver
    public function mount(): void
    {
        // Lo slug per il JSON del dettaglio è 'container0.view' (es. events.view)
        // Questo permette di caricare events_view.json dal CMS
        $this->data = [
            'container0' => $this->container0,
            'slug0' => $this->slug0,
            'view_slug' => $this->container0 . '.view',
        ];
    }
};
```

La logica di risoluzione contenuti deve sempre essere nel **Content Resolver Block**, mai nel router.

### Vantaggi del Pattern Container0

1. **DRY**: Un solo set di file gestisce tutti i container
2. **Flessibile**: Aggiungi nuovi container senza creare nuovi file
3. **Manutenibile**: Logica centralizzata
4. **Scalabile**: Facilmente estendibile

### Route Generate

```
GET  /it/{container0}              → [container0]/index.blade.php
GET  /it/{container0}/{slug0}      → [container0]/[slug0]/index.blade.php
```

### Esempio URL

| URL | container0 | slug0 | Risultato |
|-----|------------|-------|------------|
| `/it/events` | events | - | Lista eventi (CMS) |
| `/it/events/laravel-pizza` | events | laravel-pizza | Dettaglio evento |
| `/it/blog` | blog | - | Lista blog (CMS) |
| `/it/blog/my-post` | blog | my-post | Dettaglio post |

### Best Practices

1. **Logica di routing nel Component**: Carica i dati appropriati in base al container
2. **Usa nomi descriptivi**: `container0`, `slug0` sono generici ma funzionali
3. **Fallback CMS**: Se non è un container speciale, usa il sistema CMS normale

### Riferimenti

- [Folio Official Docs](https://laravel.com/docs/folio)
- [GitHub Laravel Folio](https://github.com/laravel/folio)

## Middleware di Localizzazione

### Middleware Attivi
- `LocaleSessionRedirect`: Reindirizza basandosi sulla lingua salvata in sessione
- `LaravelLocalizationRedirectFilter`: Filtra e gestisce i redirect per la localizzazione

### Middleware Commentati (non utilizzati)
- `LaravelLocalizationRoutes`: Gestione avanzata delle rotte localizzate
- `LocaleCookieRedirect`: Redirect basato sui cookie
- `LaravelLocalizationViewPath`: Percorsi delle view localizzate

## Configurazione delle Lingue

### File di Configurazione
Le lingue supportate sono definite in `config/laravellocalization.php`:

```php
'supportedLocales' => [
    'it' => [
        'name' => 'Italiano',
        'script' => 'Latn',
        'native' => 'Italiano',
        'regional' => 'it_IT',
    ],
    'en' => [
        'name' => 'English',
        'script' => 'Latn', 
        'native' => 'English',
        'regional' => 'en_GB',
    ],
],
```

### Verifica della Configurazione
Il `CmsServiceProvider` verifica che:
1. La configurazione di localizzazione sia caricata
2. La lingua predefinita sia supportata
3. La lingua sia impostata correttamente

## Esempi di Rotte Generate

### Rotte del Tema
- `/it` → `Themes/{theme}/resources/views/pages/index.blade.php`
- `/it/about` → `Themes/{theme}/resources/views/pages/about.blade.php`
- `/it/contact` → `Themes/{theme}/resources/views/pages/contact/index.blade.php`

### Rotte dei Moduli
- `/it/blog` → `Modules/Blog/resources/views/pages/index.blade.php`
- `/it/predict` → `Modules/Predict/resources/views/pages/index.blade.php`

## Debugging e Troubleshooting

### Comandi Utili
```bash
# Verificare le rotte registrate
php artisan route:list

# Verificare i moduli attivi
php artisan module:list

# Pulire le cache
php artisan config:clear
php artisan view:clear
```

### Log e Monitoraggio
- I middleware di localizzazione loggano le operazioni di redirect
- Verificare i log in `storage/logs/laravel.log` per problemi di routing
- Utilizzare `php artisan telescope` per monitorare le richieste (se installato)

## Best Practices

### Organizzazione dei File
1. Mantenere una struttura coerente nelle directory `pages`
2. Utilizzare sottodirectory per raggruppare pagine correlate
3. Nominare i file in modo descrittivo e coerente

### Performance
1. Utilizzare il caching delle view quando possibile
2. Ottimizzare i middleware per ridurre l'overhead
3. Monitorare le performance delle rotte più utilizzate

### Sicurezza
1. Validare sempre i parametri di localizzazione
2. Utilizzare middleware di sicurezza appropriati
3. Proteggere le pagine sensibili con autenticazione

## Integrazione con Altri Sistemi

### XotComposer
Il sistema di routing Folio si integra con il `XotComposer` per:
- Fornire dati di contesto alle view
- Gestire i metodi dinamici per i temi
- Integrare con il sistema di traduzione

### Sistema di Traduzione
- Le chiavi di traduzione seguono la struttura gerarchica
- I file di traduzione sono organizzati per modulo
- Il sistema supporta il fallback automatico alle lingue predefinite

## Migrazione e Aggiornamenti

### Aggiornamento di Laravel Folio
1. Verificare la compatibilità con la versione di Laravel
2. Testare le rotte esistenti dopo l'aggiornamento
3. Aggiornare la documentazione se necessario

### Aggiunta di Nuove Lingue
1. Aggiungere la configurazione in `laravellocalization.php`
2. Creare i file di traduzione corrispondenti
3. Testare le rotte con la nuova lingua 
