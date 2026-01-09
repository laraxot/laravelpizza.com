# Esempio Implementazione TableLayoutEnum

## Data: 2025-01-27

## Scenario
Implementazione di una lista utenti con toggle tra layout lista e griglia utilizzando il `TableLayoutEnum`.

## Implementazione Completa

### 1. ListRecords Class

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Pages;

use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Enums\FontWeight;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\Xot\Filament\Resources\XotBaseListRecords;

class ListUsers extends XotBaseListRecords
{
    protected TableLayoutEnum $layout;

    public function mount(): void
    {
        parent::mount();
        $this->layout = TableLayoutEnum::init();
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns($this->getColumnsForLayout())
            ->contentGrid($this->layout->getTableContentGrid())
            ->paginated([10, 25, 50])
            ->defaultSort('created_at', 'desc')
            ->searchable()
            ->filterable();
    }

    /**
     * Restituisce le colonne appropriate per il layout corrente
     */
    protected function getColumnsForLayout(): array
    {
        $listColumns = [
            TextColumn::make('name')
                ->searchable()
                ->sortable(),
            TextColumn::make('email')
                ->searchable()
                ->sortable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
            TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'active' => 'success',
                    'inactive' => 'danger',
                    default => 'gray',
                }),
        ];

        $gridColumns = [
            Stack::make([
                TextColumn::make('name')
                    ->weight(FontWeight::Bold)
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime(),
            ]),
            TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'active' => 'success',
                    'inactive' => 'danger',
                    default => 'gray',
                }),
        ];

        return $this->layout->getTableColumns($listColumns, $gridColumns);
    }

    /**
     * Azioni header con toggle layout
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('toggleLayout')
                ->icon($this->layout->getIcon())
                ->color($this->layout->getColor())
                ->action(function () {
                    $this->layout = $this->layout->toggle();
                }),
            // Altre azioni...
        ];
    }

    /**
     * Azioni bulk per il layout corrente
     */
    protected function getBulkActions(): array
    {
        return [
            Tables\Actions\BulkAction::make('activate')
                ->icon('heroicon-o-check-circle')
                ->action(function ($records) {
                    // Logica attivazione
                })
                ->visible(fn () => $this->layout->isListLayout()),
            Tables\Actions\BulkAction::make('deactivate')
                ->icon('heroicon-o-x-circle')
                ->action(function ($records) {
                    // Logica disattivazione
                })
                ->visible(fn () => $this->layout->isListLayout()),
        ];
    }
}
```

### 2. Traduzioni Richieste

#### File: `Modules/User/lang/it/fields.php`
```php
<?php

declare(strict_types=1);

return [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci nome',
        'tooltip' => 'Nome completo dell\'utente',
        'helper_text' => 'Nome e cognome dell\'utente',
    ],
    'email' => [
        'label' => 'Email',
        'placeholder' => 'Inserisci email',
        'tooltip' => 'Indirizzo email dell\'utente',
        'helper_text' => 'Email valida per le comunicazioni',
    ],
    'created_at' => [
        'label' => 'Data Creazione',
        'placeholder' => '',
        'tooltip' => 'Data di registrazione dell\'utente',
        'helper_text' => 'Data di creazione dell\'account',
    ],
    'status' => [
        'label' => 'Stato',
        'placeholder' => '',
        'tooltip' => 'Stato attuale dell\'utente',
        'helper_text' => 'Stato attivo o inattivo',
    ],
];
```

#### File: `Modules/User/lang/it/actions.php`
```php
<?php

declare(strict_types=1);

return [
    'activate' => [
        'label' => 'Attiva',
        'tooltip' => 'Attiva gli utenti selezionati',
        'helper_text' => 'Rendi attivi gli utenti selezionati',
    ],
    'deactivate' => [
        'label' => 'Disattiva',
        'tooltip' => 'Disattiva gli utenti selezionati',
        'helper_text' => 'Rendi inattivi gli utenti selezionati',
    ],
];
```

#### File: `Modules/UI/lang/it/table-layout.php` (aggiornato)
```php
<?php

declare(strict_types=1);

