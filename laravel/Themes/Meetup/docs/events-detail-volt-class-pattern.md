# Events Detail Component - Volt Class-Inspired Pattern

## 🎯 Principio: Organizzazione Codice con Helper Class

Il componente `events/detail.blade.php` utilizza un pattern ispirato a Volt Class API per migliorare l'organizzazione del codice, la manutenibilità e la testabilità, mantenendo la compatibilità con il sistema CMS che include il componente tramite `@include`.

## 📜 Pattern: Helper Class invece di Volt Class

### Perché Helper Class invece di Volt Class?

Il componente viene incluso tramite `@include` da `page-content.blade.php`, quindi non è un componente Livewire standalone. Per questo motivo:

- ❌ **NON possiamo usare Volt Class API direttamente** (richiede componente Livewire)
- ✅ **Usiamo una Helper Class PHP** che segue lo stesso pattern organizzativo
- ✅ **Mantiene compatibilità** con `@include` del sistema CMS
- ✅ **Migliora organizzazione** del codice rispetto a blocchi `@php` inline

## 🏗️ Struttura Helper Class

### Classe EventDetailHelper

```php
<?php
declare(strict_types=1);

use Modules\Meetup\Models\Event;
use Illuminate\Support\Carbon;

class EventDetailHelper
{
    public function __construct(
        public ?Event $event = null,
        public mixed $item = null,
        public ?string $container0 = null,
        public ?string $slug0 = null,
    ) {}
    
    /**
     * Get the Event model (loaded from slug0 if needed)
     */
    public function getEventModel(): ?Event
    {
        // Support both 'event' (specific) and 'item' (generic) props
        $model = $this->event ?? $this->item;
        
        // If no event/item provided but slug0 is available, load the Event model
        if ($model === null && !empty($this->slug0)) {
            $model = Event::where('slug', $this->slug0)->first();
        }
        
        return $model instanceof Event ? $model : null;
    }
    
    /**
     * Get event data array for rendering
     */
    public function getEventData(): array
    {
        // Computed property pattern - calcola dati derivati
        $eventModel = $this->getEventModel();
        
        if ($eventModel instanceof Event) {
            // Trasforma modello in array per rendering
            // ...
        }
        
        return $defaultData;
    }
    
    /**
     * Get events URL for back link
     */
    public function getEventsUrl(): string
    {
        return LaravelLocalization::localizeUrl('/events');
    }
    
    /**
     * Get badge CSS class based on status
     */
    public function getBadgeClass(): string
    {
        $eventData = $this->getEventData();
        return $eventData['status'] === 'upcoming' ? 'bg-green-600' : 'bg-slate-500';
    }
}
```

### Utilizzo nel Componente Blade

```blade
@props([
    'event' => null,
    'item' => null,
    'container0' => null,
    'slug0' => null,
])

<?php
// Initialize helper with props from Blade @props directive
$helper = new EventDetailHelper(
    event: $event instanceof Event ? $event : null,
    item: $item,
    container0: $container0,
    slug0: $slug0,
);

// Get computed values (pattern simile a computed properties di Volt)
$eventModel = $helper->getEventModel();
$eventData = $helper->getEventData();
$eventsUrl = $helper->getEventsUrl();
$badgeClass = $helper->getBadgeClass();
?>

<div>
    {{-- Usa le variabili calcolate dalla helper class --}}
    <h1>{{ $eventData['title'] }}</h1>
    <a href="{{ $eventsUrl }}">Back to Events</a>
</div>
```

## ✅ Vantaggi del Pattern Helper Class

### 1. Organizzazione Codice

**Prima (blocchi @php inline):**
```php
@php
// Logica sparsa nel file
$eventModel = $event ?? $item;
if ($eventModel === null && !empty($slug0)) {
    $eventModel = Event::where('slug', $slug0)->first();
}
$startDate = $eventModel->start_date ?? Carbon::now();
// ... molte altre righe di logica
@endphp
```

**Dopo (Helper Class):**
```php
<?php
$helper = new EventDetailHelper(...);
$eventData = $helper->getEventData(); // Logica organizzata in metodi
?>
```

### 2. Testabilità

La Helper Class può essere testata facilmente:

