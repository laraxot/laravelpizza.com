# Filament Widgets - Guida Completa v5.x

**Data**: 2026-03-23  
**Riferimento**: https://filamentphp.com/docs/5.x/widgets/overview

---

## 📋 Overview

Filament permette di costruire dashboard dinamiche composte da "widgets". Ogni widget è un elemento che visualizza dati in modo specifico:
- **Stats Overview**: Statistiche
- **Chart**: Grafici
- **Table**: Tabelle con dati

---

## 🏗️ Creazione Widget

### Comando Artisan

```bash
php artisan make:filament-widget MyWidget
```

**Opzioni**:
- `Custom`: Widget custom costruito da zero
- `Chart`: Widget con grafico
- `Stats overview`: Widget con statistiche
- `Table`: Widget tabellare

---

## 🎯 Table Widget

### Creazione

```bash
php artisan make:filament-widget LatestOrders --table
```

### Proprietà Fondamentali

```php
// Ordinamento widget nella pagina
protected static ?int $sort = 2;

// Larghezza widget (1-12 o 'full')
protected int|string|array $columnSpan = 'full';

// Larghezza responsive
protected int|string|array $columnSpan = [
    'md' => 2,
    'xl' => 3,
];
```

---

## 🔧 Configurazione Table

### Query

```php
public function table(Table $table): Table
{
    return $table
        ->query(Model::query()->where('active', true))
        ->columns($this->getTableColumns())
        ->defaultPagination(10);
}
```

### Colonne

```php
protected function getTableColumns(): array
{
    return [
        TextColumn::make('title')
            ->searchable()
            ->sortable(),
            
        TextColumn::make('status')
            ->badge()
            ->color(fn ($state) => match {
                'active' => 'success',
                'pending' => 'warning',
                default => 'gray',
            }),
    ];
}
```

### Filtri

```php
->filters([
    SelectFilter::make('status')
        ->options([
            'active' => 'Attivo',
            'inactive' => 'Inattivo',
        ]),
        
    DateFilter::start('created_after'),
])
```

### Azioni

```php
->actions([
    Action::make('edit')
        ->url(fn ($record) => route('edit', $record)),
        
    DeleteAction::make(),
])
```

---

## 🎨 Layout - contentGrid()

Trasforma righe tabella in griglia di cards:

```php
public function table(Table $table): Table
{
    return $table
        ->columns([
            Stack::make([
                TextColumn::make('title'),
                TextColumn::make('price'),
            ]),
        ])
        ->contentGrid([
            'md' => 2,
            'lg' => 3,
            'xl' => 4,
        ]);
}
```

**Breakpoint**: `sm`, `md`, `lg`, `xl`, `2xl` (1-12 colonne)

---

## 📱 Layout - Stack e Split

### Stack (verticale)

```php
use Filament\Tables\Columns\Layout\Stack;

Stack::make([
    TextColumn::make('title')->weight('bold'),
    TextColumn::make('category')->badge(),
])
```

### Split (orizzontale)

```php
use Filament\Tables\Columns\Layout\Split;

Split::make([
    ImageColumn::make('image'),
    Stack::make([...]),
])
```

---

## 🔄 InteractsWithPageFilters

Per usare filtri del dashboard:

```php
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class MyTableWidget extends XotBaseTableWidget
{
    use InteractsWithPageFilters;

    public function table(Table $table): Table
    {
        $startDate = $this->pageFilters['startDate'] ?? null;
        
        return $table
            ->query(Model::query()
                ->when($startDate, fn ($q) => $q->whereDate('created_at', '>=', $startDate))
            );
    }
}
```

---

## 👁️ Visibilità Condizionale

```php
public static function canView(): bool
{
    return auth()->user()->isAdmin();
}
```

---

## 📊 Dashboard Grid

### Colonne Dashboard

```php
public function getColumns(): int | array
{
    return 2;
}

// Responsive
public function getColumns(): int | array
{
    return [
        'md' => 4,
        'xl' => 5,
    ];
}
```

---

## 🔗 Integrazione Laraxot

### Estendere XotBaseTableWidget

```php
use Modules\Xot\Filament\Widgets\XotBaseTableWidget;

class MyTableWidget extends XotBaseTableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(MyModel::query()->with(['relations']))
            ->columns([...])
            ->contentGrid(['md' => 2, 'lg' => 3]);
    }
}
```

### View Blade

```blade
<div class="filament-table-widget">
    @livewire(\Modules\MyModule\Filament\Widgets\MyTableWidget::class)
</div>
```

### CMS JSON

```json
{
    "type": "filament-widget",
    "widget": "Modules\\MyModule\\Filament\\Widgets\\MyTableWidget"
}
```

---

## 📚 Riferimenti

- [Filament 5.x Widgets Overview](https://filamentphp.com/docs/5.x/widgets/overview)
- [Filament 5.x Tables](https://filamentphp.com/docs/5.x/tables)
- [Filament 5.x Tables Layout](https://filamentphp.com/docs/5.x/tables/layout)

---

**Ultimo Aggiornamento**: 2026-03-23