return [
    'list' => [
        'label' => 'Lista',
        'color' => 'primary',
        'icon' => 'heroicon-o-list-bullet',
        'description' => 'Visualizzazione a lista tradizionale',
        'tooltip' => 'Mostra elementi in formato lista',
        'helper_text' => 'Layout tradizionale con righe e colonne',
    ],
    'grid' => [
        'label' => 'Griglia',
        'color' => 'success',
        'icon' => 'heroicon-o-squares-2x2',
        'description' => 'Visualizzazione a griglia con card',
        'tooltip' => 'Mostra elementi in formato griglia',
        'helper_text' => 'Layout a griglia con card responsive',
    ],
    'toggle' => [
        'label' => 'Cambia Layout',
        'tooltip' => 'Alterna tra visualizzazione lista e griglia',
        'helper_text' => 'Cambia il tipo di visualizzazione',
    ],
];
```

### 3. CSS Personalizzato (Opzionale)

```css
/* File: Modules/UI/resources/css/table-layout.css */
.table-layout-list {
    @apply bg-white rounded-lg shadow-sm;
}

.table-layout-grid {
    @apply bg-gray-50 rounded-lg p-4;
}

.table-layout-grid .filament-tables-table {
    @apply grid gap-4;
}

.table-layout-grid .filament-tables-row {
    @apply bg-white rounded-lg shadow-sm p-4;
}
```

### 4. Test Unitario

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Enums;

use Modules\UI\Enums\TableLayoutEnum;
use PHPUnit\Framework\TestCase;

class TableLayoutEnumTest extends TestCase
{
    public function test_init_returns_list(): void
    {
        $this->assertEquals(TableLayoutEnum::LIST, TableLayoutEnum::init());
    }

    public function test_toggle_switches_layout(): void
    {
        $layout = TableLayoutEnum::LIST;
        $this->assertEquals(TableLayoutEnum::GRID, $layout->toggle());
        $this->assertEquals(TableLayoutEnum::LIST, $layout->toggle()->toggle());
    }

    public function test_get_label_returns_translated_string(): void
    {
        $listLabel = TableLayoutEnum::LIST->getLabel();
        $gridLabel = TableLayoutEnum::GRID->getLabel();

        $this->assertIsString($listLabel);
        $this->assertIsString($gridLabel);
        $this->assertNotEmpty($listLabel);
        $this->assertNotEmpty($gridLabel);
    }

    public function test_get_color_returns_valid_color(): void
    {
        $listColor = TableLayoutEnum::LIST->getColor();
        $gridColor = TableLayoutEnum::GRID->getColor();

        $this->assertIsString($listColor);
        $this->assertIsString($gridColor);
        $this->assertNotEmpty($listColor);
        $this->assertNotEmpty($gridColor);
    }

    public function test_get_icon_returns_valid_icon(): void
    {
        $listIcon = TableLayoutEnum::LIST->getIcon();
        $gridIcon = TableLayoutEnum::GRID->getIcon();

        $this->assertIsString($listIcon);
        $this->assertIsString($gridIcon);
        $this->assertNotEmpty($listIcon);
        $this->assertNotEmpty($gridIcon);
    }

    public function test_get_table_content_grid_returns_null_for_list(): void
    {
        $this->assertNull(TableLayoutEnum::LIST->getTableContentGrid());
    }

    public function test_get_table_content_grid_returns_array_for_grid(): void
    {
        $grid = TableLayoutEnum::GRID->getTableContentGrid();

        $this->assertIsArray($grid);
        $this->assertArrayHasKey('sm', $grid);
        $this->assertArrayHasKey('md', $grid);
        $this->assertArrayHasKey('lg', $grid);
        $this->assertArrayHasKey('xl', $grid);
        $this->assertArrayHasKey('2xl', $grid);
    }

    public function test_get_table_columns_returns_correct_columns(): void
    {
        $listColumns = ['name', 'email'];
        $gridColumns = ['stack'];

        $result = TableLayoutEnum::LIST->getTableColumns($listColumns, $gridColumns);
        $this->assertEquals($listColumns, $result);

        $result = TableLayoutEnum::GRID->getTableColumns($listColumns, $gridColumns);
        $this->assertEquals($gridColumns, $result);
    }

    public function test_is_grid_layout_returns_correct_boolean(): void
    {
        $this->assertTrue(TableLayoutEnum::GRID->isGridLayout());
        $this->assertFalse(TableLayoutEnum::LIST->isGridLayout());
    }

    public function test_is_list_layout_returns_correct_boolean(): void
    {
        $this->assertTrue(TableLayoutEnum::LIST->isListLayout());
        $this->assertFalse(TableLayoutEnum::GRID->isListLayout());
    }

    public function test_get_options_returns_all_options(): void
    {
        $options = TableLayoutEnum::getOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('list', $options);
        $this->assertArrayHasKey('grid', $options);
        $this->assertCount(2, $options);
    }

    public function test_get_container_classes_returns_valid_classes(): void
    {
        $listClasses = TableLayoutEnum::LIST->getContainerClasses();
        $gridClasses = TableLayoutEnum::GRID->getContainerClasses();

        $this->assertEquals('table-layout-list', $listClasses);
        $this->assertEquals('table-layout-grid', $gridClasses);
    }
}
```

