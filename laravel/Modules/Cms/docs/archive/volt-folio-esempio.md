# Esempio Pratico: Laravel Volt con Folio

Questa documentazione fornisce un esempio pratico di implementazione di Laravel Volt insieme a Laravel Folio, basato sul repository di esempio ufficiale.

## Struttura del Progetto

```
laravel-news-volt-folio-example/
├── app/
├── resources/
│   ├── views/
│   │   └── components/
│   └── pages/
├── routes/
└── tests/
```

## Setup Iniziale

### 1. Requisiti

```json
{
    "require": {
        "php": "^8.1",
        "laravel/framework": "^10.0",
        "livewire/volt": "^1.0",
        "livewire/livewire": "^3.0"
    }
}
```

### 2. Installazione

```bash
composer create-project laravel/laravel volt-example
cd volt-example
composer require livewire/volt
php artisan volt:install
```

## Implementazione dei Componenti

### 1. Componente Base con Volt

```php
<?php
// resources/views/pages/index.blade.php

use function Livewire\Volt\{state, computed};

state(['title' => 'Benvenuto in Volt']);

$welcomeMessage = computed(function () {
    return "Ciao! {$this->title}";
});

?>

<x-layout>
    <div>
        <h1>{{ $welcomeMessage }}</h1>
    </div>
</x-layout>
```

### 2. Form Interattivo

```php
<?php
// resources/views/pages/contact.blade.php

use function Livewire\Volt\{state, rules};

state([
    'name' => '',
    'email' => '',
    'message' => ''
]);

rules([
    'name' => 'required|min:3',
    'email' => 'required|email',
    'message' => 'required|min:10'
]);

$submit = function () {
    $this->validate();
    
    // Logica di invio
    session()->flash('success', 'Messaggio inviato con successo!');
    
    $this->reset();
};

?>

<x-layout>
    <form wire:submit="submit">
        <div>
            <label>Nome</label>
            <input type="text" wire:model="name">
            @error('name') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Email</label>
            <input type="email" wire:model="email">
            @error('email') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Messaggio</label>
            <textarea wire:model="message"></textarea>
            @error('message') <span>{{ $message }}</span> @enderror
        </div>

        <button type="submit">Invia</button>
    </form>
</x-layout>
```

### 3. Lista Dinamica con Filtri

```php
<?php
// resources/views/pages/users.blade.php

use function Livewire\Volt\{state, computed};
use App\Models\User;

state(['search' => '']);

$users = computed(function () {
    return User::query()
        ->when($this->search, fn($query) => 
            $query->where('name', 'like', "%{$this->search}%")
        )
        ->latest()
        ->get();
});

?>

<div>
    <input type="text" 
           wire:model.live="search" 
           placeholder="Cerca utenti...">

    <ul>
        @foreach($users as $user)
            <li>{{ $user->name }}</li>
        @endforeach
    </ul>
</div>
```

## Layout e Componenti Condivisi

### 1. Layout Base

```php
// resources/views/components/layout.blade.php

<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Volt Example' }}</title>
    @livewireStyles
</head>
<body>
    <nav>
        <!-- Navigazione -->
    </nav>

    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
```

### 2. Componente di Navigazione

```php
<?php
// resources/views/components/nav.blade.php

use function Livewire\Volt\{state};

state(['isOpen' => false]);

$toggle = fn () => $this->isOpen = !$this->isOpen;

?>

<nav>
    <button wire:click="toggle">
        Menu
    </button>

    <div x-show="isOpen">
        <a href="/">Home</a>
        <a href="/contact">Contatti</a>
        <a href="/users">Utenti</a>
    </div>
</nav>
```

## Testing

### 1. Test Funzionali

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Volt\Volt;

class ContactFormTest extends TestCase
{
    /** @test */
    public function it_validates_form_fields()
    {
        Volt::test('contact')
            ->set('name', '')
            ->set('email', 'invalid-email')
            ->set('message', '')
            ->call('submit')
            ->assertHasErrors(['name', 'email', 'message']);
    }

    /** @test */
    public function it_submits_valid_form()
    {
        Volt::test('contact')
            ->set('name', 'Mario Rossi')
            ->set('email', 'mario@example.com')
            ->set('message', 'Messaggio di test')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSessionHas('success');
    }
}
```

## Best Practices dall'Esempio

1. **Organizzazione File**
   - Separare i componenti per funzionalità
   - Utilizzare sottocartelle per organizzare i componenti
   - Mantenere i layout separati dai componenti

2. **Gestione Stato**
   - Utilizzare `state()` per proprietà reattive
   - Implementare `computed()` per dati derivati
   - Gestire validazioni con `rules()`

3. **Performance**
   - Utilizzare `wire:model.live` con debounce per ricerche
   - Implementare paginazione per liste lunghe
   - Ottimizzare query del database

4. **Testing**
   - Testare validazioni form
   - Verificare comportamenti interattivi
   - Testare computed properties

## Riferimenti

- [Repository Esempio](https://github.com/jasonlbeggs/laravel-news-volt-folio-example)
- [Documentazione Laravel Volt](https://livewire.laravel.com/project_docs/volt)
- [Documentazione Laravel Folio](https://github.com/laravel/folio)
- [Livewire](https://livewire.laravel.com) 
