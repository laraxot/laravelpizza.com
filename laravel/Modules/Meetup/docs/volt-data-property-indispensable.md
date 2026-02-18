# Volt Component: `public array $data = []` è INDISPENSABILE

## 🎯 Principio: `$data` è Necessario per Passare Variabili ai Componenti Inclusi

**La proprietà `public array $data = []` nel componente Volt è INDISPENSABILE** per far arrivare le variabili ai componenti inclusi tramite il sistema CMS.

## ❌ SBAGLIATO: Omettere `public array $data = []`

**NON fare MAI questo:**

```php
<?php
new class extends Component {
    public string $container0;
    public string $slug0;
    // ❌ MANCA: public array $data = [];
};
?>

@volt('container0.view')
<div>
    <x-page side="content" :slug="$fullSlug" />
</div>
@endvolt
```

**Perché è SBAGLIATO:**

1. **`$this->data` non esiste**: Senza dichiarare `public array $data = []`, la proprietà non esiste
2. **Variabili non arrivano**: `page-content.blade.php` fa `array_merge($block->data, $this->data)` - se `$this->data` non esiste, le variabili non vengono passate
3. **Componenti inclusi non ricevono dati**: I componenti block non ricevono `container0` e `slug0` tramite `$data`

## ✅ CORRETTO: Dichiarare `public array $data = []`

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
    // Volt popola automaticamente queste proprietà dalla route Folio
    public string $container0;
    public string $slug0;
    
    // ✅ INDISPENSABILE: $data per passare variabili ai componenti inclusi
    // page-content.blade.php fa: array_merge($block->data, $this->data)
    public array $data = [];
    
    // ✅ Slug per il JSON della pagina di dettaglio (es. events.view)
    public string $pageSlug = '';

    public function mount(): void
    {
        // Volt ha già popolato $this->container0 e $this->slug0 automaticamente
        // Lo slug per il JSON è container0.view (es. events.view)
        // NON container0.slug0 — il JSON template del dettaglio è sempre .view
        $this->pageSlug = $this->container0 . '.view';
        
        // ✅ Popolare $this->data per passare variabili ai componenti inclusi
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

## 🔄 Come Funziona il Flusso dei Dati

### 1. Volt Popola Proprietà dalla Route

```php
new class extends Component {
    // Volt popola automaticamente da [container0]/[slug0]
    public string $container0;  // = 'events'
    public string $slug0;       // = 'laravel-beginners-pizza-night'
    public array $data = [];    // Array vuoto inizialmente
};
```

### 2. Popolare `$this->data` e `$this->pageSlug` in `mount()`

```php
public function mount(): void
{
    // Lo slug JSON è sempre container0.view (es. events.view)
    $this->pageSlug = $this->container0 . '.view';
    
    // Popolare $this->data con i valori da passare ai componenti inclusi
    $this->data = [
        'container0' => $this->container0,
        'slug0' => $this->slug0,
    ];
}
```

### 3. Passare `$this->data` al Componente `<x-page>`

```blade
<x-page side="content" :slug="$this->pageSlug" :data="$this->data" />
```

### 4. Componente `<x-page>` Passa `$this->data` ai Block Components

**File**: `Modules/Cms/resources/views/components/page-content.blade.php`

```blade
@foreach($blocks as $block)
    @include($block->view, array_merge($block->data, $this->data))
@endforeach
```

**Spiegazione**:
- `$block->data` = dati dal JSON (`events_view.json`)
- `$this->data` = dati dal componente Volt (`container0`, `slug0`)
- `array_merge($block->data, $this->data)` = unisce i dati, con precedenza a `$this->data`

### 5. Componenti Block Ricevono le Variabili

**File**: `components/blocks/events/detail.blade.php`

```blade
@props([
    'container0' => null,
    'slug0' => null,
    // ... altre props
])

@php
// ✅ Le variabili arrivano tramite $data passato da page-content.blade.php
// Quando Laravel fa @include con array_merge, espande l'array in variabili separate
if ($eventModel === null && !empty($slug0)) {
    $eventModel = Event::where('slug', $slug0)->first();
}
@endphp
```

## 📜 Perché `$data` è INDISPENSABILE

### 1. `page-content.blade.php` Usa `$this->data`

Il componente `<x-page>` passa `$this->data` ai componenti inclusi:

```blade
@include($block->view, array_merge($block->data, $this->data))
```

**Se `$this->data` non esiste:**
- ❌ `$this->data` è `null` o non definito
- ❌ `array_merge()` fallisce o ignora `$this->data`
- ❌ I componenti inclusi non ricevono `container0` e `slug0`

**Se `$this->data` esiste:**
- ✅ `array_merge()` unisce correttamente i dati
- ✅ I componenti inclusi ricevono `container0` e `slug0`
- ✅ I componenti possono caricare modelli usando `$slug0`

### 2. Volt Non Popola Automaticamente `$data`

Volt popola automaticamente solo le proprietà che corrispondono ai parametri della route:
- ✅ `public string $container0` → popolato da `[container0]`
- ✅ `public string $slug0` → popolato da `[slug0]`
- ❌ `public array $data` → NON popolato automaticamente (non è un parametro route)

### 3. `$data` Deve Essere Popolato in `mount()`

Nel metodo `mount()`, devi popolare manualmente `$this->data`:

```php
public function mount(): void
{
    $this->pageSlug = $this->container0 . '.view';
    $this->data = [
        'container0' => $this->container0,
        'slug0' => $this->slug0,
    ];
}
```

## ✅ Best Practices

1. **Sempre dichiarare `public array $data = []`**: Nel componente Volt quando si passa dati ai componenti inclusi
2. **Popolare `$this->data` in `mount()`**: Con i valori da passare ai componenti inclusi
3. **Usare `$this->pageSlug = container0 . '.view'`**: NON `container0 . '.' . slug0` — il JSON template di dettaglio è sempre `.view`
4. **Passare `:slug` e `:data` al componente `<x-page>`**: Tramite `:slug="$this->pageSlug"` e `:data="$this->data"`

## 🔗 Riferimenti

- [Volt Automatic Route Binding](../Themes/Meetup/docs/volt-automatic-route-binding.md)
- [Routing No Business Logic](../Themes/Meetup/docs/routing-no-business-logic.md)
- [Container0 Slug0 Agnostic Pattern](container0-slug0-agnostic-pattern.md)
- [Page Content Component](../../Cms/resources/views/components/page-content.blade.php)
