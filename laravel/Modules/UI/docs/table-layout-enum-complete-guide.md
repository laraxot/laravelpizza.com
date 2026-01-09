# TableLayoutEnum - Guida Completa

## Panoramica

Il `TableLayoutEnum` è un componente fondamentale del modulo UI che gestisce i layout delle tabelle in Filament. Fornisce un sistema standardizzato per alternare tra visualizzazioni a lista e a griglia, migliorando l'esperienza utente e la flessibilità dell'interfaccia.

## Scopo e Funzionalità

### Obiettivo Principale
- **Gestione Layout**: Fornisce due modalità di visualizzazione per le tabelle Filament
- **Responsive Design**: Adatta automaticamente il layout per diversi dispositivi
- **User Experience**: Permette agli utenti di scegliere la visualizzazione preferita
- **Consistenza**: Standardizza il comportamento dei layout in tutto il progetto

### Layout Disponibili

#### 1. LIST Layout
- **Tipo**: Visualizzazione tradizionale a tabella
- **Icona**: `heroicon-o-list-bullet`
- **Colore**: `primary`
- **Caratteristiche**:
  - Righe di tabella standard
  - Colonne ben definite
  - Ordinamento e filtri tradizionali
  - Ideale per dati strutturati

#### 2. GRID Layout
- **Tipo**: Visualizzazione a griglia con carte
- **Icona**: `heroicon-o-squares-2x2`
- **Colore**: `secondary`
- **Caratteristiche**:
  - Carte responsive
  - Layout adattivo per dispositivi mobili
  - Visualizzazione più moderna
  - Ideale per contenuti multimediali

## Implementazione Tecnica

### Struttura Base

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TableLayoutEnum: string implements HasColor, HasIcon, HasLabel
{
    case LIST = 'list';
    case GRID = 'grid';

    // Metodi di implementazione...
}
```

### Interfacce Implementate

1. **HasLabel**: Fornisce etichette tradotte per l'interfaccia
2. **HasColor**: Assegna colori specifici per ogni layout
3. **HasIcon**: Fornisce icone Heroicon per i controlli

### Metodi Principali

#### `getLabel()`
```php
public function getLabel(): string
{
    return match ($this) {
        self::LIST => __('ui::table-layout.list.label'),
        self::GRID => __('ui::table-layout.grid.label'),
    };
}
```

#### `getColor()`
```php
public function getColor(): string
{
    return match ($this) {
        self::LIST => 'primary',
        self::GRID => 'secondary',
    };
}
```

#### `getIcon()`
```php
public function getIcon(): string
{
    return match ($this) {
        self::LIST => 'heroicon-o-list-bullet',
        self::GRID => 'heroicon-o-squares-2x2',
    };
}
```

#### `toggle()`
```php
public function toggle(): self
{
    return match ($this) {
        self::LIST => self::GRID,
        self::GRID => self::LIST,
    };
}
```

#### `getTableContentGrid()`
```php
public function getTableContentGrid(): ?array
{
    return $this->isGridLayout()
        ? [
            'sm' => 1,
            'md' => 2,
            'lg' => 3,
            'xl' => 4,
            '2xl' => 5,
        ]
        : null;
}
```

#### `getTableColumns()`
```php
public function getTableColumns(array $listColumns, array $gridColumns): array
{
    return $this->isGridLayout() ? $gridColumns : $listColumns;
}
```

## Utilizzo nelle Classi Filament

### Esempio Completo

```php
<?php

declare(strict_types=1);

namespace Modules\YourModule\Filament\Resources;

use Filament\Tables;
use Filament\Tables\Table;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\Xot\Filament\Resources\XotBaseListRecords;

class YourResourceListRecords extends XotBaseListRecords
{
    protected TableLayoutEnum $layout = TableLayoutEnum::LIST;

    public function mount(): void
    {
        parent::mount();
        $this->layout = TableLayoutEnum::LIST;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns($this->getColumnsForLayout())
            ->contentGrid($this->layout->getTableContentGrid())
            ->actions([
                Tables\Actions\Action::make('toggleLayout')
                    ->icon($this->layout->getIcon())
                    ->color($this->layout->getColor())
                    ->action(function () {
                        $this->layout = $this->layout->toggle();
                    }),
            ]);
    }

