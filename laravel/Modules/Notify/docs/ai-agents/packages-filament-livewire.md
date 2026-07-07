# Filament 5 + Livewire 4 — API Reference

Riferimento completo per Filament 5.2.2, Livewire 4.1.4 e pacchetti correlati nel progetto Laraxot.

## Pacchetti installati

| Pacchetto | Versione |
|-----------|----------|
| filament/filament | 5.2.2 |
| filament/actions | 5.2.2 |
| filament/forms | 5.2.2 |
| filament/schemas | 5.2.2 (NUOVO) |
| filament/tables | 5.2.2 |
| filament/infolists | 5.2.2 |
| filament/widgets | 5.2.2 |
| filament/query-builder | 5.2.2 (NUOVO) |
| livewire/livewire | 4.1.4 |
| livewire/flux | 2.12.1 |
| livewire/volt | 1.10.3 |

---

## Regole critiche Filament 5 in Laraxot

### Regola 1: sempre XotBase (MAI Filament diretto)

| SBAGLIATO | CORRETTO |
|-----------|----------|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Widgets\ChartWidget` | `Modules\Xot\Filament\Widgets\XotBaseChartWidget` |

### Regola 2: getTableColumns() deve restituire array<string, Column>

```php
// CORRETTO: chiavi stringa obbligatorie
public function getTableColumns(): array
{
    return [
        'id' => TextColumn::make('id')->searchable()->sortable(),
        'name' => TextColumn::make('name')->searchable()->sortable(),
        'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
    ];
}

// SBAGLIATO: array_values() distrugge le chiavi
return array_values($columns); // ← Fatal: Filament cerca colonne per chiave stringa

// SBAGLIATO: chiavi numeriche
return [
    TextColumn::make('id'),  // chiave 0 (int) — sbagliato
];
```

### Regola 3: RawJs OBBLIGATORIO per JavaScript nelle opzioni chart

```php
use Filament\Support\RawJs;

// CORRETTO: funzioni JS non vengono quotate
protected function getOptions(): array | RawJs | null
{
    return RawJs::make(<<<'JS'
    {
        plugins: {
            datalabels: {
                formatter: function(value) {
                    return value.toFixed(2);
                }
            }
        }
    }
    JS);
}

// SBAGLIATO: le funzioni JS diventano stringhe quotate in JSON
return [
    'plugins' => [
        'datalabels' => [
            'formatter' => 'function(value) { return value.toFixed(2); }', // quoted!
        ]
    ]
];
```

### Regola 4: mai costruttori custom in widget Livewire

```php
// SBAGLIATO: Livewire non chiama __construct() con argomenti
public function __construct()
{
    $this->data = $this->loadExpensiveData(); // non eseguito
}

// CORRETTO: mount() o lazy init
public function mount(): void
{
    // Livewire chiama mount() dopo l'istanziazione
}

protected function getData(): array
{
    return $this->cachedData ??= $this->loadData(); // lazy init
}
```

### Regola 5: getFormSchema() deve essere PUBLIC

```php
// CORRETTO
public function getFormSchema(): array { return [...]; }

// SBAGLIATO
protected function getFormSchema(): array { return [...]; }
```

### Regola 6: getTableHeading() — return type corretto Filament 5

```php
use Illuminate\Contracts\Support\Htmlable;

// CORRETTO: Htmlable|string|null
public function getTableHeading(): Htmlable|string|null { ... }

// SBAGLIATO: ?string causa Fatal error in Filament 5
public function getTableHeading(): ?string { ... }
```

---

## Filament 5 — Novita rispetto a Filament 4

### 1. Pacchetto Schemas (nuovo)

Filament 5 unifica form e infolist nel pacchetto `filament/schemas`. Le classi `Schema` e `Component` sono ora il centro dell'architettura.

### 2. Query Builder (nuovo)

```php
use Filament\QueryBuilder\Forms\Components\RuleBuilder;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\QueryBuilder\Constraints\NumberConstraint;

RuleBuilder::make('rules')
    ->constraints([
        TextConstraint::make('name'),
        TextConstraint::make('email'),
        NumberConstraint::make('age'),
    ])
```

### 3. getOptions() — firma ufficiale

```php
// Firma ufficiale Filament 5 ChartWidget
protected function getOptions(): array | RawJs | null
```

### 4. Colonne tabella con chiavi stringa (obbligatorio)

In Filament 4 erano accettate anche chiavi numeriche. In Filament 5 le chiavi stringa sono obbligatorie per il lookup colonne.

---

## ChartWidget — Firma completa

```php
abstract class XotBaseChartWidget extends FilamentChartWidget
{
    // IMPLEMENTARE questi metodi
    protected function getType(): string;     // 'line', 'bar', 'pie', 'doughnut'
    protected function getData(): array;      // Chart.js dataset format
    protected function getOptions(): array | RawJs | null; // Chart.js options

    // OPZIONALE
    public function getHeading(): string | Htmlable | null { }
    public function getDescription(): ?string { }
    protected function getFilters(): ?array { }  // Page filters
    protected function getMaxHeight(): ?string { } // 'px-300'

    // NON toccare
    protected static bool $isLazy = true;
    protected ?string $pollingInterval = null;
}
```

**Esempio completo**:
```php
class SalesChartWidget extends XotBaseChartWidget
{
    protected function getType(): string { return 'line'; }