## Vantaggi dell'Implementazione

### 1. Type Safety
- Enum garantisce valori validi
- Type hints espliciti
- Previene errori runtime

### 2. Responsive Design
- Grid configurabile per breakpoints
- CSS nativo senza JS aggiuntivo
- Performance ottimizzata

### 3. UX Consistency
- Icone e colori coerenti
- Traduzioni centralizzate
- Comportamento prevedibile

### 4. Maintainability
- Codice DRY e riutilizzabile
- Separazione responsabilità
- Testabilità migliorata

## Regole Critiche Implementate

### ❌ MAI usare ->label()
```php
// ERRORE - Non fare mai questo
TextColumn::make('name')->label('Nome')

// ✅ CORRETTO - Usa il sistema di traduzioni automatico
TextColumn::make('name')
```

### ✅ Sistema Traduzioni Automatico
- Il LangServiceProvider gestisce automaticamente le traduzioni
- Le chiavi vengono generate automaticamente dal nome del campo
- Struttura: `modulo::risorsa.fields.campo.label`

### ✅ Enum Translation Pattern
- **SEMPRE** usare `transClass()` negli enum per le traduzioni
- **MAI** usare `__()` o `trans()` direttamente negli enum
- **SEMPRE** struttura espansa nei file di traduzione
- **SEMPRE** `use TransTrait;` negli enum

## Collegamenti

- [Analisi TableLayoutEnum](table_layout_enum_analysis.md)
- [Usage Guide](table-layout-enum-usage.md)
- [Translation Standards](../../../docs/translation_standards.md)
- [Filament Best Practices](../../../docs/filament_best_practices.md)
- [Enum Translation Pattern](../../../docs/enum-translation-pattern.md)

*Ultimo aggiornamento: 2025-01-27*
# Esempio Implementazione TableLayoutEnum

## Data: 2025-01-27

## Scenario
Implementazione di una lista utenti con toggle tra layout lista e griglia utilizzando il `TableLayoutEnum`.

## Implementazione Completa

### 1. ListRecords Class

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Pages;

use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Enums\FontWeight;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\Xot\Filament\Resources\XotBaseListRecords;

class ListUsers extends XotBaseListRecords
{
    protected TableLayoutEnum $layout;

    public function mount(): void
    {
        parent::mount();
        $this->layout = TableLayoutEnum::init();
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns($this->getColumnsForLayout())
            ->contentGrid($this->layout->getTableContentGrid())
            ->paginated([10, 25, 50])
            ->defaultSort('created_at', 'desc')
            ->searchable()
            ->filterable();
    }

    /**
     * Restituisce le colonne appropriate per il layout corrente
     */
    protected function getColumnsForLayout(): array
    {
        $listColumns = [
            TextColumn::make('name')
                ->searchable()
                ->sortable(),
            TextColumn::make('email')
                ->searchable()
                ->sortable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
            TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'active' => 'success',
                    'inactive' => 'danger',
                    default => 'gray',
                }),
        ];

        $gridColumns = [
            Stack::make([
                TextColumn::make('name')
                    ->weight(FontWeight::Bold)
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime(),
            ]),
            TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'active' => 'success',
                    'inactive' => 'danger',
                    default => 'gray',
                }),
        ];

        return $this->layout->getTableColumns($listColumns, $gridColumns);
    }

    /**
     * Azioni header con toggle layout
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('toggleLayout')
                ->icon($this->layout->getIcon())
                ->color($this->layout->getColor())
                ->action(function () {
                    $this->layout = $this->layout->toggle();
                }),
            // Altre azioni...
        ];
    }

    /**
     * Azioni bulk per il layout corrente
     */
    protected function getBulkActions(): array
    {
        return [
            Tables\Actions\BulkAction::make('activate')
                ->icon('heroicon-o-check-circle')
                ->action(function ($records) {
                    // Logica attivazione
                })
                ->visible(fn () => $this->layout->isListLayout()),
            Tables\Actions\BulkAction::make('deactivate')
                ->icon('heroicon-o-x-circle')
                ->action(function ($records) {
                    // Logica disattivazione
                })
                ->visible(fn () => $this->layout->isListLayout()),
        ];
    }
}
```

### 2. Traduzioni Richieste

#### File: `Modules/User/lang/it/fields.php`
```php
<?php

