# Architettura Frontend

## Tecnologie Principali

### 1. Laravel Volt
- Gestione dello stato reattivo
- Componenti Livewire
- Integrazione con Blade

### 2. Laravel Folio
- Routing basato su file
- Organizzazione delle pagine
- Middleware e autorizzazioni

### 3. Filament
- Componenti UI riutilizzabili
- Form e tabelle
- Dashboard e amministrazione

## Struttura del Frontend

### 1. Organizzazione
```
resources/
├── js/              # Script JavaScript
├── css/            # Stili CSS
└── views/          # Viste Blade
    ├── pages/      # Pagine Folio
    ├── components/ # Componenti Volt
    └── layouts/    # Layout principali
```

### 2. Componenti
```php
// Esempio di componente Volt
<?php

use function Livewire\Volt\{state, mount};

state(['count' => 0]);

$increment = fn () => $this->count++;

?>

<div>
    <h1>{{ $count }}</h1>
    <button wire:click="increment">Incrementa</button>
</div>
```

### 3. Pagine
```php
// Esempio di pagina Folio
<?php

use App\Models\Post;
use function Laravel\Folio\name;

name('posts.show');

$post = Post::findOrFail($id);

?>

<x-app-layout>
    <x-slot name="header">
        <h2>{{ $post->title }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ $post->content }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

## Best Practices

### 1. Gestione dello Stato
- Utilizzare Volt per lo stato locale
- Implementare store centralizzati quando necessario
- Evitare duplicazione dello stato

### 2. Performance
- Implementare lazy loading
- Ottimizzare le query
- Utilizzare la cache quando appropriato

### 3. Sicurezza
- Validare tutti gli input
- Implementare CSRF protection
- Utilizzare middleware di autenticazione

## Collegamenti

- [Struttura dei Temi](themes-structure.md)
- [Standard del Codice](code-standards.md)
- [Regole di Documentazione](documentation-rules.md) 
