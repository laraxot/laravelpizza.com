# HasXotTable Trait

Il trait `HasXotTable` fornisce funzionalità avanzate per la gestione delle tabelle in Filament, con supporto per traduzioni e una struttura ottimizzata.

## Caratteristiche Principali

- Gestione layout tabella (List/Grid)
- Azioni di intestazione personalizzabili
- Supporto per associazioni e relazioni
- Filtri e ricerca avanzati
- Azioni in bulk configurabili
- Supporto multilingua integrato

## Configurazione Base

```php
use Modules\Xot\Filament\Traits\HasXotTable;

class YourResource extends Resource
{
    use HasXotTable;

    protected static bool $canReplicate = false;
    protected static bool $canView = true;
    protected static bool $canEdit = true;
}
```

## Metodi Principali

### Azioni di Intestazione
```php
public function getTableHeaderActions(): array
{
    // Definisce le azioni disponibili nell'intestazione della tabella
    // - Create
    // - Associate (opzionale)
    // - Attach (opzionale)
    // - Layout Toggle
}
```

### Colonne
```php
public function getListTableColumns(): array
{
    return [
        // Esempio di colonna standard
        Tables\Columns\TextColumn::make('name')
            ->label('Nome')
            ->sortable()
            ->searchable(),
            
        // Esempio di colonna domain-specific come WorkerColumn
        // È FONDAMENTALE PRESERVARE COLONNE CUSTOM COME QUESTA
        WorkerColumn::make('worker_data')
            ->label('Dati Lavoratore')
            ->view('filament.tables.columns.worker-data'), // Esempio di vista custom
    ];
}

public function getGridTableColumns(): array
{
    return [
        // Le colonne in griglia devono anch'esse essere array associativi
        'name' => Tables\Columns\TextColumn::make('name')
            ->label('Nome'),
        'worker_info' => WorkerColumn::make('worker_info')
            ->label('Info Lavoratore'),
    ];
}
```

#### Regola Critica: Array Associativi per le Colonne
- I metodi che definiscono le colonne (es. `getListTableColumns()`, `getGridTableColumns()`, o `getTableColumns()` quando overrideati in RelationManagers o Pagine) **DEVONO** restituire un array associativo.
- Ogni chiave dell'array deve essere una stringa che rappresenta l'identificatore univoco della colonna.
- Il valore associato deve essere la definizione della colonna (es. `TextColumn::make(...)` o `WorkerColumn::make(...)`).
- **❌ ERRATO**: Array con indici numerici diretti.
- **✅ CORRETTO**: `return ['column_key' => TextColumn::make('column_name'), ...];`


### Filtri
```php
public function getTableFilters(): array
{
    // Definisce i filtri disponibili
}

public function getTableFiltersFormColumns(): int
{
    // Definisce il numero di colonne nel form dei filtri
}
```

## Best Practices

1. **Personalizzazione delle Azioni**
   - Utilizzare i metodi `shouldShow*Action()` per controllare la visibilità delle azioni
   - Implementare azioni personalizzate estendendo le classi base di Filament

2. **Gestione del Layout**
   - Utilizzare `TableLayoutEnum` per definire il layout predefinito
   - Implementare layout responsivi con Stack per il layout griglia

3. **Ottimizzazione delle Performance**
   - Definire indici appropriati per le colonne di ricerca
   - Utilizzare eager loading per le relazioni visualizzate

4. **Internazionalizzazione**
   - Utilizzare il sistema di traduzioni di Laravel
   - Definire le chiavi di traduzione in modo coerente

## Eventi e Hook

- `configureEmptyTable`: Personalizza la tabella quando è vuota
- `notifyTableMissing`: Gestisce la notifica quando la tabella non esiste
- `getModelClass`: Recupera la classe del modello associato

## Dipendenze

- Filament Tables
- Filament Actions
- Webmozart Assert
- Modules UI

## Note di Sviluppo

- Il trait supporta sia layout lista che griglia
- Le azioni di bulk sono configurabili tramite `getTableBulkActions()`
- Il sistema di ricerca è personalizzabile tramite `getSearchableColumns()`

## Link Correlati

- [Documentazione Filament](../../../../../../../docs/filament/index.md)
- [Gestione Tabelle](../../../../../../../docs/filament/tables.md)
- [Azioni Personalizzate](../../../../../../../docs/filament/actions.md)