declare(strict_types=1);

return [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci nome',
        'tooltip' => 'Nome completo dell\'utente',
        'helper_text' => 'Nome e cognome dell\'utente',
    ],
    'email' => [
        'label' => 'Email',
        'placeholder' => 'Inserisci email',
        'tooltip' => 'Indirizzo email dell\'utente',
        'helper_text' => 'Email valida per le comunicazioni',
    ],
    'created_at' => [
        'label' => 'Data Creazione',
        'placeholder' => '',
        'tooltip' => 'Data di registrazione dell\'utente',
        'helper_text' => 'Data di creazione dell\'account',
    ],
    'status' => [
        'label' => 'Stato',
        'placeholder' => '',
        'tooltip' => 'Stato attuale dell\'utente',
        'helper_text' => 'Stato attivo o inattivo',
    ],
];
```

#### File: `Modules/User/lang/it/actions.php`
```php
<?php

declare(strict_types=1);

return [
    'activate' => [
        'label' => 'Attiva',
        'tooltip' => 'Attiva gli utenti selezionati',
        'helper_text' => 'Rendi attivi gli utenti selezionati',
    ],
    'deactivate' => [
        'label' => 'Disattiva',
        'tooltip' => 'Disattiva gli utenti selezionati',
        'helper_text' => 'Rendi inattivi gli utenti selezionati',
    ],
];
```

#### File: `Modules/UI/lang/it/table-layout.php` (aggiornato)
```php
<?php

declare(strict_types=1);

return [
    'list' => [
        'label' => 'Lista',
        'color' => 'primary',
        'icon' => 'heroicon-o-list-bullet',
        'description' => 'Visualizzazione a lista tradizionale',
        'tooltip' => 'Mostra elementi in formato lista',
        'helper_text' => 'Layout tradizionale con righe e colonne',
    ],
    'grid' => [
        'label' => 'Griglia',
        'color' => 'success',
        'icon' => 'heroicon-o-squares-2x2',
        'description' => 'Visualizzazione a griglia con card',
        'tooltip' => 'Mostra elementi in formato griglia',
        'helper_text' => 'Layout a griglia con card responsive',
    ],
    'toggle' => [
        'label' => 'Cambia Layout',
        'tooltip' => 'Alterna tra visualizzazione lista e griglia',
        'helper_text' => 'Cambia il tipo di visualizzazione',
    ],
];
```

### 3. CSS Personalizzato (Opzionale)

```css
/* File: Modules/UI/resources/css/table-layout.css */
.table-layout-list {
    @apply bg-white rounded-lg shadow-sm;
}

.table-layout-grid {
    @apply bg-gray-50 rounded-lg p-4;
}

.table-layout-grid .filament-tables-table {
    @apply grid gap-4;
}

