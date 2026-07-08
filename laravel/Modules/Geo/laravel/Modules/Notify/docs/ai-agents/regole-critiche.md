# Regole Critiche Laraxot

## 1. Estensioni Classi
Mai estendere classi Filament direttamente, sempre usare le classi XotBase corrispondenti
- ❌ `extends Filament\Resources\Pages\CreateRecord`
- ✅ `extends Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord`

## 2. Traduzioni
Mai usare metodi hardcoded come `->label()`, le traduzioni sono gestite automaticamente dal sistema
- Approfondimento: [Filosofia di Sviluppo](./filosofia-sviluppo.md) e [Componenti Chiave](./componenti-chiave.md)

## 3. Actions vs Services
Usare Spatie QueueableAction invece di Services tradizionali
- Vantaggi: Coda, ripetibilità, tracciamento
- Come implementare: [Configurazione e Setup](./configurazione.md)
- **Constructor DI consentita** se le dipendenze sono risolvibili dal container
- **Se l'action può andare in coda deve essere container-instantiable**: niente costruttori privati, singleton statici o pattern non risolvibili da `app()`
- **Metodo preferito del progetto: `execute()`**; il package supporta anche `__invoke()`
- Approfondimento: [queueable-actions.md](./queueable-actions.md)

## 4. BadgeColumn
Non usare più BadgeColumn, usare TextColumn con badge()
- Motivazione: Migliore gestibilità e consistenza visiva

## 5. Documentazione
Tutti gli script devono essere posizionati nella cartella `bashscripts/`, mai in `laravel/`
- Approfondimento: [Script e Automazione](./script-automazione.md)

## 5.b Parse blocker triage
Quando un errore arriva da una pagina Filament/Livewire:
- lintare subito con `php -l` il file citato nello stack trace;
- lintare anche i file della catena immediatamente caricata dalla pagina;
- solo dopo passare a test applicativi, query, container o permessi.

Per i chart Quaeris la catena minima da controllare e`:
- `QuestionChartChartData`
- `BuildQuestionChartDatasetAction`
- `BuildQuestionChartOptionsAction`
- blade/page custom

## 6. Short Array Syntax
SEMPRE usare `[]` nei file PHP, MAI usare `array()`
- ✅ `$data = ['key' => 'value'];`
- ❌ `$data = array('key' => 'value');`
- Eccezione: Solo quando si spiega come NON usare qualcosa in contesto didattico

## 7. Folio + Volt + Blade - CMS-Driven Pages

### ⚠️ CRITICAL RULE: Filament Widgets, NOT Livewire Pure!
Per OGNI componente dinamico che necessita interazione server (form, dropdown, modali, ecc.):
- ✅ **SEMPRE usare Filament Widgets** in `Modules/ModuleName/app/Filament/Widgets/`
- ❌ **MAI usare componenti Livewire puri** (eccetto Volt nelle pagine Folio)

### DUE Pattern per i Componenti:

#### A) Plain Blade PHP (per CMS Block Components)
Per i componenti blocco nel CMS (es. `components/blocks/events/detail.blade.php`), usare **Plain Blade PHP**, NON Volt!

```php
<?php
declare(strict_types=1);

/**
 * Event Detail - Plain Blade Component
 */

use Modules\Meetup\Models\Event;

// Carica l'evento dallo slug passato dal CMS
$slug0 = $slug0 ?? '';
$event = null;
if (!empty($slug0)) {
    $event = Event::where('slug', $slug0)->first();
}

// Variabili per il template
$eventsUrl = LaravelLocalization::localizeUrl('/events');
?>

@if($event)
    <h1>{{ $event->title }}</h1>
@endif
```

#### B) Volt Component (per Folio Pages)
Per le pagine Folio (`pages/[container0]/[slug0]/index.blade.php`), usare Volt:

```php
new class extends Component {
    public string $container0 = '';
    public string $slug0 = '';
    
    public function mount(): void { ... }
};
```

**REGOLA:**
- ✅ Block CMS → Plain Blade PHP
- ✅ Folio Pages → Volt Component

### Volt Blade Components - MODEL-FIRST Pattern

**❌ SBAGLIATO - Non creare proprietà ridondanti:**
```php
new class extends Component {
    public string $title = '';           // NO!
    public string $description = '';     // NO!
    public string $date = '';             // NO!
    public string $time = '';             // NO!
    public string $location = '';         // NO!
    // ... 20+ proprietà ridondanti!
    
    public function mount(): void {
        $this->title = $event->title;
        $this->description = $event->description;
        // ... duplicazione infinita!
    }
}
```

**✅ CORRETTO - Model-First Pattern:**
```php
<?php
declare(strict_types=1);

