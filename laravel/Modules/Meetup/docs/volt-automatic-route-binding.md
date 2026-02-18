# Volt Automatic Route Parameter Binding

## 🎯 Principio: Volt Gestisce Automaticamente i Parametri della Route

**Volt/Livewire popola automaticamente le proprietà pubbliche del componente con i parametri della route Folio.**

## ❌ SBAGLIATO: Estrazione Manuale dei Parametri

**NON fare MAI questo:**

```php
<?php
new class extends Component {
    public string $container0;
    public string $slug0;

    public function mount(): void
    {
        // ❌ VIETATO: Estrazione manuale - Volt si arrangia da solo con quei parametri!
        $this->container0 = $this->container0 ?? request()->route('container0') ?? '';
        $this->slug0 = $this->slug0 ?? request()->route('slug0') ?? '';
    }
};
?>

@php
// ❌ VIETATO: Estrazione manuale - Volt si arrangia da solo con quei parametri!
$container0 = $container0 ?? request()->route('container0') ?? '';
$slug0 = $slug0 ?? request()->route('slug0') ?? '';
@endphp
```

**Perché è SBAGLIATO:**

1. **Ridondanza**: Volt/Livewire già popola automaticamente le proprietà pubbliche
2. **Codice inutile**: L'estrazione manuale è superflua
3. **Manutenzione**: Codice aggiuntivo da mantenere senza benefici
4. **Performance**: Query aggiuntive a `request()->route()` non necessarie

## ✅ CORRETTO: Volt Gestisce Automaticamente

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
    // ✅ CORRETTO: Volt popola automaticamente queste proprietà dalla route
    // La definizione della classe del componente con le proprietà pubbliche è indispensabile per far arrivare le variabili a Volt
    public string $container0;
    public string $slug0;
    public array $data = [];
    public string $pageSlug = '';

    public function mount(): void
    {
        // Lo slug per il JSON è container0.view (es. events.view)
        // NON container0.slug0 — il JSON template del dettaglio è sempre .view
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

## 🔄 Come Funziona Volt Automatic Binding

### 1. Folio Estrae Parametri dalla Route

Quando Folio matcha una route come `/it/events/laravel-beginners-pizza-night` con il file `[container0]/[slug0]/index.blade.php`:

```
Route: /it/events/laravel-beginners-pizza-night
File: [container0]/[slug0]/index.blade.php
Parametri estratti:
  - container0 = 'events'
  - slug0 = 'laravel-beginners-pizza-night'
```

### 2. Volt Popola Automaticamente le Proprietà

Volt/Livewire cerca proprietà pubbliche nel componente con lo stesso nome dei parametri della route e le popola automaticamente:

```php
new class extends Component {
    // Volt popola automaticamente $this->container0 = 'events'
    public string $container0;
    
    // Volt popola automaticamente $this->slug0 = 'laravel-beginners-pizza-night'
    public string $slug0;
};
```

### 3. Accesso ai Parametri nel Componente

Nel blocco `@volt()` puoi accedere direttamente a `$this->container0` e `$this->slug0`:

```php
// ✅ CORRETTO: Usare mount() per inizializzare pageSlug e data
public function mount(): void
{
    // Lo slug JSON è sempre container0.view (es. events.view)
    $this->pageSlug = $this->container0 . '.view';
    $this->data = [
        'container0' => $this->container0,
        'slug0' => $this->slug0,
    ];
}
```

## 📜 Regole per Volt Automatic Binding

### ✅ Cosa Fare

1. **Dichiarare proprietà pubbliche** con lo stesso nome dei parametri della route:
   ```php
   public string $container0;  // Nome deve matchare il parametro [container0]
   public string $slug0;       // Nome deve matchare il parametro [slug0]
   ```

2. **Usare direttamente `$this->property`** nel blocco `@volt()`:
   ```blade
   @volt('container0.view')
   {{ $this->container0 }}  <!-- ✅ Volt ha già popolato -->
   {{ $this->slug0 }}        <!-- ✅ Volt ha già popolato -->
   @endvolt
   ```

3. **Rimuovere `mount()` se non necessario**:
   ```php
   // ✅ CORRETTO: Se non serve logica aggiuntiva, non serve mount()
   new class extends Component {
       public string $container0;
       public string $slug0;
   };
   ```

### ❌ Cosa NON Fare

1. **NON estrarre manualmente** i parametri nel `mount()`:
   ```php
   // ❌ VIETATO: Estrazione manuale - Volt si arrangia da solo con quei parametri!
   public function mount(): void
   {
       $this->container0 = request()->route('container0') ?? '';
   }
   ```

2. **NON estrarre manualmente** nei blocchi `@php`:
   ```php
   // ❌ VIETATO: Estrazione manuale - Volt si arrangia da solo con quei parametri!
   @php
   $container0 = request()->route('container0') ?? '';
   @endphp
   ```

3. **NON usare `??` con `request()->route()`** quando Volt gestisce già:
   ```php
   // ❌ VIETATO: Estrazione manuale - Volt si arrangia da solo con quei parametri!
   $this->container0 = $this->container0 ?? request()->route('container0') ?? '';
   ```

## 🎯 Quando Usare `mount()`

Usa `mount()` SOLO se devi fare logica aggiuntiva che NON è legata all'estrazione dei parametri:

```php
new class extends Component {
    public string $container0;  // Volt popola automaticamente
    public string $slug0;       // Volt popola automaticamente
    public array $data = [];    // Proprietà custom

    public function mount(): void
    {
        // ✅ CORRETTO: Solo logica aggiuntiva, NON estrazione parametri
        $this->data['container0'] = $this->container0;  // Volt ha già popolato
        $this->data['slug0'] = $this->slug0;            // Volt ha già popolato
    }
};
```

## ✅ Best Practices

1. **Fidati di Volt**: Volt gestisce automaticamente i parametri della route
2. **Dichiarare proprietà pubbliche**: Con lo stesso nome dei parametri Folio
3. **Usare direttamente `$this->property`**: Nel blocco `@volt()`
4. **Evitare estrazione manuale**: Non è necessaria e aggiunge complessità
5. **`mount()` solo per logica aggiuntiva**: Non per estrarre parametri

## 🔗 Riferimenti

- [Laravel Volt Documentation](https://livewire.laravel.com/docs/volt)
- [Laravel Folio Documentation](https://laravel.com/docs/folio)
- [Routing No Business Logic](../Themes/Meetup/docs/routing-no-business-logic.md)
- [Container0 Slug0 Agnostic Pattern](container0-slug0-agnostic-pattern.md)
