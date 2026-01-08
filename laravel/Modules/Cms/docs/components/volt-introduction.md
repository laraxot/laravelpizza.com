# Introduzione a Laravel Volt

## Panoramica

Laravel Volt è un'API funzionale elegantemente progettata per Livewire che permette di coesistere la logica PHP e i template Blade nello stesso file. Questa guida illustra i concetti fondamentali di Volt nel contesto del modulo CMS.

## Concetti Base

### Componenti Volt

Un componente Volt base ha questa struttura:

```php
<?php

// Resources/views/pages/hello.blade.php
use function Livewire\Volt\{state};

state(['name' => 'Mondo']);

$setName = fn ($value) => $this->name = $value;
?>

<x-layouts.cms>
    <div>
        <h1>Ciao, {{ $name }}!</h1>
        
        <x-cms::input-field
            wire:model.live="name"
            label="Nome"
        />
    </div>
</x-layouts.cms>
```

### Integrazione con Folio

Volt si integra perfettamente con Laravel Folio per creare pagine interattive. Esempio:

```php
<?php

// Resources/views/pages/counter.blade.php
use function Livewire\Volt\{state};

state(['count' => 0]);

$increment = fn () => $this->count++;
?>

<x-layouts.cms>
    <div>
        <h1>{{ $count }}</h1>
        
        <x-cms::button wire:click="increment">
            Incrementa
        </x-cms::button>
    </div>
</x-layouts.cms>
```

### Componenti Inline con @volt

È possibile utilizzare componenti Volt direttamente nelle pagine Folio usando la direttiva `@volt`:

```php
// Resources/views/pages/dashboard.blade.php
<x-layouts.cms>
    <div>
        <h1>Dashboard</h1>
        
        @volt('counter')
            state(['count' => 0]);
            
            $increment = fn () => $this->count++;
            
            <>
                <div>
                    <h2>{{ $count }}</h2>
                    <x-cms::button wire:click="increment">
                        Incrementa
                    </x-cms::button>
                </div>
            </>
        @endvolt
    </div>
</x-layouts.cms>
```

## Funzionalità Avanzate

### Proprietà Reactive e Locked

Volt supporta tutte le funzionalità moderne di Livewire:

```php
<?php

use function Livewire\Volt\{state, locked};

// Proprietà reactive
state(['email' => '']);

// Proprietà bloccate (non modificabili dal frontend)
locked(['userId' => auth()->id()]);

$updateEmail = function ($newEmail) {
    $this->email = $newEmail;
};
?>
```

### Testing

I componenti Volt possono essere testati come qualsiasi altro componente Livewire:

```php
namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Volt\Volt;

class CounterTest extends TestCase
{
    /** @test */
    public function it_can_increment_count()
    {
        Volt::test('counter')
            ->assertSet('count', 0)
            ->call('increment')
            ->assertSet('count', 1);
    }
}
```

## Best Practices

### 1. Organizzazione del Codice

- Mantenere i componenti piccoli e focalizzati
- Utilizzare computed properties per logica complessa
- Separare la logica di business in servizi dedicati

```php
use function Livewire\Volt\{state, computed};

state(['items' => []]);

$filteredItems = computed(function () {
    return collect($this->items)
        ->filter(fn ($item) => $item['active'])
        ->values()
        ->all();
});
```

### 2. Riutilizzo dei Componenti

- Creare componenti riutilizzabili con la direttiva `@volt`
- Utilizzare props per la configurazione
- Implementare eventi per la comunicazione

```php
@volt('shared.alert', ['type' => 'success'])
    state(['visible' => true]);
    
    $hide = fn () => $this->visible = false;
    
    <>
        @if($visible)
            <div class="alert alert-{{ $type }}">
                {{ $slot }}
                <x-cms::button wire:click="hide">×</x-cms::button>
            </div>
        @endif
    </>
@endvolt
```

### 3. Performance

- Utilizzare lazy loading per componenti pesanti
- Implementare caching dove appropriato
- Ottimizzare le query del database

```php
use function Livewire\Volt\{state, computed};

state(['items' => null]);

// Lazy loading dei dati
$loadItems = function () {
    $this->items = cache()->remember('items', now()->addHour(), function () {
        return Item::query()
            ->with('category')
            ->latest()
            ->get();
    });
};
```

## Integrazione con il Modulo CMS

### 1. Struttura dei Componenti

```plaintext
Resources/
└── views/
    ├── components/
    │   └── volt/
    │       ├── forms/
    │       ├── lists/
    │       └── widgets/
    └── pages/
        └── cms/
```

### 2. Convenzioni di Naming

- Utilizzare PascalCase per i nomi dei componenti
- Suffisso `Form` per i componenti form
- Suffisso `List` per le liste
- Suffisso `Widget` per i widget

### 3. Eventi Custom

```php
use function Livewire\Volt\{state};

state(['data' => []]);

$emit = function ($event) {
    $this->dispatch('cms-event', [
        'type' => $event,
        'timestamp' => now(),
        'data' => $this->data,
    ]);
};
```

## Risorse Utili

- [Documentazione Ufficiale Volt](https://livewire.laravel.com/docs/volt)
- [Blog Laravel - Introducing Volt](https://blog.laravel.com/introducing-volt-an-elegantly-crafted-functional-api-for-livewire)
- [Laravel Folio](https://laravel.com/docs/folio)
- [Esempi di Componenti Volt](https://github.com/livewire/volt/tree/main/examples) 

## Collegamenti tra versioni di volt-introduction.md
* [volt-introduction.md](laravel/Modules/Cms/docs/volt-introduction.md)
* [volt-introduction.md](laravel/Modules/Cms/docs/components/volt-introduction.md)

