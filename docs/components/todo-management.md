# Gestione Todo con Volt e Folio

## Introduzione

Questa guida illustra come implementare un sistema di gestione Todo nel modulo CMS utilizzando Laravel Volt e Folio, basandosi sull'approccio semplificato e funzionale di Nuno Maduro.

## Struttura Base

### 1. Modello Todo
```php
namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Todo extends Model
{
    use \Modules\Xot\Models\Traits\HasXotFactory;

    protected $fillable = [
        'description',
        'completed',
        'user_id',
        'due_date',
        'priority',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'datetime',
        'priority' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

### 2. Migrazione
```php
public function up()
{
    Schema::create('todos', function (Blueprint $table) {
        $table->id();
        $table->string('description');
        $table->boolean('completed')->default(false);
        $table->foreignId('user_id')->constrained();
        $table->dateTime('due_date')->nullable();
        $table->integer('priority')->default(0);
        $table->timestamps();
    });
}
```

## Implementazione Volt

### 1. Lista Todo Base
```php
<?php

// resources/views/pages/todos/index.blade.php
use function Livewire\Volt\{state, computed};
use Modules\Cms\Models\Todo;

state([
    'description' => '',
    'newTodoPriority' => 0,
]);

$todos = computed(function () {
    return Todo::query()
        ->where('user_id', auth()->id())
        ->orderBy('priority', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();
});

$addTodo = function () {
    $this->validate([
        'description' => 'required|min:3',
    ]);

    Todo::create([
        'description' => $this->description,
        'user_id' => auth()->id(),
        'priority' => $this->newTodoPriority,
    ]);

    $this->description = '';
    $this->newTodoPriority = 0;
};

$toggleComplete = function (Todo $todo) {
    $todo->update([
        'completed' => !$todo->completed,
    ]);
};

$deleteTodo = function (Todo $todo) {
    $todo->delete();
};
?>

<x-layouts.cms>
    <div class="max-w-2xl mx-auto py-6">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h2 class="text-lg font-medium mb-6">I Tuoi Todo</h2>

            <form wire:submit="addTodo" class="space-y-4">
                <div class="flex gap-4">
                    <x-cms::input-field
                        wire:model="description"
                        label="Nuovo Todo"
                        placeholder="Cosa devi fare?"
                        class="flex-1"
                    />

                    <x-cms::select-field
                        wire:model="newTodoPriority"
                        label="Priorità"
                        :options="[
                            0 => 'Bassa',
                            1 => 'Media',
                            2 => 'Alta',
                        ]"
                    />
                </div>

                <div class="flex justify-end">
                    <x-cms::button type="submit">
                        Aggiungi
                    </x-cms::button>
                </div>
            </form>

            <div class="mt-8 space-y-4">
                @foreach($todos as $todo)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-4">
                            <x-cms::checkbox-field
                                wire:model.live="todo.completed"
                                wire:click="toggleComplete({{ $todo->id }})"
                            />

                            <span class="{{ $todo->completed ? 'line-through text-gray-500' : '' }}">
                                {{ $todo->description }}
                            </span>

                            @if($todo->priority > 0)
                                <span class="px-2 py-1 text-xs rounded-full {{ $todo->priority === 2 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ['', 'Media', 'Alta'][$todo->priority] }}
                                </span>
                            @endif
                        </div>

                        <x-cms::button
                            wire:click="deleteTodo({{ $todo->id }})"
                            variant="danger"
                            size="sm"
                        >
                            Elimina
                        </x-cms::button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.cms>
```

### 2. Versione Avanzata con Filtri
```php
<?php

// resources/views/pages/todos/advanced.blade.php
use function Livewire\Volt\{state, computed};
use Modules\Cms\Models\Todo;

state([
    'description' => '',
    'newTodoPriority' => 0,
    'filter' => 'all', // all, pending, completed
    'priorityFilter' => 'all', // all, high, medium, low
]);