    protected function getData(): array
    {
        return [
            'labels' => ['Gen', 'Feb', 'Mar'],
            'datasets' => [[
                'label' => 'Vendite',
                'data' => [100, 150, 200],
                'borderColor' => '#3b82f6',
            ]]
        ];
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<'JS'
        {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: {
                    callbacks: {
                        label: function(ctx) { return '€' + ctx.parsed.y; }
                    }
                }
            }
        }
        JS);
    }
}
```

---

## ListRecords — Pattern tabella

```php
class ListSurveys extends XotBaseListRecords
{
    protected static string $resource = SurveyResource::class;

    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'title' => TextColumn::make('title')->searchable()->wrap(),
            'status' => TextColumn::make('status')
                ->badge()
                ->color(fn (string $state) => match ($state) {
                    'active' => 'success',
                    'draft' => 'gray',
                    default => 'warning',
                }),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            'create' => \Filament\Actions\CreateAction::make(),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            'delete' => \Filament\Tables\Actions\DeleteBulkAction::make(),
        ];
    }
}
```

---

## Infolist — Display read-only

```php
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\{TextEntry, Section};

// In ViewRecord
public function infolist(Infolist $infolist): Infolist
{
    return $infolist->schema([
        Section::make('Dati')->schema([
            TextEntry::make('name'),
            TextEntry::make('email'),
            TextEntry::make('status')
                ->badge()
                ->color(fn (string $state) => match ($state) {
                    'active' => 'success',
                    default => 'gray',
                }),
        ])->columns(2),
    ]);
}
```

---

## Actions — Pattern header e table

```php
// Header actions (string keys obbligatorie)
protected function getHeaderActions(): array
{
    return [
        'create' => \Filament\Actions\CreateAction::make()->icon('heroicon-o-plus'),
        'import' => \Filament\Actions\ImportAction::make(),
    ];
}

// Table row actions
protected function getTableActions(): array
{
    return [
        'edit' => Tables\Actions\EditAction::make(),
        'delete' => Tables\Actions\DeleteAction::make(),
        'view' => Tables\Actions\ViewAction::make(),
    ];
}

// Custom action con modal
'approve' => Tables\Actions\Action::make('approve')
    ->label('Approva')
    ->icon('heroicon-o-check')
    ->color('success')
    ->requiresConfirmation()
    ->action(fn (Survey $record) => $record->update(['status' => 'approved'])),
```

---

## Form Schema — Campi comuni

```php
public function getFormSchema(): array
{
    return [
        TextInput::make('title')
            ->required()
            ->maxLength(255),

        Textarea::make('description')
            ->rows(3),

        Select::make('status')
            ->options(['draft' => 'Bozza', 'active' => 'Attivo'])
            ->required()
            ->native(false),

        Toggle::make('is_active')
            ->label('Attivo'),

        DateTimePicker::make('published_at')
            ->nullable(),

        Repeater::make('questions')
            ->schema([
                TextInput::make('text')->required(),
                Select::make('type')->options([...])->required(),
            ]),

        FileUpload::make('image')
            ->image()
            ->disk('public'),
    ];
}
```

---

## Livewire 4 — Attributi principali

```php
#[Reactive]
public string $search = '';  // Aggiorna il render su ogni cambio

#[Computed]
public function results()
{
    return Survey::where('title', 'like', "%{$this->search}%")->get();
}

#[On('survey-created')]
public function refresh(): void
{
    // Ascolta eventi
}
```

**Wire directives**:
```html
<input wire:model="search" />           <!-- binding -->
<input wire:model.live="query" />       <!-- live (ogni keystroke) -->
<input wire:model.debounce-500ms="q" /> <!-- debounce -->
<form wire:submit="save">...</form>     <!-- submit -->
<button wire:click="increment">+</button>
```

---

## Flux UI (livewire/flux 2.12.1)

Libreria UI per Livewire (sidebar, navbar, breadcrumb, card, badge, button, dialog):

```html
<flux:sidebar>
    <flux:sidebar.logo href="/" src="/logo.svg" alt="Logo" />
    <flux:navbar>
        <flux:navbar.item icon="home" href="/">Home</flux:navbar.item>
    </flux:navbar>
</flux:sidebar>

<flux:card>
    <flux:button variant="primary">Salva</flux:button>
    <flux:button variant="ghost">Annulla</flux:button>
</flux:card>
```

---

## Volt — Componenti single-file

```php
// resources/views/livewire/survey-form.php
<?php
use Livewire\Volt\Component;

new class extends Component {
    public string $title = '';

    public function save(): void
    {
        Survey::create(['title' => $this->title]);
        $this->redirect('/surveys');
    }
}
?>

<div>
    <input wire:model="title" type="text" />
    <button wire:click="save">Salva</button>
</div>
```

---

## Testing Filament components

```php
use Livewire\Livewire;
use Modules\Quaeris\Filament\Widgets\SalesChartWidget;

it('renders chart widget', function (): void {
    Livewire::test(SalesChartWidget::class)
        ->assertSuccessful();
});

it('table has correct columns', function (): void {
    $component = Livewire::test(ListSurveys::class)->instance();
    $columns = $component->getTableColumns();

    expect($columns)->toHaveKeys(['id', 'title', 'status', 'created_at']);
});
```