/**
 * Event detail block - Volt Component
 * Unica fonte di verità: Event model
 */

use Livewire\Volt\Component;
use Modules\Meetup\Models\Event;

new class extends Component {
    // Props dalla route o dal CMS
    public ?Event $event = null;
    public string $container0 = '';
    public string $slug0 = '';

    public function mount(): void
    {
        // Carica il modello se non passato come prop
        if ($this->event === null && $this->slug0 !== '') {
            $this->event = Event::where('slug', $this->slug0)->first();
        }
    }
    
    #[Computed]
    public function eventsUrl(): string
    {
        return LaravelLocalization::localizeUrl('/events');
    }
}; ?>
```

**✅ Accesso diretto nel template (NON $eventData[]):**
```blade
{{ $this->event?->title }}
{{ $this->event?->description }}
{{ $this->event?->start_date?->format('l, F j, Y') }}

@if($this->event?->start_date?->isFuture())
    <span class="bg-green-600">Upcoming</span>
@endif
```

### strict_types - REGOLA CRITICA

**❌ SBAGLIATO - spazi o commenti prima di declare:**
```php
<?php

declare(strict_types=1);  // NO! C'è una riga vuota prima!
```

**✅ CORRETTO - declare come prima istruzione:**
```php
<?php
declare(strict_types=1);

/**
 * Docblock del componente
 */
```

### Folio Pages - Volt Properties Access

**❌ SBAGLIATO - usare $this nel template Volt:**
```blade
:x-page :slug="$this->pageSlug"   <!-- NO! $this non funziona nel template -->
:x-page :data="$this->data"
```

**✅ CORRETTO - Volt espone le proprietà come variabili locali:**
```blade
<x-page :slug="$pageSlug" :data="$data" />
```

Il componente Volt espone le proprietà pubbliche come variabili locali nel template - si accede **SENZA** `$this->`.

### Folio Pages - CMS-Driven Agnostic Pattern
I file Folio in `Themes/Meetup/resources/views/pages/` sono **AGNOSTICI e PURI**:

### Regole Fondamentali
- ❌ **MAI** inserire metodi come `resolveContent()`, `loadDynamicModel()` nel componente
- ❌ **MAI** caricare modelli (Event, BlogPost, Product, ecc.)
- ❌ **MAI** fare query al database
- ✅ **SEMPRE** usare `PageSlugMiddleware` + `<x-page>`

### Pattern Corretto (con mount())
```php
// [container0]/[slug0]/index.blade.php - SOLO routing!
name('container0.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    // ✅ PROPRIETÀ OBBLIGATORIE - Volt le popola automaticamente dalla route
    public string $container0;
    public string $slug0;
    public array $data = [];
    public string $pageSlug = '';

    public function mount(): void
    {
        // ✅ CORRETTO: lo slug per il JSON è container0.view (es. events.view)
        // Questo permette di caricare il JSON template per il dettaglio del container
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

### Anti-Pattern (VIETATO!)
```php
// ❌ SBAGLIATO - Logica di business nel routing
new class extends Component {
    public function resolveContent() { ... }  // NO!
    public function loadDynamicModel() { ... }  // NO!
}

// ❌ SBAGLIATO - slug costruito male
$fullSlug = $this->container0 . '.' . $this->slug0;  // NO!
// ✅ CORRETTO
$fullSlug = $this->container0 . '.view';  // SI!
```

## 8. GitHub Integration (OBBLIGATORIO)
Quando c'è un errore/issue da correggere, CREARE SEMPRE:
- ✅ GitHub Issue con descrizione e tasks
- ✅ GitHub Discussion per approfondimenti
- ✅ Collegare a Projects se esistenti
- ✅ Aggiornare Wiki se necessario

```bash
# Creare issue
gh issue create --repo provtv/base_ptv_fila5_mono --title "..." --body "..."

# Creare discussion
gh api repos/provtv/base_ptv_fila5_mono/discussions --method POST -f category_id=... --field body="..."
```

## 9. Chaos Monkey Incident Response

- Prima regola: nessun fix senza root cause verificata.
- Durante incidente: fix minimo, niente refactor estensivi.
- Classificare il fault anche per cluster pacchetti (framework, filament/livewire, localization, spatie data/actions).
- Prima di analizzare un incidente nuovo, rieseguire `composer show` in `laravel/` e confrontare con il catalogo pacchetti completo.
- Mantenere invarianti:
  - `pub_theme::` per tema/view/traduzioni
  - `XotBase*` per Filament
  - no `->label()/->placeholder()/->helperText()`
  - no controller/route frontoffice
- Dopo recovery:
  - aggiungere test anti-regressione
  - aggiornare docs modulo/tema
  - aggiornare memory e skill operative in `.agents/`