    protected function getColumnsForLayout(): array
    {
        $listColumns = [
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('email')
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime(),
        ];

        $gridColumns = [
            Tables\Columns\Layout\Stack::make([
                Tables\Columns\TextColumn::make('name')
                    ->weight(\Filament\Support\Enums\FontWeight::Bold),
                Tables\Columns\TextColumn::make('email'),
            ]),
            Tables\Columns\Layout\Stack::make([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ]),
        ];

        return $this->layout->getTableColumns($listColumns, $gridColumns);
    }
}
```

## Configurazione Responsive

### Breakpoint Grid
Il layout GRID utilizza una configurazione responsive:

```php
[
    'sm' => 1,   // Mobile: 1 colonna
    'md' => 2,   // Tablet: 2 colonne
    'lg' => 3,   // Desktop piccolo: 3 colonne
    'xl' => 4,   // Desktop medio: 4 colonne
    '2xl' => 5,  // Desktop grande: 5 colonne
]
```

### CSS Classes
Ogni layout ha le sue classi CSS:

```php
public function getContainerClasses(): string
{
    return match ($this) {
        self::LIST => 'table-layout-list',
        self::GRID => 'table-layout-grid',
    };
}
```

## Traduzioni

### Struttura File di Traduzione
```php
// laravel/Modules/UI/lang/it/table-layout.php
return [
    'list' => [
        'label' => 'Lista',
        'description' => 'Visualizzazione tradizionale in formato tabella',
        'tooltip' => 'Mostra i dati in righe di tabella',
    ],
    'grid' => [
        'label' => 'Griglia',
        'description' => 'Visualizzazione a griglia responsive',
        'tooltip' => 'Mostra i dati in formato griglia con carte',
    ],
    'toggle' => [
        'label' => 'Cambia Layout',
        'tooltip' => 'Alterna tra visualizzazione lista e griglia',
    ],
];
```

## Best Practices

### 1. Definizione Colonne
- **List Columns**: Usare colonne standard per dati strutturati
- **Grid Columns**: Usare `Layout\Stack` per contenuti complessi
- **Separazione**: Mantenere logica separata per ogni layout

### 2. Traduzioni Enum
- **SEMPRE** usare `transClass()` negli enum per le traduzioni
- **MAI** usare `__()` o `trans()` direttamente negli enum
- **SEMPRE** struttura espansa nei file di traduzione
- **SEMPRE** `use TransTrait;` negli enum

### 2. Performance
- **Lazy Loading**: Caricare colonne solo quando necessario
- **Caching**: Memorizzare il layout preferito dell'utente
- **Optimization**: Minimizzare il numero di colonne per il grid

### 3. Accessibilità
- **ARIA Labels**: Fornire etichette appropriate per screen reader
- **Keyboard Navigation**: Supportare navigazione da tastiera
- **Focus Management**: Gestire correttamente il focus

### 4. Responsive Design
- **Mobile First**: Progettare prima per mobile
- **Breakpoints**: Utilizzare breakpoint standard
- **Touch Friendly**: Rendere i controlli touch-friendly

## Testing

### Test Unitari
```php
<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Enums;

use Modules\UI\Enums\TableLayoutEnum;
use Tests\TestCase;

class TableLayoutEnumTest extends TestCase
{
    /** @test */
    public function it_returns_correct_labels(): void
    {
        $this->assertEquals('Lista', TableLayoutEnum::LIST->getLabel());
        $this->assertEquals('Griglia', TableLayoutEnum::GRID->getLabel());
    }

    /** @test */
    public function it_toggles_correctly(): void
    {
        $this->assertEquals(TableLayoutEnum::GRID, TableLayoutEnum::LIST->toggle());
        $this->assertEquals(TableLayoutEnum::LIST, TableLayoutEnum::GRID->toggle());
    }

    /** @test */
    public function it_returns_correct_grid_configuration(): void
    {
        $gridConfig = TableLayoutEnum::GRID->getTableContentGrid();

        $this->assertIsArray($gridConfig);
        $this->assertEquals(1, $gridConfig['sm']);
        $this->assertEquals(5, $gridConfig['2xl']);
    }
}
```

## Troubleshooting

### Problemi Comuni

1. **Layout non cambia**:
   - Verificare che il metodo `toggle()` sia chiamato
   - Controllare che il componente sia reattivo

2. **Colonne non si aggiornano**:
   - Verificare che `getTableColumns()` riceva i parametri corretti
   - Controllare che le colonne siano definite per entrambi i layout

3. **Responsive non funziona**:
   - Verificare che `getTableContentGrid()` restituisca la configurazione corretta
   - Controllare che il CSS sia caricato

### Debug
```php
// Debug del layout corrente
dd($this->layout->value);

// Debug delle colonne
dd($this->getColumnsForLayout());

// Debug della configurazione grid
dd($this->layout->getTableContentGrid());
```

## Collegamenti

- [UI Components](../components.md)
- [Filament Tables](https://filamentphp.com/docs/3.x/tables/overview)
- [Translation Standards](../../Xot/docs/translation-standards.md)
- [Enum Standards](../../../docs/enum_standards.md)

## Ultimo Aggiornamento
2025-01-27 - Documentazione completa TableLayoutEnum