$filteredTodos = computed(function () {
    return Todo::query()
        ->where('user_id', auth()->id())
        ->when($this->filter === 'pending', fn($q) => $q->where('completed', false))
        ->when($this->filter === 'completed', fn($q) => $q->where('completed', true))
        ->when($this->priorityFilter === 'high', fn($q) => $q->where('priority', 2))
        ->when($this->priorityFilter === 'medium', fn($q) => $q->where('priority', 1))
        ->when($this->priorityFilter === 'low', fn($q) => $q->where('priority', 0))
        ->orderBy('priority', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();
});

$stats = computed(function () {
    $todos = Todo::where('user_id', auth()->id());

    return [
        'total' => $todos->count(),
        'completed' => $todos->where('completed', true)->count(),
        'pending' => $todos->where('completed', false)->count(),
    ];
});
?>

<x-layouts.cms>
    <div class="max-w-4xl mx-auto py-6">
        <!-- Statistiche -->
        <div class="grid grid-cols-3 gap-6 mb-6">
            <x-cms::stat-card
                label="Totale"
                :value="$stats['total']"
            />
            <x-cms::stat-card
                label="Completati"
                :value="$stats['completed']"
                class="text-green-600"
            />
            <x-cms::stat-card
                label="In Sospeso"
                :value="$stats['pending']"
                class="text-yellow-600"
            />
        </div>

        <!-- Filtri -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <div class="flex gap-4">
                <x-cms::select-field
                    wire:model.live="filter"
                    label="Stato"
                    :options="[
                        'all' => 'Tutti',
                        'pending' => 'In Sospeso',
                        'completed' => 'Completati',
                    ]"
                />

                <x-cms::select-field
                    wire:model.live="priorityFilter"
                    label="Priorità"
                    :options="[
                        'all' => 'Tutte',
                        'high' => 'Alta',
                        'medium' => 'Media',
                        'low' => 'Bassa',
                    ]"
                />
            </div>
        </div>

        <!-- Form e Lista Todo -->
        <!-- ... (stesso codice della versione base) ... -->
    </div>
</x-layouts.cms>
```

## Ottimizzazioni

### 1. Cache dei Todo
```php
$filteredTodos = computed(function () {
    $cacheKey = "todos.{$this->filter}.{$this->priorityFilter}.".auth()->id();

    return cache()->remember($cacheKey, now()->addMinutes(5), function () {
        return Todo::query()
            ->where('user_id', auth()->id())
            // ... filtri ...
            ->get();
    });
});
```

### 2. Batch Actions
```php
state(['selected' => []]);

$completeSelected = function () {
    Todo::whereIn('id', $this->selected)
        ->update(['completed' => true]);

    $this->selected = [];
};

$deleteSelected = function () {
    Todo::whereIn('id', $this->selected)->delete();
    $this->selected = [];
};
```

## Testing

### 1. Feature Tests
```php
namespace Tests\Feature\Todos;

use Tests\TestCase;
use Modules\Cms\Models\Todo;
use Livewire\Volt\Volt;

class TodoManagementTest extends TestCase
{
    /** @test */
    public function it_can_create_todo()
    {
        $this->actingAs($user = User::factory()->create());

        Volt::test('todos.index')
            ->set('description', 'Test Todo')
            ->set('newTodoPriority', 1)
            ->call('addTodo');

        $this->assertDatabaseHas('todos', [
            'description' => 'Test Todo',
            'user_id' => $user->id,
            'priority' => 1,
        ]);
    }

    /** @test */
    public function it_can_toggle_todo_status()
    {
        $todo = Todo::factory()->create(['completed' => false]);

        Volt::test('todos.index')
            ->call('toggleComplete', $todo)
            ->assertSet('todos.0.completed', true);
    }
}
```

### 2. Browser Tests
```php
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TodoTest extends DuskTestCase
{
    /** @test */
    public function it_can_filter_todos()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($user)
                   ->visit('/cms/todos/advanced')
                   ->select('@filter', 'completed')
                   ->waitForText('Todo Completato')
                   ->assertSee('Todo Completato')
                   ->assertDontSee('Todo In Sospeso');
        });
    }
}
```

## Best Practices

### 1. Validazione
```php
namespace Modules\Cms\Rules;

use Illuminate\Contracts\Validation\Rule;

class TodoPriorityRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return in_array($value, [0, 1, 2]);
    }

    public function message(): string
    {
        return 'La priorità deve essere bassa (0), media (1) o alta (2).';
    }
}
```

### 2. Eventi e Notifiche
```php
class TodoCreated extends Notification
{
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nuovo Todo Creato')
            ->line("Hai creato un nuovo todo: {$this->todo->description}")
            ->line("Priorità: {$this->getPriorityText()}")
            ->action('Vedi Todos', route('cms.todos.index'));
    }
}
```

## Risorse Utili

### Documentation
- [Todo App Example by Nuno Maduro](https://nunomaduro.com/todo_application_with_laravel_folio_and_volt)
- [Laravel Volt](https://livewire.laravel.com/docs/volt)
- [Laravel Folio](https://laravel.com/docs/folio)