```php
use Tests\TestCase;

class EventDetailHelperTest extends TestCase
{
    public function test_get_event_model_from_slug0(): void
    {
        $event = Event::factory()->create(['slug' => 'test-event']);
        
        $helper = new EventDetailHelper(slug0: 'test-event');
        $model = $helper->getEventModel();
        
        $this->assertInstanceOf(Event::class, $model);
        $this->assertEquals('test-event', $model->slug);
    }
    
    public function test_get_event_data_computed_property(): void
    {
        $event = Event::factory()->create([
            'title' => 'Test Event',
            'start_date' => now()->addDay(),
        ]);
        
        $helper = new EventDetailHelper(event: $event);
        $data = $helper->getEventData();
        
        $this->assertEquals('Test Event', $data['title']);
        $this->assertEquals('upcoming', $data['status']);
    }
}
```

### 3. Riusabilità

La Helper Class può essere riutilizzata in altri contesti:

```php
// In un controller
$helper = new EventDetailHelper(slug0: $slug);
$eventData = $helper->getEventData();

// In un altro componente Blade
$helper = new EventDetailHelper(event: $event);
$badgeClass = $helper->getBadgeClass();
```

### 4. Manutenibilità

- **Separazione responsabilità**: Logica di business separata dalla view
- **Metodi chiari**: Ogni metodo ha una responsabilità specifica
- **Type hints**: Miglior supporto IDE e type safety
- **Documentazione**: PHPDoc chiaro per ogni metodo

## 🔄 Pattern Computed Properties

La Helper Class implementa il pattern "computed properties" simile a Volt:

```php
// Pattern Volt (non disponibile qui)
public function getEventDataProperty(): array
{
    return [...];
}

// Pattern Helper Class (equivalente)
public function getEventData(): array
{
    return [...];
}
```

**Vantaggi:**
- ✅ Calcolo lazy: I valori vengono calcolati solo quando richiesti
- ✅ Caching implicito: Se chiamato più volte nello stesso request, può essere ottimizzato
- ✅ Dipendenze chiare: `getBadgeClass()` dipende da `getEventData()`

## 📝 Best Practices

### 1. Inizializzazione Helper

```php
// ✅ CORRETTO: Usa named parameters per chiarezza
$helper = new EventDetailHelper(
    event: $event instanceof Event ? $event : null,
    item: $item,
    container0: $container0,
    slug0: $slug0,
);

// ❌ SBAGLIATO: Parametri posizionali confusi
$helper = new EventDetailHelper($event, $item, $container0, $slug0);
```

### 2. Computed Properties Pattern

```php
// ✅ CORRETTO: Metodi che calcolano valori derivati
public function getEventData(): array
{
    $eventModel = $this->getEventModel(); // Usa altro metodo computed
    // ... calcola dati
}

// ❌ SBAGLIATO: Logica inline nel costruttore
public function __construct(...)
{
    $this->eventData = [...]; // Troppo presto, dipendenze non risolte
}
```

### 3. Type Safety

```php
// ✅ CORRETTO: Type hints chiari
public function getEventModel(): ?Event
{
    return $model instanceof Event ? $model : null;
}

// ❌ SBAGLIATO: Tipo mixed
public function getEventModel(): mixed
{
    return $model;
}
```

## 🔗 Confronto con Volt Class API

| Volt Class API | Helper Class Pattern |
|----------------|---------------------|
| `new class extends Component` | `class EventDetailHelper` |
| `public function getXProperty()` | `public function getX()` |
| `$this->property` | `$this->property` |
| Livewire reactivity | No reactivity (static) |
| `@volt` directive | `@include` compatibility |

**Quando usare Helper Class:**
- ✅ Componenti inclusi via `@include`
- ✅ Logica che non richiede reattività Livewire
- ✅ Miglior organizzazione codice senza dipendenze Livewire

**Quando usare Volt Class:**
- ✅ Componenti standalone Livewire
- ✅ Componenti che richiedono reattività
- ✅ Componenti in pagine Folio con `@volt`

## 🔗 Riferimenti

- [Events Detail Slug0 Loading](events-detail-slug0-loading.md)
- [Volt Class API Documentation](https://livewire.laravel.com/docs/volt)
- [Container0 Slug0 Agnostic Pattern](container0-slug0-agnostic-pattern.md)
- [CMS JSON Content System](../../Modules/Cms/docs/json-content-system-architecture.md)
