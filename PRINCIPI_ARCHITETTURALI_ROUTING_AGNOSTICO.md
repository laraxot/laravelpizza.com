# Principi Architetturali: Routing Agnostico in LaravelPizza

## 🚨 REGOLA FONDAMENTALE

**MAI inserire metodi come `resolveContent`, `loadDynamicModel` o qualsiasi logica di business nel file `[container0]/[slug0]/index.blade.php`**

## 🎯 Concetto Chiave: Routing Agnostico

Il file `[container0]/[slug0]/index.blade.php` deve essere completamente **agnostic** rispetto al contenuto che deve visualizzare:

### ❌ SBAGLIATO
```php
<?php
// ❌ MAI fare questo
use Modules\Meetup\Models\Event;

new class extends Component {
    public string $container0;
    public string $slug0;
    public ?object $item = null;
    
    public function mount(): void
    {
        $this->container0 = request()->route('container0') ?? '';
        $this->slug0 = request()->route('slug0') ?? '';
        $this->resolveContent();  // ❌ VIOLA il principio agnostico
    }
    
    // ❌ MAI - Questo va nel Content Resolver, non nel Router!
    private function resolveContent(): void { ... }
    
    // ❌ MAI - Mapping dei modelli nel router!
    private function loadDynamicModel(): ?object { ... }
};
?>
```

### ✅ CORRETTO
```php
<?php
// ✅ CORRETTO: Solo routing agnostico
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

## 🔑 Principi Architetturali

### 1. Separation of Concerns
- **Routing file**: Solo routing e passaggio parametri
- **Content Resolver**: Solo logica di risoluzione contenuti
- **CMS System**: Solo gestione contenuti statici
- **Model Loading**: Solo nei componenti appropriati

### 2. Agnosticismo
- Il file `[container0]/[slug0]/index.blade.php` deve funzionare con **qualsiasi** tipo di contenuto
- Non deve conoscere dettagli specifici (Event, Article, ecc.)
- Un solo file gestisce tutti i container (events, blog, products, ecc.)

### 3. CMS-Driven Architecture
- Il contenuto è gestito dal sistema CMS
- Il routing è completamente separato dalla logica di contenuto
- JSON files definiscono cosa visualizzare
- Componenti dinamici gestiscono il rendering

## 📋 Responsabilità del Routing

### ✅ DEVE FARE:
1. Dichiarare proprietà pubbliche per i parametri della route
2. Popolare `$data` in `mount()` con `view_slug = 'container.view'`
3. Passare i parametri al componente resolver
4. Restare completamente agnostico rispetto al contenuto

### ❌ NON DEVE MAI:
1. Importare modelli specifici (`Event`, `Article`, ecc.)
2. Fare query al database (`PageModel::firstWhere()`, `Event::where()`, ecc.)
3. Decidere quale componente renderizzare (`if ($item) { ... }`)
4. Contenere metodi di business logic (`resolveContent()`, `loadDynamicModel()`, ecc.)
5. Contenere mapping container→modello (`$knownMappings`, `$modelMap`, ecc.)
6. Gestire fallback o priorità di risoluzione

## 🎯 Dove Va la Logica di Risoluzione?

### 1. Content Resolver (`content-resolver.blade.php`)
Solo qui va la logica di risoluzione contenuti:

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
```

### 2. Sistema CMS (`<x-page>` Component)
Il componente `<x-page>` cerca il JSON corrispondente allo slug.

### 3. Action Classes (`ResolvePageAction.php`)
La logica complessa va in Action dedicate:

```php
// Modules\Cms\Actions\ResolvePageAction.php
private function loadDynamicModel(string $container0, string $slug0): ?object
{
    // Mappature note (Priority 1)
    $knownMappings = [
        'events' => 'Modules\\Meetup\\Models\\Event',
    ];
    // ... logica complessa qui
}
```

## 🔄 Flusso Corretto

```
1. URL: /it/events/laravel-beginners-pizza-night
   ↓
2. Folio Route: [container0]/[slug0]/index.blade.php (AGNOSTIC)
   ↓
3. Routing passa parametri a <x-page>
   ↓
4. CMS Component cerca JSON: events.laravel-beginners-pizza-night.json
   ↓
5. Content Blocks definiscono quale componente renderizzare
   ↓
6. Componenti specifici caricano modelli quando necessario
```

## ✅ Vantaggi del Pattern Corretto

1. **Agnostic**: Funziona con qualsiasi tipo di contenuto senza modifiche
2. **CMS-Driven**: Il JSON definisce tutto, non il routing
3. **DRY**: Un solo file routing per tutti i contenuti nested
4. **Scalabile**: Nuovi contenuti senza modifiche al routing
5. **Testabile**: Routing semplice da testare
6. **Manutenibile**: Logica centralizzata nel CMS e nei componenti
7. **Separazione Responsabilità**: Ogni layer ha una responsabilità chiara

## 🚫 Consequences of Violating the Rule

Se si inseriscono metodi come `resolveContent` o `loadDynamicModel` nel routing file:

1. **Violazione Separation of Concerns**: Il router conosce troppi dettagli
2. **Non riutilizzabile**: Aggiungere un nuovo container richiede modificare il router
3. **Difficile da testare**: Non si può testare la logica isolatamente
4. **Accoppiamento stretto**: Il router è accoppiato a specifici modelli
5. **Manutenzione difficile**: Modifiche richiedono aggiornamenti multipli
6. **Rigidità**: Sistema difficile da estendere

## 📝 Checklist di Conformità

Prima di commitare modifiche a `[container0]/[slug0]/index.blade.php`, verifica:

- [ ] ❌ NON ci sono `use` di modelli (`Event`, `Article`, ecc.)
- [ ] ❌ NON ci sono query al database (`PageModel::firstWhere()`, ecc.)
- [ ] ❌ NON ci sono metodi di business logic (`resolveContent()`, `loadDynamicModel()`, ecc.)
- [ ] ❌ NON ci sono `if` che decidono quale componente renderizzare
- [ ] ❌ NON ci sono `mount()` con `request()->route()` — Volt auto-inietta i parametri
- [ ] ✅ SOLO proprietà pubbliche per i parametri della route
- [ ] ✅ SOLO passaggio dati al componente resolver
- [ ] ✅ Nessuna logica di risoluzione contenuti nel file di routing

## 🎓 Implicazioni Architetturali

Questo pattern è fondamentale per mantenere il sistema:

- **Modulare**: Ogni componente fa una sola cosa
- **Estensibile**: Nuovi tipi di contenuto senza modifiche al routing
- **Manutenibile**: Logica facilmente localizzabile e modificabile
- **Testabile**: Ogni layer testabile separatamente
- **Scalabile**: Architettura che cresce senza complessità aggiuntiva

## 🔗 Riferimenti Interni

- `Themes/Meetup/docs/container0-use-x-page-not-content-resolver.md`
- `Themes/Meetup/docs/agnostic-routing.md`
- `Themes/Meetup/docs/container0-pattern-philosophy.md`
- `Themes/Meetup/docs/folio-dynamic-container-model-binding.md`
- `Modules/Meetup/docs/routing-no-business-logic.md`
- `Modules/Meetup/docs/folio-container-routing-priority.md`
- `Modules/Cms/app/Actions/ResolvePageAction.php`
- `Modules/Cms/docs/folio_routing_system.md`
