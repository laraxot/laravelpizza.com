# Integrazione Volt e Folio nel Modulo CMS

## Introduzione

Questa guida spiega come integrare Laravel Volt e Folio nel modulo CMS, basandosi sulle best practices e pattern implementativi del progetto Laravel News Volt Folio Example.

## Struttura del Progetto

### 1. Organizzazione dei File
```
Modules/Cms/
  ├─ resources/
  │   └─ views/
  │       ├─ components/    # Componenti Blade riutilizzabili
  │       ├─ layouts/       # Layout base
  │       └─ pages/         # Pagine Folio
  ├─ src/
  │   ├─ Http/
  │   │   └─ Middleware/   # Middleware personalizzati
  │   └─ View/
  │       └─ Components/   # Componenti PHP
  └─ routes/
      └─ web.php           # Route tradizionali (se necessarie)
```

### 2. Configurazione Base
```php
// Modules/Cms/Providers/CmsServiceProvider.php
public function boot()
{
    $this->loadViewsFrom(__DIR__.'/../resources/views', 'cms');
    
    // Registrazione componenti Volt
    Volt::mount([
        __DIR__.'/../resources/views/pages',
        __DIR__.'/../resources/views/components',
    ]);
}
```

## Componenti Volt

### 1. Componente Base
```php
<?php

// resources/views/components/data-table.blade.php
use function Livewire\Volt\{state, computed};

state([
    'data' => [],
    'sortField' => 'id',
    'sortDirection' => 'asc',
]);

$sort = function ($field) {
    $this->sortDirection = $this->sortField === $field
        ? $this->sortDirection === 'asc' ? 'desc' : 'asc'
        : 'asc';
    
    $this->sortField = $field;
};

$sortedData = computed(function () {
    return collect($this->data)
        ->sortBy($this->sortField, SORT_REGULAR, $this->sortDirection === 'desc');
});
?>

<div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                @foreach($columns as $column)
                    <th wire:click="sort('{{ $column }}')" class="cursor-pointer">
                        {{ ucfirst($column) }}
                        @if($sortField === $column)
                            <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($sortedData as $item)
                <tr>
                    @foreach($columns as $column)
                        <td>{{ $item[$column] }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
```

### 2. Componente con Form
```php
<?php

// resources/views/components/search-form.blade.php
use function Livewire\Volt\{state, rules};

state([
    'query' => '',
    'results' => [],
]);

rules([
    'query' => 'required|min:3',
]);

$search = function () {
    $this->validate();
    
    $this->results = Model::search($this->query)->get();
};

$reset = function () {
    $this->query = '';
    $this->results = [];
};
?>

<div>
    <form wire:submit="search" class="space-y-4">
        <x-cms::input-field
            wire:model.live="query"
            label="Cerca"
            :error="$errors->first('query')"
        />
        
        <x-cms::button type="submit">
            Cerca
        </x-cms::button>
        
        <x-cms::button
            type="button"
            wire:click="reset"
            variant="secondary"
        >
            Reset
        </x-cms::button>
    </form>
    
    @if($results)
        <div class="mt-4">
            <!-- Risultati -->
        </div>
    @endif
</div>
```

## Pagine Folio

### 1. Layout Base
```php
// resources/views/layouts/cms.blade.php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('cms.name') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <x-cms::navigation />
        
        <main class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
```

### 2. Pagina con Volt
```php
<?php

// resources/views/pages/dashboard.blade.php
use function Laravel\Folio\{name, middleware};
use function Livewire\Volt\{state, computed};

name('cms.dashboard');
middleware(['web', 'auth']);

state([
    'stats' => [],
]);

$mount = function () {
    $this->stats = [
        'users' => User::count(),
        'posts' => Post::count(),
        'comments' => Comment::count(),
    ];
};

$refreshStats = function () {
    $this->mount();
};

?>

<x-layouts.cms>
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Dashboard</h1>
            
            <x-cms::button
                wire:click="refreshStats"
                wire:loading.attr="disabled"
            >
                Aggiorna
            </x-cms::button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($stats as $key => $value)
                <x-cms::stat-card
                    :label="ucfirst($key)"
                    :value="$value"
                />
            @endforeach
        </div>
    </div>
</x-layouts.cms>
```

## Best Practices

### 1. Organizzazione del Codice
- Utilizzare namespace appropriati per i componenti
- Separare la logica di business dai componenti UI
- Mantenere i componenti piccoli e focalizzati
- Utilizzare traits per funzionalità condivise

### 2. Performance
```php
// Esempio di trait per ottimizzazione query
trait WithQueryOptimization
{
    protected function optimizeQuery($query)
    {
        return $query->when($this->search, function ($q) {
            $q->where('name', 'like', "%{$this->search}%");
        })->when($this->filters, function ($q) {
            foreach ($this->filters as $field => $value) {
                $q->where($field, $value);
            }
        });
    }
}
```

### 3. Riutilizzabilità
```php
// Esempio di componente riutilizzabile
class SortableComponent
{
    public $sortField = 'id';
    public $sortDirection = 'asc';
    
    public function sort($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    protected function applySorting($query)
    {
        return $query->orderBy($this->sortField, $this->sortDirection);
    }
}
```

## Testing

### 1. Test dei Componenti
```php
namespace Tests\Unit\Components;

use Tests\TestCase;
use Livewire\Volt\Volt;

class DataTableTest extends TestCase
{
    /** @test */
    public function it_can_sort_data()
    {
        Volt::test('data-table', ['data' => [
            ['id' => 2, 'name' => 'B'],
            ['id' => 1, 'name' => 'A'],
        ]])
        ->assertSee('A')
        ->assertSee('B')
        ->call('sort', 'name')
        ->assertSeeInOrder(['A', 'B']);
    }
}
```

### 2. Test delle Pagine
```php
namespace Tests\Feature\Pages;

use Tests\TestCase;

class DashboardTest extends TestCase
{
    /** @test */
    public function it_displays_correct_stats()
    {
        $this->actingAs($user = User::factory()->create());
        
        Post::factory()->count(3)->create();
        Comment::factory()->count(5)->create();
        
        $this->get(route('cms.dashboard'))
            ->assertSuccessful()
            ->assertSee('3')  // posts count
            ->assertSee('5'); // comments count
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

#### Hydration Errors
```php
// Soluzione: Assicurarsi che i dati siano serializzabili
protected $casts = [
    'data' => 'array',
    'settings' => 'collection',
];
```

#### Prestazioni
```php
// Soluzione: Implementare caching
public function mountDashboard()
{
    $this->stats = cache()->remember('dashboard.stats', now()->addMinutes(5), function () {
        return [
            'users' => User::count(),
            'posts' => Post::count(),
            'comments' => Comment::count(),
        ];
    });
}
```

#### Aggiornamenti UI
```php
// Soluzione: Utilizzare wire:poll per aggiornamenti automatici
<div wire:poll.5s>
    <!-- Contenuto da aggiornare -->
</div>
```

## Risorse Utili

### Documentation
- [Laravel Volt Examples](https://github.com/jasonlbeggs/laravel-news-volt-folio-example)
- [Livewire Best Practices](https://livewire.laravel.com/docs/best-practices)
- [Laravel Folio Patterns](https://laravel.com/docs/folio) 
