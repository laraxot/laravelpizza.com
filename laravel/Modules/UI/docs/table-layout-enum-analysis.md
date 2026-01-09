# Analisi Completa TableLayoutEnum

## Data: 2025-01-06

## Panoramica

Il `TableLayoutEnum` è un enum PHP che gestisce i layout delle tabelle nei componenti Filament UI. Fornisce un sistema standardizzato per alternare tra visualizzazioni a lista e griglia con configurazioni responsive appropriate.

## Scopo e Funzionalità

### Obiettivo Principale
- **Gestione Layout**: Alternare tra layout lista e griglia
- **Responsive Design**: Configurazioni grid per diverse dimensioni schermo
- **Type Safety**: Implementazione con interfacce Filament per colori, icone e label
- **UX Consistency**: Esperienza utente coerente attraverso l'applicazione

### Caso d'Uso
```php
// Esempio di utilizzo in ListRecords
class ListUsers extends ListRecords
{
    protected TableLayoutEnum $layout = TableLayoutEnum::LIST;

    public function table(Table $table): Table
    {
        return $table
            ->columns($this->getColumnsForLayout())
            ->contentGrid($this->layout->getTableContentGrid());
    }
}
```

## Analisi Tecnica

### Interfacce Implementate
- `HasColor`: Fornisce colori per UI components
- `HasIcon`: Fornisce icone Heroicon
- `HasLabel`: Fornisce label tradotte

### Metodi Principali

#### 1. `init()` - Layout di Default
```php
public static function init(): self
{
    return self::LIST;
}
```
- **Scopo**: Fornisce layout predefinito
- **Valore**: `LIST` (layout tradizionale)

#### 2. `getLabel()` - Traduzioni
```php
public function getLabel(): string
{
    return match ($this) {
        self::LIST => __('ui::table-layout.list.label'),
        self::GRID => __('ui::table-layout.grid.label'),
    };
}
```
- **Scopo**: Label tradotte per UI
- **Dipendenze**: File traduzioni `ui::table-layout.*`

#### 3. `getColor()` - Colori UI
```php
public function getColor(): string
{
    return match ($this) {
        self::LIST => 'primary',
        self::GRID => 'secondary',
    };
}
```
- **Scopo**: Colori per componenti UI
- **Valori**: `primary` per lista, `secondary` per griglia

#### 4. `getIcon()` - Icone Heroicon
```php
public function getIcon(): string
{
    return match ($this) {
        self::LIST => 'heroicon-o-list-bullet',
        self::GRID => 'heroicon-o-squares-2x2',
    };
}
```
- **Scopo**: Icone per toggle buttons
- **Icone**: Lista e griglia con Heroicon

#### 5. `toggle()` - Alternanza Layout
```php
public function toggle(): self
{
    return match ($this) {
        self::LIST => self::GRID,
        self::GRID => self::LIST,
    };
}
```
- **Scopo**: Alternare tra layout
- **Pattern**: Bidirezionale LIST ↔ GRID

#### 6. `getTableContentGrid()` - Configurazione Responsive
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
- **Scopo**: Grid responsive per layout griglia
- **Breakpoints**: sm, md, lg, xl, 2xl
- **Colonne**: 1-5 colonne in base alla dimensione

#### 7. `getTableColumns()` - Colonne Dinamiche
```php
public function getTableColumns(array $listColumns, array $gridColumns): array
{
    return $this->isGridLayout() ? $gridColumns : $listColumns;
}
```
- **Scopo**: Selezionare colonne appropriate per layout
- **Parametri**: Array espliciti per type safety
- **Approccio**: Esplicito invece di debug_backtrace

## Architettura e Design Patterns

### 1. Enum Pattern
- **Vantaggi**: Type safety, immutabilità, centralizzazione
- **Uso**: Gestione stati layout con valori predefiniti

### 2. Strategy Pattern
- **Implementazione**: Metodi che cambiano comportamento in base al layout
- **Esempio**: `getTableColumns()` con strategie diverse per lista/griglia

### 3. Factory Pattern
- **Implementazione**: `getOptions()` crea array di opzioni
- **Uso**: Popolamento dropdown e select

### 4. Interface Segregation
- **Interfacce**: `HasColor`, `HasIcon`, `HasLabel`
- **Vantaggio**: Implementazione selettiva delle funzionalità

## Dipendenze e Integrazione

