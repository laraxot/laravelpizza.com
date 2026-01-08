# Sviluppo Applicazioni Web con Laravel Volt

Questa guida spiega come sviluppare applicazioni web moderne utilizzando Laravel Volt, concentrandosi sulla creazione di componenti reattivi e sulla gestione dello stato dell'applicazione.

## Prerequisiti

- Laravel 10+
- Laravel Volt
- Livewire 3+
- PHP 8.1+
- Composer

## Installazione e Setup

### 1. Creazione Progetto Laravel

```bash
laravel new volt-app
cd volt-app
```

### 2. Installazione Volt e Dipendenze

```bash
composer require livewire/volt
php artisan volt:install
```

## Struttura Base dei Componenti Volt

### 1. Anatomia di un Componente Volt

```php
<?php

use function Livewire\Volt\{state, computed, mount, rules};

// Definizione dello stato
state([
    'name' => '',
    'email' => '',
    'isSubscribed' => false
]);

// Regole di validazione
rules([
    'name' => 'required|min:3',
    'email' => 'required|email'
]);

// Computed properties
$fullName = computed(function () {
    return "{$this->name} (Subscriber: " . ($this->isSubscribed ? 'Yes' : 'No') . ")";
});

// Lifecycle hooks
$mount = function ($initialName = '') {
    $this->name = $initialName;
};

// Metodi
$save = function () {
    $this->validate();
    
    // Logica di salvataggio
};
?>

<div>
    <form wire:submit="save">
        <div>
            <label>Nome</label>
            <input type="text" wire:model="name">
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Email</label>
            <input type="email" wire:model="email">
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>
                <input type="checkbox" wire:model="isSubscribed">
                Iscriviti alla newsletter
            </label>
        </div>

        <button type="submit">Salva</button>
    </form>

    <div>
        Nome Completo: {{ $this->fullName }}
    </div>
</div>
```

## Gestione dello Stato

### 1. State Management

```php
state([
    // Stato primitivo
    'counter' => 0,
    
    // Array
    'items' => [],
    
    // Oggetti
    'user' => [
        'name' => '',
        'email' => ''
    ]
]);
```

### 2. Computed Properties

```php
$filteredItems = computed(function () {
    return collect($this->items)
        ->filter(fn ($item) => $item['active'])
        ->values()
        ->all();
});

$totalCount = computed(function () {
    return count($this->filteredItems);
});
```

### 3. Actions e Eventi

```php
$increment = function () {
    $this->counter++;
    $this->dispatch('counter-updated', counter: $this->counter);
};

$addItem = function (string $name) {
    $this->items[] = [
        'id' => uniqid(),
        'name' => $name,
        'active' => true
    ];
};
```

## Form Handling

### 1. Validazione Form

```php
<?php

use function Livewire\Volt\{state, rules};

state([
    'form' => [
        'title' => '',
        'content' => '',
        'category_id' => null
    ]
]);

rules([
    'form.title' => 'required|min:3|max:255',
    'form.content' => 'required|min:10',
    'form.category_id' => 'required|exists:categories,id'
]);

$save = function () {
    $validated = $this->validate();
    
    $post = Post::create($validated['form']);
    
    session()->flash('message', 'Post creato con successo!');
    
    return redirect()->route('posts.show', $post);
};
?>

<form wire:submit="save">
    <div>
        <label>Titolo</label>
        <input type="text" wire:model="form.title">
        @error('form.title') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div>
        <label>Contenuto</label>
        <textarea wire:model="form.content"></textarea>
        @error('form.content') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div>
        <label>Categoria</label>
        <select wire:model="form.category_id">
            <option value="">Seleziona categoria</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @error('form.category_id') <span class="error">{{ $message }}</span> @enderror
    </div>

    <button type="submit">Salva Post</button>
</form>
```

## Interazioni Real-time

### 1. Polling e Aggiornamenti Automatici

```php
<?php

use function Livewire\Volt\{state, computed};

state([
    'notifications' => []
]);

// Aggiornamento automatico ogni 30 secondi
$polling = 30000;

$fetchNotifications = function () {
    $this->notifications = auth()->user()
        ->notifications()
        ->latest()
        ->take(5)
        ->get();
};

?>

<div wire:poll.30s="fetchNotifications">
    @foreach($notifications as $notification)
        <div class="notification">
            {{ $notification->data['message'] }}
        </div>
    @endforeach
</div>
```

### 2. Eventi e Comunicazione tra Componenti

```php
<?php

// Componente Emittente
$notifyParent = function () {
    $this->dispatch('item-selected', item: $this->selectedItem);
};

// Componente Ricevente
$listeners = [
    'item-selected' => 'handleItemSelected'
];

$handleItemSelected = function ($item) {
    $this->currentItem = $item;
};
?>
```

## Best Practices

### 1. Organizzazione del Codice

- Separare la logica in metodi piccoli e focalizzati
- Utilizzare computed properties per dati derivati
- Mantenere lo stato minimo necessario

```php
// Buona pratica
$filteredUsers = computed(function () {
    return $this->users
        ->filter(fn ($user) => $user->isActive())
        ->values();
});

// Da evitare
$getFilteredUsers = function () {
    $this->filteredUsers = $this->users
        ->filter(fn ($user) => $user->isActive())
        ->values();
};
```

### 2. Performance

- Utilizzare lazy loading per dati pesanti
- Implementare debounce per input frequenti
- Ottimizzare le query del database

```php
// Input con debounce
<input 
    type="text" 
    wire:model.live.debounce.300ms="search"
    placeholder="Cerca..."
>

// Lazy loading di relazioni
$users = computed(function () {
    return User::with('profile', 'posts')
        ->when($this->search, fn($query) => 
            $query->where('name', 'like', "%{$this->search}%")
        )
        ->paginate(10);
});
```

### 3. Testing

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Volt\Volt;

class UserFormTest extends TestCase
{
    /** @test */
    public function it_validates_required_fields()
    {
        Volt::test('user-form')
            ->set('form.name', '')
            ->set('form.email', '')
            ->call('save')
            ->assertHasErrors(['form.name', 'form.email']);
    }

    /** @test */
    public function it_creates_user_successfully()
    {
        Volt::test('user-form')
            ->set('form.name', 'Mario Rossi')
            ->set('form.email', 'mario@example.com')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'name' => 'Mario Rossi',
            'email' => 'mario@example.com'
        ]);
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Aggiornamenti UI non riflessi**
   - Verificare wire:model
   - Controllare computed properties
   - Debug eventi Livewire

2. **Errori di Validazione**
   - Controllare regole di validazione
   - Verificare nomi dei campi
   - Debug messaggi di errore

3. **Performance**
   - Ottimizzare query
   - Implementare caching
   - Ridurre payload

## Riferimenti

- [Laravel Volt Documentation](https://livewire.laravel.com/docs/volt)
- [Livewire Documentation](https://livewire.laravel.com)
- [Laravel Documentation](https://laravel.com/docs)
- [Articolo Originale di Moinuddin Chowdhury](https://medium.com/@moinuddinchowdhury/how-to-create-web-application-using-laravel-volt-the-magical-way-2145071046b2) 
