# TableLayoutEnum Usage Guide

## Nuovo Approccio (Corretto)

Dopo la correzione del problema di visibilità, il metodo `getTableColumns()` ora richiede parametri espliciti invece di usare debug_backtrace.

### Esempio di uso nelle classi ListRecords:

```php
use Modules\UI\Enums\TableLayoutEnum;
## Overview

The `TableLayoutEnum` provides standardized layout options for Filament tables and data grids, allowing users to toggle between list and grid views with appropriate styling and column configurations.

## Features

- **Type Safety**: Complete PHPDoc documentation and explicit parameter types
- **Translation Support**: Multilingual labels via TransTrait and transClass()
- **Responsive Design**: Enhanced grid configuration with multiple breakpoints
- **Clean API**: No more debug_backtrace, explicit parameter passing
- **Framework Compliance**: Uses TransTrait for all translation methods
- **Extensible**: Additional utility methods for layout management

## CRITICAL RULE: TransTrait Usage

**ALWAYS use TransTrait and transClass() for enum translations, NEVER implement match() manually**

### Correct Implementation

```php
use Modules\Xot\Filament\Traits\TransTrait;

enum TableLayoutEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;

    case LIST = 'list';
    case GRID = 'grid';

    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value.'.label');
    }

    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value.'.color');
    }

    public function getIcon(): string
    {
        return $this->transClass(self::class, $this->value.'.icon');
    }
}
```

### Why TransTrait is Required

1. **DRY Principle**: Eliminates code duplication
2. **Framework Consistency**: Uniform approach across all enums
3. **Automatic Fallbacks**: Built-in translation fallback mechanisms
4. **Performance**: Optimized translation caching
5. **Maintainability**: Centralized translation logic

## New Approach (Implemented)

After resolving Git conflicts and removing the deprecated debug_backtrace approach, the `getTableColumns()` method now requires explicit parameters for better type safety and testability.

### Example Usage in ListRecords Classes

```php
use Modules\UI\Enums\TableLayoutEnum;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Support\Enums\FontWeight;

class ListUsers extends ListRecords
{
    protected TableLayoutEnum $layout;

    public function mount(): void
    {
        $this->layout = TableLayoutEnum::LIST;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns($this->getColumnsForLayout())
            ->contentGrid($this->layout->getTableContentGrid());
    }

