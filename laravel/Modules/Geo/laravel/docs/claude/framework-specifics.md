# 🎨 Framework Specifics - Filament 4, Livewire 3, Tailwind

> **FONDAMENTALE**: Conoscere le specifiche dei framework utilizzati evita errori comuni e sfrutta al meglio le funzionalità.

## 🎯 Filament 4

### Novità Fondamentali da Filament 3
- **Grid/Section/Fieldset**: Richiedono `->columnSpanFull()` per larghezza totale
- **unique()**: Ora ha `ignoreRecord=true` di default (era false in v3)
- **PHP 8.2+**: Obbligatorio per Filament 4
- **make()**: Accetta `?string $name = null` invece di `string`
- **Table filters**: `deferFilters()` è ora il comportamento default
- **Paginazione**: Opzione 'all' non più disponibile di default
- **Radio::inline()**: Mette solo i radio inline, non anche l'etichetta

### Resource Pattern Corretto
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms;
use Filament\Tables;
use Modules\MyModule\Models\MyModel;

class MyResource extends XotBaseResource
{
    protected static ?string $model = MyModel::class;
    
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                // ✅ make() accetta ?string
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                
                // ✅ unique() con ignoreRecord default
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->unique()
                    // Non serve più: ->unique(ignoreRecord: true)
                
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => __('my-module::statuses.active'),
                        'inactive' => __('my-module::statuses.inactive'),
                    ]),
                
                // ✅ Grid richiede columnSpanFull per larghezza totale
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('field1'),
                        Forms\Components\TextInput::make('field2'),
                    ])
                    ->columnSpanFull(), // IMPORTANTE in v4
            ]);
    }
}
```

### List Pages con getTableColumns()
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Filament\Resources\MyResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Filament\Tables;
use Filament\Tables\Table;

class ListMyRecords extends XotBaseListRecords
{
    // ✅ SOLO qui implementare getTableColumns()
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            
            // ✅ TextColumn::make()->badge() non BadgeColumn
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'active' => 'success',
                    'inactive' => 'danger',
                }),
            
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
    
    protected function getTableFilters(): array
    {
        return [
            // ✅ deferFilters() è default
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'active' => __('my-module::statuses.active'),
                    'inactive' => __('my-module::statuses.inactive'),
                ]),
        ];
    }
    
    protected function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ];
    }
}
```

### Custom Actions Pattern
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Filament\Actions;

use Filament\Actions\Action;
use Filament\Support\Colors\Color;
use Modules\MyModule\Actions\ProcessMyModelAction;

class ProcessMyModelAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->label(__('my-module::actions.process.label'))
            ->icon('heroicon-o-cog')
            ->color(Color::Amber)
            ->requiresConfirmation()
            ->modalHeading(__('my-module::actions.process.modal.heading'))
            ->modalDescription(__('my-module::actions.process.modal.description'))
            ->action(function (array $data, $record) {
                app(ProcessMyModelAction::class)->execute($record, $data);
            })
            ->successNotificationTitle(__('my-module::actions.process.success'));
    }
}
```

---

## 🔄 Livewire 3

### Cambiamenti Fondamentali da Livewire 2
- **Namespace**: `App\Livewire` invece di `App\Http\Livewire`
- **wire:model**: Deferred di default, usare `wire:model.live` per real-time
- **Dispatch**: `$this->dispatch()` invece di `emit()` o `dispatchBrowserEvent()`
- **Alpine**: In incluso automaticamente, non serve includerlo manualmente
- **Layout path**: `components.layouts.app` invece di `layouts.app`

### Component Pattern Corretto
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Modules\MyModule\Models\MyModel;

class MyComponent extends Component
{
    public string $search = '';
    public int $perPage = 10;
    
    // ✅ Computed property
    #[Computed]
    public function models(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return MyModel::query()
            ->when($this->search, fn ($query, $search) => 
                $query->where('name', 'like', "%{$search}%")
            )
            ->paginate($this->perPage);
    }
    
    // ✅ Event listener
    #[On('refresh-models')]
    public function refresh(): void
    {
        $this->resetPage();
    }
    
    public function delete(int $id): void
    {
        $model = MyModel::findOrFail($id);
        $model->delete();
        
        // ✅ Dispatch eventi
        $this->dispatch('model-deleted', id: $id);
    }
    
    public function render(): \Illuminate\View\View
    {
        return view('my-module::livewire.my-component');
    }
}
```