### Traduzioni Richieste
```php
// File: Modules/UI/lang/it/table-layout.php
return [
    'list' => [
        'label' => 'Lista',
        'description' => 'Visualizzazione a lista tradizionale',
        'tooltip' => 'Mostra elementi in formato lista',
    ],
    'grid' => [
        'label' => 'Griglia',
        'description' => 'Visualizzazione a griglia con card',
        'tooltip' => 'Mostra elementi in formato griglia',
    ],
];
```

### Integrazione Filament
- **Table Components**: Integrazione con `Filament\Tables`
- **Content Grid**: Supporto per `contentGrid()` method
- **Responsive Design**: Breakpoints Tailwind CSS

## Best Practices Implementate

### 1. Type Safety
- `declare(strict_types=1);`
- Type hints espliciti
- Return types specifici

### 2. PHPDoc Completo
- Documentazione per ogni metodo
- Esempi di utilizzo
- Collegamenti a documentazione correlata

### 3. Naming Conventions
- Metodi descrittivi (`isGridLayout()`, `isListLayout()`)
- Costanti chiare (`LIST`, `GRID`)
- Nomi file in minuscolo

### 4. Error Handling
- Match expressions per gestione sicura
- Valori di default appropriati
- Null safety per grid configuration

## Esempi di Utilizzo

### 1. ListRecords Implementation
```php
class ListUsers extends ListRecords
{
    protected TableLayoutEnum $layout;

    public function mount(): void
    {
        $this->layout = TableLayoutEnum::init();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('toggleLayout')
                ->icon($this->layout->getIcon())
                ->color($this->layout->getColor())
                ->label($this->layout->getLabel())
                ->action(function () {
                    $this->layout = $this->layout->toggle();
                }),
        ];
    }
}
```

### 2. Table Configuration
```php
public function table(Table $table): Table
{
    return $table
        ->columns($this->getColumnsForLayout())
        ->contentGrid($this->layout->getTableContentGrid())
        ->paginated([10, 25, 50])
        ->defaultSort('created_at', 'desc');
}
```

### 3. Column Selection
```php
protected function getColumnsForLayout(): array
{
    $listColumns = [
        Tables\Columns\TextColumn::make('name')->sortable(),
        Tables\Columns\TextColumn::make('email')->searchable(),
        Tables\Columns\TextColumn::make('created_at')->dateTime(),
    ];

    $gridColumns = [
        Tables\Columns\Layout\Stack::make([
            Tables\Columns\TextColumn::make('name')->weight(FontWeight::Bold),
            Tables\Columns\TextColumn::make('email'),
        ]),
    ];

    return $this->layout->getTableColumns($listColumns, $gridColumns);
}
```

## Considerazioni di Performance

### 1. Memory Usage
- **Enum**: Valori immutabili, memoria efficiente
- **Match**: Più veloce di switch per enum

### 2. CPU Usage
- **Match Expressions**: Ottimizzate dal compilatore PHP
- **Method Calls**: Minimi overhead

### 3. Network Impact
- **Responsive Grid**: CSS nativo, nessun JS aggiuntivo
- **Icon Loading**: Heroicon già caricato

## Sicurezza e Validazione

### 1. Input Validation
- **Enum Values**: Solo valori predefiniti validi
- **Type Safety**: Previene errori runtime

### 2. XSS Prevention
- **Label Translation**: Escape automatico da Laravel
- **Icon Names**: Stringhe sicure, non user input

### 3. CSRF Protection
- **Toggle Actions**: Protezione CSRF di Filament
- **Form Submissions**: Token automatici

## Testing Strategy

### 1. Unit Tests
```php
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
}
```

### 2. Integration Tests
- Test con componenti Filament reali
- Verifica responsive behavior
- Test traduzioni

## Roadmap e Miglioramenti

### 1. Short Term
- [ ] Implementare traduzioni mancanti
- [ ] Aggiungere test unitari completi
- [ ] Documentare esempi avanzati

### 2. Medium Term
- [ ] Supporto per layout personalizzati
- [ ] Animazioni di transizione
- [ ] Persistenza preferenze utente

### 3. Long Term
- [ ] Layout masonry
- [ ] Layout timeline
- [ ] Layout calendar

## Collegamenti

- [Usage Guide](table-layout-enum-usage.md)
- [Conflict Resolution](conflict-resolution-tablelayoutenum.md)
- [Translation Standards](../../../docs/translation_standards.md)
- [Filament Best Practices](../../../docs/filament_best_practices.md)