.table-layout-grid .filament-tables-row {
    @apply bg-white rounded-lg shadow-sm p-4;
}
```

### 4. Test Unitario

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Enums;

use Modules\UI\Enums\TableLayoutEnum;
use PHPUnit\Framework\TestCase;

class TableLayoutEnumTest extends TestCase
{
    public function test_init_returns_list(): void
    {
        $this->assertEquals(TableLayoutEnum::LIST, TableLayoutEnum::init());
    }

    public function test_toggle_switches_layout(): void
    {
        $layout = TableLayoutEnum::LIST;
        $this->assertEquals(TableLayoutEnum::GRID, $layout->toggle());
        $this->assertEquals(TableLayoutEnum::LIST, $layout->toggle()->toggle());
    }

    public function test_get_label_returns_translated_string(): void
    {
        $listLabel = TableLayoutEnum::LIST->getLabel();
        $gridLabel = TableLayoutEnum::GRID->getLabel();

        $this->assertIsString($listLabel);
        $this->assertIsString($gridLabel);
        $this->assertNotEmpty($listLabel);
        $this->assertNotEmpty($gridLabel);
    }

    public function test_get_color_returns_valid_color(): void
    {
        $listColor = TableLayoutEnum::LIST->getColor();
        $gridColor = TableLayoutEnum::GRID->getColor();

        $this->assertIsString($listColor);
        $this->assertIsString($gridColor);
        $this->assertNotEmpty($listColor);
        $this->assertNotEmpty($gridColor);
    }

    public function test_get_icon_returns_valid_icon(): void
    {
        $listIcon = TableLayoutEnum::LIST->getIcon();
        $gridIcon = TableLayoutEnum::GRID->getIcon();

        $this->assertIsString($listIcon);
        $this->assertIsString($gridIcon);
        $this->assertNotEmpty($listIcon);
        $this->assertNotEmpty($gridIcon);
    }

    public function test_get_table_content_grid_returns_null_for_list(): void
    {
        $this->assertNull(TableLayoutEnum::LIST->getTableContentGrid());
    }

    public function test_get_table_content_grid_returns_array_for_grid(): void
    {
        $grid = TableLayoutEnum::GRID->getTableContentGrid();

        $this->assertIsArray($grid);
        $this->assertArrayHasKey('sm', $grid);
        $this->assertArrayHasKey('md', $grid);
        $this->assertArrayHasKey('lg', $grid);
        $this->assertArrayHasKey('xl', $grid);
        $this->assertArrayHasKey('2xl', $grid);
    }

    public function test_get_table_columns_returns_correct_columns(): void
    {
        $listColumns = ['name', 'email'];
        $gridColumns = ['stack'];

        $result = TableLayoutEnum::LIST->getTableColumns($listColumns, $gridColumns);
        $this->assertEquals($listColumns, $result);

        $result = TableLayoutEnum::GRID->getTableColumns($listColumns, $gridColumns);
        $this->assertEquals($gridColumns, $result);
    }

    public function test_is_grid_layout_returns_correct_boolean(): void
    {
        $this->assertTrue(TableLayoutEnum::GRID->isGridLayout());
        $this->assertFalse(TableLayoutEnum::LIST->isGridLayout());
    }

    public function test_is_list_layout_returns_correct_boolean(): void
    {
        $this->assertTrue(TableLayoutEnum::LIST->isListLayout());
        $this->assertFalse(TableLayoutEnum::GRID->isListLayout());
    }

    public function test_get_options_returns_all_options(): void
    {
        $options = TableLayoutEnum::getOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('list', $options);
        $this->assertArrayHasKey('grid', $options);
        $this->assertCount(2, $options);
    }

    public function test_get_container_classes_returns_valid_classes(): void
    {
        $listClasses = TableLayoutEnum::LIST->getContainerClasses();
        $gridClasses = TableLayoutEnum::GRID->getContainerClasses();

        $this->assertEquals('table-layout-list', $listClasses);
        $this->assertEquals('table-layout-grid', $gridClasses);
    }
}
```

## Vantaggi dell'Implementazione

### 1. Type Safety
- Enum garantisce valori validi
- Type hints espliciti
- Previene errori runtime

### 2. Responsive Design
- Grid configurabile per breakpoints
- CSS nativo senza JS aggiuntivo
- Performance ottimizzata

### 3. UX Consistency
- Icone e colori coerenti
- Traduzioni centralizzate
- Comportamento prevedibile

### 4. Maintainability
- Codice DRY e riutilizzabile
- Separazione responsabilità
- Testabilità migliorata

## Regole Critiche Implementate

### ❌ MAI usare ->label()
```php
// ERRORE - Non fare mai questo
TextColumn::make('name')->label('Nome')

// ✅ CORRETTO - Usa il sistema di traduzioni automatico
TextColumn::make('name')
```

### ✅ Sistema Traduzioni Automatico
- Il LangServiceProvider gestisce automaticamente le traduzioni
- Le chiavi vengono generate automaticamente dal nome del campo
- Struttura: `modulo::risorsa.fields.campo.label`

### ✅ Enum Translation Pattern
- **SEMPRE** usare `transClass()` negli enum per le traduzioni
- **MAI** usare `__()` o `trans()` direttamente negli enum
- **SEMPRE** struttura espansa nei file di traduzione
- **SEMPRE** `use TransTrait;` negli enum

## Collegamenti

- [Analisi TableLayoutEnum](table_layout_enum_analysis.md)
- [Usage Guide](table-layout-enum-usage.md)
- [Translation Standards](../../../docs/translation_standards.md)
- [Filament Best Practices](../../../docs/filament_best_practices.md)
- [Enum Translation Pattern](../../../docs/enum-translation-pattern.md)

*Ultimo aggiornamento: 2025-01-27*