### Blade Template Corretto
```blade
<div>
    {{-- ✅ wire:loading states --}}
    <div wire:loading wire:target="search">
        <div>Searching...</div>
    </div>
    
    {{-- ✅ wire:model.live per real-time --}}
    <input 
        type="text" 
        wire:model.live.debounce.300ms="search"
        placeholder="{{ __('Search...') }}"
    >
    
    {{-- ✅ wire:key in loops --}}
    <div class="space-y-2">
        @foreach ($this->models as $model)
            <div wire:key="model-{{ $model->id }}" class="border p-4">
                <h3>{{ $model->name }}</h3>
                <p>{{ $model->description }}</p>
                
                <button 
                    wire:click="delete({{ $model->id }})"
                    wire:confirm="Are you sure?"
                    class="text-red-600"
                >
                    Delete
                </button>
            </div>
        @endforeach
    </div>
    
    {{-- ✅ Pagination --}}
    {{ $this->models->links() }}
</div>
```

### Testing Livewire
```php
<?php

declare(strict_types=1);

use Modules\MyModule\Livewire\MyComponent;
use Modules\MyModule\Models\MyModel;
use Livewire\Livewire;

it('can search models', function () {
    $models = MyModel::factory()->count(3)->create();
    
    Livewire::test(MyComponent::class)
        ->assertSee($models->first()->name)
        ->set('search', $models->first()->name)
        ->assertSee($models->first()->name)
        ->assertDontSee($models->skip(1)->first()->name);
});

it('can delete model', function () {
    $model = MyModel::factory()->create();
    
    Livewire::test(MyComponent::class)
        ->call('delete', $model->id)
        ->assertDispatched('model-deleted', id: $model->id);
    
    $this->assertModelMissing($model);
});
```

---

## 🎨 Tailwind CSS

### Utilities Comuni in PTVX
```blade
{{-- ✅ Layout --}}
<div class="container mx-auto px-4">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
<div class="flex flex-col space-y-4">

{{-- ✅ Cards --}}
<div class="bg-white rounded-lg shadow-md p-6">
<div class="border border-gray-200 rounded-lg">

{{-- ✅ Buttons --}}
<button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
<button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">

{{-- ✅ Forms --}}
<input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
<textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

{{-- ✅ Typography --}}
<h1 class="text-2xl font-bold text-gray-900">
<p class="text-gray-600 leading-relaxed">
<span class="text-sm text-gray-500">
```

### Responsive Design
```blade
{{-- ✅ Mobile-first approach --}}
<div class="w-full md:w-1/2 lg:w-1/3">
<div class="block sm:hidden md:block lg:hidden">

{{-- ✅ Spacing responsive --}}
<div class="p-4 sm:p-6 lg:p-8">
<div class="space-y-2 sm:space-y-4 lg:space-y-6">

{{-- ✅ Text responsive --}}
<h1 class="text-lg sm:text-xl lg:text-2xl">
<p class="text-sm sm:text-base lg:text-lg">
```

---

## 🧪 Testing Frameworks

### Pest Testing Pattern
```php
<?php

declare(strict_types=1);

// ✅ Dataset per test multipli
it('validates email formats', function ($email, $isValid) {
    $result = $this->emailValidator->isValid($email);
    
    expect($result)->toBe($isValid);
})->with([
    ['test@example.com', true],
    ['invalid-email', false],
    ['test@.com', false],
]);

// ✅ Higher-order tests
it('can create user')
    ->expect(fn () => app(CreateUserAction::class)->execute($userData))
    ->toBeInstanceOf(User::class);

// ✅ Group tests
describe('user management', function () {
    it('can create user', function () {
        // test creation
    });
    
    it('can update user', function () {
        // test update
    });
    
    it('can delete user', function () {
        // test deletion
    });
});
```

---

## 📋 Framework Checklist

### Filament 4
- [ ] Resources estendono XotBaseResource
- [ ] getTableColumns() solo in List pages
- [ ] Grid/Section usano columnSpanFull()
- [ ] TextColumn::make()->badge() non BadgeColumn
- [ ] unique() con configurazione default
- [ ] make() accetta ?string

### Livewire 3
- [ ] Namespace App\Livewire
- [ ] wire:model.live per real-time
- [ ] $this->dispatch() per eventi
- [ ] wire:key in loops
- [ ] wire:loading states

### Tailwind CSS
- [ ] Mobile-first approach
- [ ] Utility classes consistenti
- [ ] Responsive design
- [ ] Component-based styling

### Testing
- [ ] Test Pest per logica business
- [ ] Feature test per flussi utente
- [ ] Livewire test per componenti
- [ ] Coverage adeguato

---

## 📚 Riferimenti Correlati

- [Architecture Rules](architecture-rules.md) - Pattern architetturali
- [Code Quality](code-quality.md) - Testing e quality tools
- [Core Rules](core.md) - Regole fondamentali

---

**Versione**: 3.0 (Refactor DRY + KISS)  
**Priorità**: ⚡ ALTA - Framework specifics obbligatori  
**Aggiornamento**: Dicembre 2025

> **💡 Principio**: "Conoscere le specifiche del framework è fondamentale per sfruttarlo al meglio ed evitare anti-pattern."