*Ultimo aggiornamento: 2025-01-06*
# Analisi Completa TableLayoutEnum

## Data: 2025-01-06

## Panoramica

Il `TableLayoutEnum` è un enum PHP che gestisce i layout delle tabelle nei componenti Filament UI. Fornisce un sistema standardizzato per alternare tra visualizzazioni a lista e griglia con configurazioni responsive appropriate.

## Scopo e Funzionalità

### Obiettivo Principale
- **Gestione Layout**: Alternare tra layout lista e griglia
- **Responsive Design**: Configurazioni grid per diverse dimensioni schermo
- **Type Safety**: Implementazione con interfacce Filament per colori, icone e label
- **UX Consistency**: Esperienza utente coerente attraverso l'applicazione

### Caso d'Uso
```php
// Esempio di utilizzo in ListRecords
class ListUsers extends ListRecords
{
    protected TableLayoutEnum $layout = TableLayoutEnum::LIST;

    public function table(Table $table): Table
    {
        return $table
            ->columns($this->getColumnsForLayout())
            ->contentGrid($this->layout->getTableContentGrid());
    }
}
```

## Analisi Tecnica

### Interfacce Implementate
- `HasColor`: Fornisce colori per UI components
- `HasIcon`: Fornisce icone Heroicon
- `HasLabel`: Fornisce label tradotte

### Metodi Principali

#### 1. `init()` - Layout di Default
```php
public static function init(): self
{
    return self::LIST;
}
```
- **Scopo**: Fornisce layout predefinito
- **Valore**: `LIST` (layout tradizionale)

#### 2. `getLabel()` - Traduzioni
```php
public function getLabel(): string
{
    return match ($this) {
        self::LIST => __('ui::table-layout.list.label'),
        self::GRID => __('ui::table-layout.grid.label'),
    };
}
```
- **Scopo**: Label tradotte per UI
- **Dipendenze**: File traduzioni `ui::table-layout.*`

#### 3. `getColor()` - Colori UI
```php
public function getColor(): string
{
    return match ($this) {
        self::LIST => 'primary',
        self::GRID => 'secondary',
    };
}
```
- **Scopo**: Colori per componenti UI
- **Valori**: `primary` per lista, `secondary` per griglia

#### 4. `getIcon()` - Icone Heroicon
```php
public function getIcon(): string
{
    return match ($this) {
        self::LIST => 'heroicon-o-list-bullet',
        self::GRID => 'heroicon-o-squares-2x2',
    };
}
```
- **Scopo**: Icone per toggle buttons
- **Icone**: Lista e griglia con Heroicon

#### 5. `toggle()` - Alternanza Layout
```php
public function toggle(): self
{
    return match ($this) {
        self::LIST => self::GRID,
        self::GRID => self::LIST,
    };
}
```
- **Scopo**: Alternare tra layout
- **Pattern**: Bidirezionale LIST ↔ GRID

#### 6. `getTableContentGrid()` - Configurazione Responsive
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
- **Scopo**: Grid responsive per layout griglia
- **Breakpoints**: sm, md, lg, xl, 2xl
- **Colonne**: 1-5 colonne in base alla dimensione

#### 7. `getTableColumns()` - Colonne Dinamiche
```php
public function getTableColumns(array $listColumns, array $gridColumns): array
{
    return $this->isGridLayout() ? $gridColumns : $listColumns;
}
```
- **Scopo**: Selezionare colonne appropriate per layout
- **Parametri**: Array espliciti per type safety
- **Approccio**: Esplicito invece di debug_backtrace

## Architettura e Design Patterns

### 1. Enum Pattern
- **Vantaggi**: Type safety, immutabilità, centralizzazione
- **Uso**: Gestione stati layout con valori predefiniti

### 2. Strategy Pattern
- **Implementazione**: Metodi che cambiano comportamento in base al layout
- **Esempio**: `getTableColumns()` con strategie diverse per lista/griglia

### 3. Factory Pattern
- **Implementazione**: `getOptions()` crea array di opzioni
- **Uso**: Popolamento dropdown e select

### 4. Interface Segregation
- **Interfacce**: `HasColor`, `HasIcon`, `HasLabel`
- **Vantaggio**: Implementazione selettiva delle funzionalità

## Dipendenze e Integrazione

