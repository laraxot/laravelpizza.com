# Applicazione Todo con Laravel Folio e Volt

Questa guida spiega come implementare un'applicazione Todo utilizzando Laravel Folio per il routing basato su file e Volt per la gestione dello stato e della reattività.

## Prerequisiti

- Laravel 10+
- Laravel Folio
- Laravel Volt
- PHP 8.1+
- SQLite (o altro database supportato)

## Installazione e Setup

### 1. Creazione del Progetto

```bash
laravel new todo-app
cd todo-app
```

### 2. Installazione Pacchetti

```bash
composer require laravel/folio livewire/livewire livewire/volt
```

### 3. Installazione Folio e Volt

```bash
php artisan folio:install
php artisan volt:install
```

## Struttura del Database

### 1. Creazione Model e Migration

```bash
php artisan make:model Todo -m
```

### 2. Migration Todo

```php
public function up()
{
    Schema::create('todos', function (Blueprint $table) {
        $table->id();
        $table->string('description');
        $table->boolean('completed')->default(false);
        $table->timestamps();
    });
}
```

### 3. Model Todo

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Todo extends Model
{
    use \Modules\Xot\Models\Traits\HasXotFactory;

    protected $fillable = [
        'description',
        'completed'
    ];

    protected $casts = [
        'completed' => 'boolean'
    ];
}
```

## Implementazione con Folio e Volt

### 1. Creazione Pagina Todos

```bash
php artisan make:folio todos
```

### 2. Implementazione Vista Todo

```php
<?php
// resources/views/pages/todos.blade.php

use function Livewire\Volt\{state, computed};
use App\Models\Todo;

state([
    'description' => '',
    'filter' => 'all'
]);

$todos = computed(function () {
    return match($this->filter) {
        'completed' => Todo::where('completed', true)->get(),
        'active' => Todo::where('completed', false)->get(),
        default => Todo::all(),
    };
});

$addTodo = function () {
    $this->validate([
        'description' => 'required|min:3'
    ]);

    Todo::create([
        'description' => $this->description
    ]);

    $this->description = '';
};

$toggleTodo = function (Todo $todo) {
    $todo->update([
        'completed' => !$todo->completed
    ]);
};

$deleteTodo = function (Todo $todo) {
    $todo->delete();
};

$clearCompleted = function () {
    Todo::where('completed', true)->delete();
};
?>

<div class="max-w-2xl mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Todo List</h1>

    @volt
    <div>
        <!-- Form Aggiunta Todo -->
        <form wire:submit="addTodo" class="mb-6">
            <div class="flex gap-2">
                <input 
                    type="text" 
                    wire:model="description" 
                    placeholder="Cosa devi fare?"
                    class="flex-1 px-4 py-2 border rounded"
                >
                <button 
                    type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                >
                    Aggiungi
                </button>
            </div>
            @error('description') 
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </form>

        <!-- Filtri -->
        <div class="flex gap-4 mb-4">
            <button 
                wire:click="$set('filter', 'all')"
                class="@if($filter === 'all') font-bold @endif"
            >
                Tutti
            </button>
            <button 
                wire:click="$set('filter', 'active')"
                class="@if($filter === 'active') font-bold @endif"
            >
                Attivi
            </button>
            <button 
                wire:click="$set('filter', 'completed')"
                class="@if($filter === 'completed') font-bold @endif"
            >
                Completati
            </button>
        </div>

        <!-- Lista Todo -->
        <ul class="space-y-2">
            @foreach ($this->todos as $todo)
                <li class="flex items-center gap-2 p-2 border rounded">
                    <input 
                        type="checkbox" 
                        wire:click="toggleTodo({{ $todo->id }})"
                        @checked($todo->completed)
                    >
                    <span class="flex-1 @if($todo->completed) line-through text-gray-500 @endif">
                        {{ $todo->description }}
                    </span>
                    <button 
                        wire:click="deleteTodo({{ $todo->id }})"
                        class="text-red-500 hover:text-red-700"
                    >
                        Elimina
                    </button>
                </li>
            @endforeach
        </ul>

        @if($this->todos->where('completed', true)->count() > 0)
            <div class="mt-4">
                <button 
                    wire:click="clearCompleted"
                    class="text-gray-500 hover:text-gray-700"
                >
                    Elimina completati
                </button>
            </div>
        @endif
    </div>
    @endvolt
</div>
```

## Funzionalità Implementate

1. **Gestione Todo**
   - Aggiunta nuovo todo
   - Toggle completamento
   - Eliminazione singolo todo
   - Eliminazione tutti i todo completati

2. **Filtri**
   - Visualizzazione tutti i todo
   - Visualizzazione solo todo attivi
   - Visualizzazione solo todo completati

3. **Validazione**
   - Validazione input descrizione
   - Gestione errori
   - Feedback utente

4. **UI/UX**
   - Design responsive
   - Feedback visivo stato todo
   - Interazioni intuitive

## Best Practices

### 1. Organizzazione del Codice

- Separazione logica di stato e azioni
- Utilizzo di computed properties
- Naming chiaro e descrittivo

### 2. Performance

- Utilizzo di wire:model.live per ricerca
- Ottimizzazione query database
- Gestione efficiente degli stati

### 3. User Experience

- Feedback immediato azioni
- Validazione in tempo reale
- Interfaccia intuitiva

### 4. Testing

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Todo;
use Livewire\Volt\Volt;

class TodoTest extends TestCase
{
    /** @test */
    public function it_can_create_todo()
    {
        Volt::test('todos')
            ->set('description', 'Nuovo todo')
            ->call('addTodo')
            ->assertHasNoErrors()
            ->assertSet('description', '');

        $this->assertDatabaseHas('todos', [
            'description' => 'Nuovo todo'
        ]);
    }

    /** @test */
    public function it_requires_description()
    {
        Volt::test('todos')
            ->set('description', '')
            ->call('addTodo')
            ->assertHasErrors(['description']);
    }

    /** @test */
    public function it_can_toggle_todo()
    {
        $todo = Todo::factory()->create(['completed' => false]);

        Volt::test('todos')
            ->call('toggleTodo', $todo)
            ->assertOk();

        $this->assertTrue($todo->fresh()->completed);
    }
}
```

## Troubleshooting

### Problemi Comuni

1. **Errori di Installazione**
   - Verificare versioni pacchetti
   - Pulire cache composer
   - Rigenerare autoload

2. **Problemi di Reattività**
   - Controllare wire:model
   - Verificare computed properties
   - Debug eventi Livewire

3. **Errori Database**
   - Verificare migration
   - Controllare fillable
   - Validare relazioni

## Riferimenti

- [Laravel Folio Documentation](https://github.com/laravel/folio)
- [Laravel Volt Documentation](https://livewire.laravel.com/project_docs/volt)
- [Livewire Documentation](https://livewire.laravel.com)
- [Articolo Originale di Nuno Maduro](https://nunomaduro.com/todo_application_with_laravel_folio_and_volt) 
