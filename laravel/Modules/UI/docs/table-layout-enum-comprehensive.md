# TableLayoutEnum - Documentazione Completa

## Panoramica

Il `TableLayoutEnum` è un componente fondamentale del modulo UI che gestisce i layout delle tabelle in Filament. Fornisce un sistema standardizzato per alternare tra visualizzazioni lista e griglia, con supporto completo per traduzioni, icone e colori.

## REGOLA CRITICA: SEMPRE TransTrait

**ALWAYS use TransTrait and transClass() for enum translations, NEVER implement match() manually**

### Implementazione Corretta con TransTrait

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
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

    public function getDescription(): string
    {
        return $this->transClass(self::class, $this->value.'.description');
    }

    public function getTooltip(): string
    {
        return $this->transClass(self::class, $this->value.'.tooltip');
    }

    public function getHelperText(): string
    {
        return $this->transClass(self::class, $this->value.'.helper_text');
    }

    // Metodi di utilità
    public static function init(): self
    {
        return self::LIST;
    }

    public function toggle(): self
    {
        return match ($this) {
            self::LIST => self::GRID,
            self::GRID => self::LIST,
        };
    }

    public function isListLayout(): bool
    {
        return $this === self::LIST;
    }

    public function isGridLayout(): bool
    {
        return $this === self::GRID;
    }

    public function getTableContentGrid(): ?array
    {
        return match ($this) {
            self::LIST => null,
            self::GRID => [
                'sm' => 1,
                'md' => 2,
                'lg' => 3,
                'xl' => 4,
                '2xl' => 5,
            ],
        };
    }

    public function getTableColumns(array $listColumns, array $gridColumns): array
    {
        return match ($this) {
            self::LIST => $listColumns,
            self::GRID => $gridColumns,
        };
    }

    public function getOptions(): array
    {
        return [
            'list' => self::LIST,
            'grid' => self::GRID,
        ];
    }

    public function getContainerClasses(): string
    {
        return match ($this) {
            self::LIST => 'table-layout-list',
            self::GRID => 'table-layout-grid',
        };
    }
}
```

### Perché TransTrait è Obbligatorio

1. **DRY Principle**: Elimina duplicazione di codice
2. **Framework Consistency**: Approccio uniforme in tutti gli enum
3. **Automatic Fallbacks**: Meccanismi di fallback integrati
4. **Performance**: Cache delle traduzioni ottimizzata
5. **Maintainability**: Logica di traduzione centralizzata

## Scopo e Funzionalità

### Obiettivo Principale
- **Gestione Layout**: Fornisce un enum tipizzato per gestire i layout delle tabelle
- **Interfaccia Filament**: Implementa le interfacce `HasColor`, `HasIcon`, `HasLabel` per integrazione nativa
- **Responsive Design**: Supporta configurazioni responsive per diversi dispositivi
- **Type Safety**: Garantisce type safety completo con PHP 8.1+ enum

### Funzionalità Core

#### 1. Layout Types
```php
enum TableLayoutEnum: string
{
    case LIST = 'list';  // Layout tradizionale a righe
    case GRID = 'grid';  // Layout a griglia responsive
}
```

#### 2. Interfacce Filament
```php
implements HasColor, HasIcon, HasLabel
```
- `HasColor`: Fornisce colori per UI
- `HasIcon`: Fornisce icone per UI
- `HasLabel`: Fornisce etichette tradotte

#### 3. Metodi di Traduzione (TransTrait)
```php
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
```

## File di Traduzione

### Struttura Obbligatoria
```php
// Modules/UI/lang/it/table-layout.php
return [
    'list' => [
        'label' => 'Lista',
        'color' => 'primary',
        'icon' => 'heroicon-o-list-bullet',
        'description' => 'Visualizzazione tradizionale a righe',
        'tooltip' => 'Mostra i dati in righe di tabella',
        'helper_text' => 'Layout ottimizzato per dati tabellari',
    ],
    'grid' => [
        'label' => 'Griglia',
        'color' => 'secondary',
        'icon' => 'heroicon-o-squares-2x2',
        'description' => 'Visualizzazione a griglia responsive',
        'tooltip' => 'Mostra i dati in formato griglia con card',
        'helper_text' => 'Layout ottimizzato per dispositivi mobili',
    ],
];
```

### Lingue Supportate
- `Modules/UI/lang/it/table-layout.php` (Italiano)
- `Modules/UI/lang/en/table-layout.php` (Inglese)
- `Modules/UI/lang/de/table-layout.php` (Tedesco)

## Utilizzo nelle Pagine Filament

### Esempio Completo
```php
<?php