    /**
     * Restituisce le colonne appropriate per il layout corrente
            ->contentGrid($this->layout->getTableContentGrid())
            ->extraAttributes([
                'class' => $this->layout->getContainerClasses(),
            ]);
    }

    /**
     * Get appropriate columns for current layout.
     */
    protected function getColumnsForLayout(): array
    {
        $listColumns = [
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('email'),
            Tables\Columns\TextColumn::make('created_at'),
        ];

        $gridColumns = [
            Tables\Columns\Layout\Stack::make([
                Tables\Columns\TextColumn::make('name')
                    ->weight(FontWeight::Bold),
                Tables\Columns\TextColumn::make('email'),
            ]),
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('email')
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];

        $gridColumns = [
            Stack::make([
                Tables\Columns\TextColumn::make('name')
                    ->weight(FontWeight::Bold)
                    ->size('lg'),
                Tables\Columns\TextColumn::make('email')
                    ->color('gray'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->size('sm'),
            ])->space(2),
        ];

        return $this->layout->getTableColumns($listColumns, $gridColumns);
    }

    /**
     * Layout toggle action.
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('toggleLayout')
                ->action(function () {
                    $this->layout = $this->layout->toggle();
                    $this->resetTable();
                }),
        ];
    }
}
```

### Vantaggi del nuovo approccio:

1. **Type Safety**: Non usa più reflection o debug_backtrace
2. **Chiarezza**: Esplicito su quali colonne usare per ogni layout
3. **Testabilità**: Più facile da testare senza dipendenze nascoste
4. **Performance**: Nessun overhead di debug_backtrace

### Breaking Change:

Il metodo `getTableColumns()` ora richiede due parametri:
- `$listColumns`: Array delle colonne per layout lista
- `$gridColumns`: Array delle colonne per layout griglia
### Advantages of the New Approach

1. **Type Safety**: No longer uses reflection or debug_backtrace
2. **Clarity**: Explicit about which columns to use for each layout
3. **Testability**: Easier to test without hidden dependencies
4. **Performance**: No debug_backtrace overhead
5. **Documentation**: Complete PHPDoc and translations
6. **Maintainability**: Clean, well-structured code

### Breaking Change

The `getTableColumns()` method now requires two parameters:

- `$listColumns`: Array of columns for list layout
- `$gridColumns`: Array of columns for grid layout

### New Features Added

1. **Complete PHPDoc**: All methods now have comprehensive documentation
2. **Translation Support**: Labels are now translatable via `ui::table-layout.*`
3. **Additional Methods**: `isListLayout()`, `getOptions()`, `getContainerClasses()`
4. **Improved Grid Configuration**: Enhanced responsive breakpoints
5. **Better Color Scheme**: Distinct colors for list (primary) and grid (secondary)

## Translation Files

The enum now supports multilingual labels through translation files:

- `Modules/UI/lang/it/table-layout.php` (Italian)
- `Modules/UI/lang/en/table-layout.php` (English)
- `Modules/UI/lang/de/table-layout.php` (German)

### Translation Structure

```php
return [
    'list' => [
        'label' => 'List',
        'description' => 'Traditional table row display',
        'tooltip' => 'Show data in table rows',
    ],
    'grid' => [
        'label' => 'Grid',
        'description' => 'Responsive grid card display',
        'tooltip' => 'Show data in grid format with cards',
    ],
    'toggle' => [
        'label' => 'Toggle Layout',
        'tooltip' => 'Switch between list and grid view',
    ],
];
```

## API Reference

### Methods

- `init()`: Returns the default layout (LIST)
- `getLabel()`: Returns translated label for the layout
- `getColor()`: Returns color identifier (primary/secondary)
- `getIcon()`: Returns Heroicon identifier
- `toggle()`: Switches between LIST and GRID
- `isGridLayout()`: Checks if current layout is GRID
- `isListLayout()`: Checks if current layout is LIST
- `getTableContentGrid()`: Returns responsive grid configuration
- `getTableColumns()`: Returns appropriate columns for layout
- `getOptions()`: Returns all layout options as array
- `getContainerClasses()`: Returns CSS classes for styling

### Grid Configuration

The responsive grid configuration includes:

```php
[
    'sm' => 1,   // 1 column on small screens
    'md' => 2,   // 2 columns on medium screens
    'lg' => 3,   // 3 columns on large screens
    'xl' => 4,   // 4 columns on extra large screens
    '2xl' => 5,  // 5 columns on 2xl screens
]
```

## Migration Guide

### From Old Approach

```php
// OLD (deprecated)
$columns = $this->layout->getTableColumns();

// NEW (required)
$columns = $this->layout->getTableColumns($listColumns, $gridColumns);
```

### Update Your ListRecords Classes

1. Define separate column arrays for list and grid layouts
2. Pass both arrays to `getTableColumns()`
3. Use `getContainerClasses()` for styling
4. Implement proper toggle actions with new methods

## Related Documentation

- [UI Module Architecture](architecture_rules.md)
- [Filament Components Guide](components.md)
- [Translation Standards](translations.md)
- [Table Components](table-components.md)
- [HasXotTable Trait](../../Xot/docs/has-xot-table.md)
- [Root Documentation: UI Components](../../../docs/components/ui-components.md)
# TableLayoutEnum Usage Guide

## Nuovo Approccio (Corretto)

Dopo la correzione del problema di visibilità, il metodo `getTableColumns()` ora richiede parametri espliciti invece di usare debug_backtrace.

### Esempio di uso nelle classi ListRecords:

```php
use Modules\UI\Enums\TableLayoutEnum;

class ListUsers extends ListRecords
{
    protected TableLayoutEnum $layout;

    public function mount(): void
    {
        $this->layout = TableLayoutEnum::LIST;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns($this->getColumnsForLayout())
            ->contentGrid($this->layout->getTableContentGrid());
    }

    /**
     * Restituisce le colonne appropriate per il layout corrente
     */
    protected function getColumnsForLayout(): array
    {
        $listColumns = [
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('email'),
            Tables\Columns\TextColumn::make('created_at'),
        ];

        $gridColumns = [
            Tables\Columns\Layout\Stack::make([
                Tables\Columns\TextColumn::make('name')
                    ->weight(FontWeight::Bold),
                Tables\Columns\TextColumn::make('email'),
            ]),
        ];

        return $this->layout->getTableColumns($listColumns, $gridColumns);
    }

    /**
     * Toggle del layout tramite action
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('toggleLayout')
                ->icon($this->layout->getIcon())
                ->action(function () {
                    $this->layout = $this->layout->toggle();
                }),
        ];
    }
}
```

### Vantaggi del nuovo approccio:

1. **Type Safety**: Non usa più reflection o debug_backtrace
2. **Chiarezza**: Esplicito su quali colonne usare per ogni layout
3. **Testabilità**: Più facile da testare senza dipendenze nascoste
4. **Performance**: Nessun overhead di debug_backtrace

### Breaking Change:

Il metodo `getTableColumns()` ora richiede due parametri:
- `$listColumns`: Array delle colonne per layout lista
- `$gridColumns`: Array delle colonne per layout griglia
