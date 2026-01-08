# Creazione di Applicazioni Web con Laravel Volt

## Introduzione

Questa guida illustra come implementare applicazioni web nel modulo CMS utilizzando Laravel Volt, con focus sulla semplicità e sulla "magia" di Volt.

## Struttura Base

### 1. Configurazione Iniziale
```php
namespace Modules\Cms\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;

class VoltServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Volt::mount([
            resource_path('views/pages'),
            module_path('Cms', 'Resources/views/pages'),
        ]);
    }
}
```

### 2. Layout Base
```php
// Resources/views/layouts/app.blade.php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <!-- Navigazione -->
        </nav>

        <main>
            {{ $slot }}
        </main>
    </div>
    @livewireScripts
</body>
</html>
```

## Implementazione Componenti Volt

### 1. Counter Component
```php
<?php

// Resources/views/pages/counter.blade.php
use function Livewire\Volt\{state, computed};

state(['count' => 0]);

$increment = fn () => $this->count++;
$decrement = fn () => $this->count--;

$isPositive = computed(function () {
    return $this->count > 0;
});
?>

<x-layouts.cms>
    <div class="p-6">
        <div class="max-w-sm mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Counter Magico</h2>
            
            <div class="text-center">
                <span class="text-4xl {{ $isPositive ? 'text-green-600' : 'text-red-600' }}">
                    {{ $count }}
                </span>
            </div>
            
            <div class="flex justify-center gap-4 mt-4">
                <x-cms::button wire:click="decrement">
                    -
                </x-cms::button>
                
                <x-cms::button wire:click="increment">
                    +
                </x-cms::button>
            </div>
        </div>
    </div>
</x-layouts.cms>
```

### 2. Form Dinamico
```php
<?php

// Resources/views/pages/dynamic-form.blade.php
use function Livewire\Volt\{state, rules, computed};

state([
    'formData' => [
        'name' => '',
        'email' => '',
        'message' => '',
    ],
    'submitted' => false,
]);

rules([
    'formData.name' => 'required|min:3',
    'formData.email' => 'required|email',
    'formData.message' => 'required|min:10',
]);

$submitForm = function () {
    $this->validate();
    
    // Logica di invio
    $this->submitted = true;
    $this->formData = [
        'name' => '',
        'email' => '',
        'message' => '',
    ];
};

$isValid = computed(function () {
    return !empty($this->formData['name']) && 
           !empty($this->formData['email']) && 
           !empty($this->formData['message']);
});
?>

<x-layouts.cms>
    <div class="max-w-2xl mx-auto py-6">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h2 class="text-lg font-medium mb-6">Form Dinamico</h2>

            @if($submitted)
                <div class="bg-green-50 text-green-800 p-4 rounded-lg mb-6">
                    Form inviato con successo!
                </div>
            @endif

            <form wire:submit="submitForm" class="space-y-4">
                <x-cms::input-field
                    wire:model="formData.name"
                    label="Nome"
                    :error="$errors->first('formData.name')"
                />

                <x-cms::input-field
                    wire:model="formData.email"
                    type="email"
                    label="Email"
                    :error="$errors->first('formData.email')"
                />

                <x-cms::textarea-field
                    wire:model="formData.message"
                    label="Messaggio"
                    :error="$errors->first('formData.message')"
                />

                <div class="flex justify-end">
                    <x-cms::button 
                        type="submit"
                        :disabled="!$isValid"
                    >
                        Invia
                    </x-cms::button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.cms>
```

