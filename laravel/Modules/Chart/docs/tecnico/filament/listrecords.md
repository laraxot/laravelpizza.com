# ListRecords in Filament

## Struttura Base

### XotBaseListRecords
- Classe base per tutte le pagine di lista
- Gestisce la logica comune
- Implementa i metodi standard
- Definisce il comportamento base

### Metodi Standard
1. `getTableColumns()`: Definisce le colonne della tabella
2. `getTableFilters()`: Definisce i filtri della tabella
3. `getTableActions()`: Definisce le azioni della tabella
4. `getTableBulkActions()`: Definisce le azioni bulk

## Implementazione

### Table Columns
```php
public function getTableColumns(): array
{
    return [
        'id' => TextColumn::make('id'),
        'name' => TextColumn::make('name')
            ->searchable()
            ->sortable(),
    ];
}
```

### Layout
```php
public function table(Table $table): Table
{
    return $table
        ->columns($this->layoutView->getTableColumns())
        ->contentGrid($this->layoutView->getTableContentGrid());
}
```

## Metodi Deprecati

### ❌ NON USARE
- `getListTableColumns()` - DEPRECATO
- `getGridTableColumns()` - DEPRECATO

### ✅ USARE
- `getTableColumns()` con layout appropriato

## Pattern Standard

### Traduzioni
```php
// File: lang/it/resources.php
return [
    'fields' => [
        'name' => ['label' => 'Nome'],
        'email' => ['label' => 'Email'],
    ],
];
```

### Layout
```php
protected function getTableColumns(): array
{
    return [
        'id' => TextColumn::make('id'),
        'name' => TextColumn::make('name'),
    ];
}
```

## Best Practices

1. **Responsabilità**
   - XotBaseListRecords gestisce la logica comune
   - Pagine specifiche gestiscono SOLO le colonne
   - Traduzioni gestite tramite file di lingua
   - Layout gestito tramite configurazione

2. **Manutenzione**
   - Verificare aggiornamenti Filament
   - Controllare metodi deprecati
   - Aggiornare documentazione
   - Mantenere codice pulito

3. **Performance**
   - Minimizzare codice
   - Evitare duplicazioni
   - Usare cache quando possibile
   - Ottimizzare query

4. **Sicurezza**
   - Validare input
   - Gestire permessi
   - Proteggere dati sensibili
   - Logging appropriato 