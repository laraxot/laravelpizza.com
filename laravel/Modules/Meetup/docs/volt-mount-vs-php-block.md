# Volt Component: `mount()` vs Blocco `@php` - Best Practice

## 🎯 Principio: Usare `mount()` per Logica di Inizializzazione

**La logica per popolare `$this->data` e calcolare valori derivati dovrebbe essere nel metodo `mount()` invece che nel blocco `@php`.**

## ❌ SBAGLIATO: Logica nel Blocco `@php`

**NON fare MAI questo:**

```blade
@volt('container0.view')
@php
// ❌ SBAGLIATO: Logica nel blocco @php invece che in mount()
$fullSlug = $this->container0 . '.' . $this->slug0;
$this->data = [
    'container0' => $this->container0,
    'slug0' => $this->slug0,
];
@endphp
<div>
    <x-page side="content" :slug="$fullSlug" :data="$this->data" />
</div>
@endvolt
```

**Perché è SBAGLIATO:**

1. **Separazione responsabilità**: La logica di inizializzazione dovrebbe essere nel componente, non nella view
2. **Testabilità**: Difficile testare logica nel blocco `@php`
3. **Riusabilità**: La logica nel `@php` non è facilmente riusabile
4. **Organizzazione**: Il codice è più pulito quando la logica è nel componente

## ✅ CORRETTO: Logica nel Metodo `mount()`

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
    public string $container0;
    public string $slug0;
    public array $data = [];
    public string $pageSlug = '';

    public function mount(): void
    {
        // ✅ CORRETTO: Logica di inizializzazione nel mount()
        // Volt ha già popolato $this->container0 e $this->slug0 automaticamente
        
        // Lo slug per il JSON è container0.view (es. events.view)
        // Questo permette di caricare il JSON template per il dettaglio del container
        $this->pageSlug = $this->container0 . '.view';
        
        // Popolare $this->data per passare variabili ai componenti inclusi
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

## 📜 Perché `mount()` è Meglio

### 1. Separazione Responsabilità

**`mount()`**: Logica di inizializzazione del componente
**Blocco `@php`**: Solo preparazione dati per la view

### 2. Testabilità

La logica nel `mount()` può essere testata facilmente:

```php
$component = new Component();
$component->container0 = 'events';
$component->slug0 = 'test-event';
$component->mount();

expect($component->pageSlug)->toBe('events.view');
expect($component->data)->toHaveKey('container0');
```

### 3. Organizzazione Codice

Il codice è più organizzato quando la logica è nel componente:

```php
// ✅ CORRETTO: Tutta la logica nel componente
new class extends Component {
    public function mount(): void
    {
        // Logica qui
    }
};

// View pulita
@volt('container0.view')
<div>
    <x-page :slug="$this->pageSlug" :data="$this->data" />
</div>
@endvolt
```

### 4. Riusabilità

La logica nel `mount()` può essere facilmente estesa o sovrascritta:

```php
new class extends Component {
    public function mount(): void
    {
        parent::mount(); // Se estende un componente base
        
        // Logica aggiuntiva
        $this->data['custom'] = 'value';
    }
};
```

## 🎯 Quando Usare `mount()` vs Blocco `@php`

### ✅ Usare `mount()` per:

1. **Inizializzazione proprietà**: Popolare `$this->data`, calcolare valori derivati
2. **Logica di business**: Calcoli, trasformazioni dati
3. **Preparazione dati**: Preparare dati da passare ai componenti inclusi
4. **Validazione**: Validare o normalizzare dati

### ✅ Usare Blocco `@php` per:

1. **Preparazione view**: Preparare variabili solo per la view corrente
2. **Formattazione**: Formattare dati per la visualizzazione
3. **Logica view-specific**: Logica che serve solo per renderizzare la view

## 📝 Pattern Corretto: Slug `container0.view`

**Lo slug per il JSON deve essere `container0.view` (es. `events.view`), NON `container0.slug0`.**

**Perché:**

1. **JSON Template**: Il JSON `events_view.json` ha slug `events.view` e contiene il template per il dettaglio
2. **Pattern Generico**: `container0.view` funziona per qualsiasi container (`events.view`, `articles.view`, ecc.)
3. **Slug0 Passato via Data**: `slug0` viene passato tramite `$this->data` ai componenti inclusi
4. **Componenti Caricano Modello**: I componenti block (es. `events/detail.blade.php`) caricano il modello usando `$slug0`

**Flusso:**

```
1. URL: /it/events/laravel-beginners-pizza-night
   ↓
2. Volt popola: $this->container0 = 'events', $this->slug0 = 'laravel-beginners-pizza-night'
   ↓
3. mount() calcola: $this->pageSlug = 'events.view'
   ↓
4. mount() popola: $this->data = ['container0' => 'events', 'slug0' => 'laravel-beginners-pizza-night']
   ↓
5. <x-page slug="events.view" :data="$this->data" />
   ↓
6. JSON: events_view.json (slug: events.view)
   ↓
7. Component: events/detail.blade.php riceve $slug0 tramite $data
   ↓
8. Component carica: Event::where('slug', $slug0)->first()
```

## ✅ Best Practices

1. **Sempre usare `mount()` per inizializzazione**: Popolare `$this->data`, calcolare valori derivati
2. **Slug JSON = `container0.view`**: Non `container0.slug0`
3. **View pulita**: Solo rendering, nessuna logica complessa
4. **Separazione responsabilità**: Logica nel componente, rendering nella view

## 🔗 Riferimenti

- [Volt Data Property Indispensable](../themes/meetup/docs/volt-data-property-indispensable.md)
- [Volt Automatic Route Binding](../themes/meetup/docs/volt-automatic-route-binding.md)
- [Routing No Business Logic](../themes/meetup/docs/routing-no-business-logic.md)
- [Container0 Slug0 Agnostic Pattern](container0-slug0-agnostic-pattern.md)