### 3. Lista Dinamica
```php
<?php

// Resources/views/pages/dynamic-list.blade.php
use function Livewire\Volt\{state, computed};

state([
    'items' => [],
    'newItem' => '',
]);

$addItem = function () {
    if (empty($this->newItem)) return;
    
    $this->items[] = [
        'id' => uniqid(),
        'text' => $this->newItem,
        'completed' => false,
    ];
    
    $this->newItem = '';
};

$removeItem = function ($id) {
    $this->items = array_filter($this->items, fn($item) => $item['id'] !== $id);
};

$toggleItem = function ($id) {
    $this->items = array_map(function ($item) use ($id) {
        if ($item['id'] === $id) {
            $item['completed'] = !$item['completed'];
        }
        return $item;
    }, $this->items);
};

$completedCount = computed(function () {
    return count(array_filter($this->items, fn($item) => $item['completed']));
});
?>

<x-layouts.cms>
    <div class="max-w-2xl mx-auto py-6">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h2 class="text-lg font-medium mb-6">Lista Dinamica</h2>

            <div class="flex gap-4 mb-6">
                <x-cms::input-field
                    wire:model="newItem"
                    placeholder="Nuovo elemento..."
                    class="flex-1"
                />

                <x-cms::button wire:click="addItem">
                    Aggiungi
                </x-cms::button>
            </div>

            <div class="space-y-2">
                @foreach($items as $item)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <div class="flex items-center gap-3">
                            <x-cms::checkbox-field
                                wire:model.live="item.completed"
                                wire:click="toggleItem('{{ $item['id'] }}')"
                            />
                            
                            <span class="{{ $item['completed'] ? 'line-through text-gray-500' : '' }}">
                                {{ $item['text'] }}
                            </span>
                        </div>

                        <x-cms::button
                            wire:click="removeItem('{{ $item['id'] }}')"
                            variant="danger"
                            size="sm"
                        >
                            Rimuovi
                        </x-cms::button>
                    </div>
                @endforeach
            </div>

            @if($completedCount > 0)
                <div class="mt-4 text-sm text-gray-600">
                    Completati: {{ $completedCount }} di {{ count($items) }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.cms>
```

## Ottimizzazioni

### 1. Debounce e Throttle
```php
// Esempio di debounce su input
<x-cms::input-field
    wire:model.live.debounce.500ms="search"
    label="Cerca"
/>

// Esempio di throttle su azioni frequenti
<x-cms::button
    wire:click.throttle.1s="refreshData"
>
    Aggiorna
</x-cms::button>
```

### 2. Loading States
```php
<div wire:loading wire:target="submitForm">
    <x-cms::spinner />
</div>

<x-cms::button
    wire:loading.attr="disabled"
    wire:target="submitForm"
>
    <span wire:loading.remove>Invia</span>
    <span wire:loading>Invio in corso...</span>
</x-cms::button>
```

## Testing

### 1. Component Tests
```php
namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Volt\Volt;

class DynamicFormTest extends TestCase
{
    /** @test */
    public function it_validates_form_data()
    {
        Volt::test('dynamic-form')
            ->set('formData.name', '')
            ->set('formData.email', 'invalid-email')
            ->call('submitForm')
            ->assertHasErrors(['formData.name', 'formData.email']);
    }

    /** @test */
    public function it_submits_valid_form()
    {
        Volt::test('dynamic-form')
            ->set('formData.name', 'Test User')
            ->set('formData.email', 'test@example.com')
            ->set('formData.message', 'Test message content')
            ->call('submitForm')
            ->assertSet('submitted', true)
            ->assertSet('formData.name', '');
    }
}
```

## Best Practices

### 1. Computed Properties
```php
// Evita calcoli ripetuti usando computed properties
$stats = computed(function () {
    return [
        'total' => count($this->items),
        'completed' => count(array_filter($this->items, fn($item) => $item['completed'])),
        'pending' => count(array_filter($this->items, fn($item) => !$item['completed'])),
    ];
});
```

### 2. Riutilizzo del Codice
```php
// Traits per funzionalità comuni
trait WithSorting
{
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public function sort($field)
    {
        if ($field === $this->sortField) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
}
```

## Risorse Utili

### Documentation
- [Laravel Volt](https://livewire.laravel.com/docs/volt)
- [Livewire](https://livewire.laravel.com)
- [TailwindCSS](https://tailwindcss.com) 