declare(strict_types=1);

namespace Modules\Example\Filament\Resources\UserResource\Pages;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Xot\Filament\Traits\HasXotTable;

class ListUsers extends XotBaseListRecords
{
    use HasXotTable;

    protected static string $resource = UserResource::class;
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
            ->extraAttributes([
                'class' => $this->layout->getContainerClasses(),
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
                ->dateTime()
                ->sortable(),
        ];

        $gridColumns = [
            Tables\Columns\Layout\Stack::make([
                Tables\Columns\TextColumn::make('name')
                    ->weight(\Filament\Support\Enums\FontWeight::Bold)
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

## API Reference

### Metodi Principali

#### `init(): self`
Restituisce il layout di default (LIST).

#### `toggle(): self`
Alterna tra LIST e GRID.

#### `isListLayout(): bool`
Verifica se il layout corrente è LIST.

#### `isGridLayout(): bool`
Verifica se il layout corrente è GRID.

#### `getTableContentGrid(): ?array`
Restituisce la configurazione responsive per il layout griglia.

#### `getTableColumns(array $listColumns, array $gridColumns): array`
Restituisce le colonne appropriate per il layout corrente.

#### `getOptions(): array`
Restituisce tutte le opzioni di layout come array.

#### `getContainerClasses(): string`
Restituisce le classi CSS per il styling del container.

### Metodi di Traduzione (TransTrait)

#### `getLabel(): string`
Restituisce l'etichetta tradotta per il layout.

#### `getColor(): string`
Restituisce il colore per il layout.

#### `getIcon(): string`
Restituisce l'icona per il layout.

#### `getDescription(): string`
Restituisce la descrizione tradotta per il layout.

#### `getTooltip(): string`
Restituisce il tooltip tradotto per il layout.

#### `getHelperText(): string`
Restituisce il testo di aiuto tradotto per il layout.

## Configurazione Responsive

### Layout Griglia
```php
[
    'sm' => 1,   // 1 colonna su schermi piccoli
    'md' => 2,   // 2 colonne su schermi medi
    'lg' => 3,   // 3 colonne su schermi grandi
    'xl' => 4,   // 4 colonne su schermi extra grandi
    '2xl' => 5,  // 5 colonne su schermi 2xl
]
```

### CSS Classes
```css
.table-layout-list {
    /* Stili per layout lista */
}

.table-layout-grid {
    /* Stili per layout griglia */
    display: grid;
    gap: 1rem;
}
```

## Best Practices

### 1. Implementazione Enum
- **SEMPRE** usare `TransTrait`
- **SEMPRE** usare `transClass()` per le traduzioni
- **MAI** implementare traduzioni manualmente
- **MAI** usare `match()` per le traduzioni

### 2. File di Traduzione
- Struttura espansa obbligatoria
- Tutte le lingue supportate
- Chiavi in inglese, valori nella lingua target

### 3. Utilizzo nelle Pagine
- Inizializzare layout nel `mount()`
- Usare `toggle()` per cambiare layout
- Reset table dopo cambio layout

### 4. Testing
- Testare tutti i metodi dell'enum
- Verificare traduzioni
- Controllare cambio layout

## Troubleshooting

### Problema: Traduzioni non visualizzate
**Soluzione**: Verificare che il file di traduzione esista e contenga le chiavi corrette.

### Problema: Layout non cambia
**Soluzione**: Verificare che il metodo `toggle()` sia chiamato correttamente.

### Problema: Errori PHPStan
**Soluzione**: Verificare che tutti i metodi abbiano tipi di ritorno espliciti.

## Collegamenti

- [TransTrait Documentation](../../Xot/docs/filament/trans-trait.md)
- [UI Module Architecture](architecture_rules.md)
- [Filament Best Practices](../../../docs/filament_best_practices.md)
- [Translation Standards](../../../docs/translation_standards.md)
- [Table Components](table-components.md)

---

**Ultimo aggiornamento**: Gennaio 2025
**Versione**: 2.0.0
**Compatibilità**: Filament 3.x, Laravel 10.x, PHP 8.1+
