# TableLayoutEnum - Sistema di Layout per Tabelle Filament

## Panoramica

Il `TableLayoutEnum` è un componente fondamentale del modulo UI che fornisce un sistema standardizzato per gestire i layout delle tabelle in Filament. Permette agli utenti di alternare tra visualizzazioni a lista e a griglia, migliorando l'esperienza utente e la flessibilità dell'interfaccia.

## Posizione e Implementazione

### File Principale
- **Posizione**: `laravel/Modules/UI/app/Enums/TableLayoutEnum.php`
- **Namespace**: `Modules\UI\Enums`
- **Tipo**: Enum con interfacce Filament

### Caratteristiche Tecniche
- **Strict Types**: `declare(strict_types=1);`
- **Interfacce**: `HasColor`, `HasIcon`, `HasLabel`
- **Layout**: LIST (lista) e GRID (griglia)
- **Responsive**: Configurazione automatica per diversi dispositivi

## Funzionalità Principali

### 1. Gestione Layout
- **LIST**: Visualizzazione tradizionale a tabella con righe e colonne
- **GRID**: Visualizzazione a griglia con carte responsive
- **Toggle**: Alternanza automatica tra i due layout

### 2. Responsive Design
```php
// Configurazione responsive per GRID layout
[
    'sm' => 1,   // Mobile: 1 colonna
    'md' => 2,   // Tablet: 2 colonne
    'lg' => 3,   // Desktop piccolo: 3 colonne
    'xl' => 4,   // Desktop medio: 4 colonne
    '2xl' => 5,  // Desktop grande: 5 colonne
]
```

### 3. Traduzioni
- **File**: `laravel/Modules/UI/lang/it/table-layout.php`
- **Struttura**: Label, description, tooltip per ogni layout
- **Supporto**: Italiano, Inglese, Tedesco

## Utilizzo nelle Classi Filament

### Pattern Standard
```php
use Modules\UI\Enums\TableLayoutEnum;

class YourResourceListRecords extends XotBaseListRecords
{
    protected TableLayoutEnum $layout = TableLayoutEnum::LIST;

    public function table(Table $table): Table
    {
        return $table
            ->columns($this->getColumnsForLayout())
            ->contentGrid($this->layout->getTableContentGrid())
            ->actions([
                Tables\Actions\Action::make('toggleLayout')
                    ->icon($this->layout->getIcon())
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
        ];

        $gridColumns = [
            Tables\Columns\Layout\Stack::make([
                Tables\Columns\TextColumn::make('name')
                    ->weight(\Filament\Support\Enums\FontWeight::Bold),
                Tables\Columns\TextColumn::make('email'),
            ]),
        ];

        return $this->layout->getTableColumns($listColumns, $gridColumns);
    }
}
```

## Metodi Principali

### `getLabel()`
Restituisce l'etichetta tradotta per l'interfaccia utente.

### `getColor()`
Assegna colori specifici per ogni layout (primary per LIST, secondary per GRID).

### `getIcon()`
Fornisce icone Heroicon per i controlli (list-bullet per LIST, squares-2x2 per GRID).

### `toggle()`
Alterna tra i due layout disponibili.

### `getTableContentGrid()`
Restituisce la configurazione responsive per il layout GRID.

### `getTableColumns()`
Seleziona le colonne appropriate in base al layout corrente.

## Best Practices

### 1. Definizione Colonne
- **List Columns**: Usare colonne standard per dati strutturati
- **Grid Columns**: Usare `Layout\Stack` per contenuti complessi
- **Separazione**: Mantenere logica separata per ogni layout

### 2. Performance
- **Lazy Loading**: Caricare colonne solo quando necessario
- **Caching**: Memorizzare il layout preferito dell'utente
- **Optimization**: Minimizzare il numero di colonne per il grid

### 3. Accessibilità
- **ARIA Labels**: Fornire etichette appropriate per screen reader
- **Keyboard Navigation**: Supportare navigazione da tastiera
- **Focus Management**: Gestire correttamente il focus

## Regole Critiche

### 1. Estensione Classi
- **SEMPRE** estendere `XotBaseListRecords` invece di `ListRecords`
- **MAI** estendere direttamente classi Filament

### 2. Traduzioni
- **SEMPRE** usare file di traduzione invece di `->label()`
- **SEMPRE** struttura espansa per tutti i campi
- **SEMPRE** sincronizzare tra lingue IT/EN/DE

### 3. Type Safety
- **SEMPRE** `declare(strict_types=1);`
- **SEMPRE** tipi espliciti per metodi e proprietà
- **SEMPRE** PHPDoc completo

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

## Collegamenti

- [Documentazione Completa TableLayoutEnum](../../laravel/Modules/UI/docs/table-layout-enum-complete-guide.md)
- [Modulo UI](../../laravel/Modules/UI/docs/README.md)
- [Enum Standards](enum_standards.md)
- [Filament Best Practices](filament-widget-best-practices.md)

## Ultimo Aggiornamento
2025-01-27 - Documentazione TableLayoutEnum nella root docs