### Traduzioni Richieste
```php
// File: Modules/UI/lang/it/table-layout.php
return [
    'list' => [
        'label' => 'Lista',
        'description' => 'Visualizzazione a lista tradizionale',
        'tooltip' => 'Mostra elementi in formato lista',
    ],
    'grid' => [
        'label' => 'Griglia',
        'description' => 'Visualizzazione a griglia con card',
        'tooltip' => 'Mostra elementi in formato griglia',
    ],
];
```

### Integrazione Filament
- **Table Components**: Integrazione con `Filament\Tables`
- **Content Grid**: Supporto per `contentGrid()` method
- **Responsive Design**: Breakpoints Tailwind CSS

## Best Practices Implementate

### 1. Type Safety
- `declare(strict_types=1);`
- Type hints espliciti
- Return types specifici

### 2. PHPDoc Completo
- Documentazione per ogni metodo
- Esempi di utilizzo
- Collegamenti a documentazione correlata

### 3. Naming Conventions
- Metodi descrittivi (`isGridLayout()`, `isListLayout()`)
- Costanti chiare (`LIST`, `GRID`)
- Nomi file in minuscolo

### 4. Error Handling
- Match expressions per gestione sicura
- Valori di default appropriati
- Null safety per grid configuration

## Esempi di Utilizzo

### 1. ListRecords Implementation
```php
class ListUsers extends ListRecords
{
    protected TableLayoutEnum $layout;

    public function mount(): void
    {
        $this->layout = TableLayoutEnum::init();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('toggleLayout')
                ->icon($this->layout->getIcon())
                ->color($this->layout->getColor())
                ->label($this->layout->getLabel())
                ->action(function () {
                    $this->layout = $this->layout->toggle();
                }),
        ];
    }
}
```

### 2. Table Configuration
```php
public function table(Table $table): Table
{
    return $table
        ->columns($this->getColumnsForLayout())
        ->contentGrid($this->layout->getTableContentGrid())
        ->paginated([10, 25, 50])
        ->defaultSort('created_at', 'desc');
}
```

### 3. Column Selection
```php
protected function getColumnsForLayout(): array
{
    $listColumns = [
        Tables\Columns\TextColumn::make('name')->sortable(),
        Tables\Columns\TextColumn::make('email')->searchable(),
        Tables\Columns\TextColumn::make('created_at')->dateTime(),
    ];

    $gridColumns = [
        Tables\Columns\Layout\Stack::make([
            Tables\Columns\TextColumn::make('name')->weight(FontWeight::Bold),
            Tables\Columns\TextColumn::make('email'),
        ]),
    ];

    return $this->layout->getTableColumns($listColumns, $gridColumns);
}
```

## Considerazioni di Performance

### 1. Memory Usage
- **Enum**: Valori immutabili, memoria efficiente
- **Match**: Più veloce di switch per enum

### 2. CPU Usage
- **Match Expressions**: Ottimizzate dal compilatore PHP
- **Method Calls**: Minimi overhead

### 3. Network Impact
- **Responsive Grid**: CSS nativo, nessun JS aggiuntivo
- **Icon Loading**: Heroicon già caricato

## Sicurezza e Validazione

### 1. Input Validation
- **Enum Values**: Solo valori predefiniti validi
- **Type Safety**: Previene errori runtime

### 2. XSS Prevention
- **Label Translation**: Escape automatico da Laravel
- **Icon Names**: Stringhe sicure, non user input

### 3. CSRF Protection
- **Toggle Actions**: Protezione CSRF di Filament
- **Form Submissions**: Token automatici

## Testing Strategy

### 1. Unit Tests
```php
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
}
```

### 2. Integration Tests
- Test con componenti Filament reali
- Verifica responsive behavior
- Test traduzioni

## Roadmap e Miglioramenti

### 1. Short Term
- [ ] Implementare traduzioni mancanti
- [ ] Aggiungere test unitari completi
- [ ] Documentare esempi avanzati

### 2. Medium Term
- [ ] Supporto per layout personalizzati
- [ ] Animazioni di transizione
- [ ] Persistenza preferenze utente

### 3. Long Term
- [ ] Layout masonry
- [ ] Layout timeline
- [ ] Layout calendar

## Collegamenti

- [Usage Guide](table-layout-enum-usage.md)
- [Conflict Resolution](conflict-resolution-tablelayoutenum.md)
- [Translation Standards](../../../docs/translation_standards.md)
- [Filament Best Practices](../../../docs/filament_best_practices.md)

*Ultimo aggiornamento: 2025-01-06*
