# Convenzioni per le Table Actions in Filament

## Regola Fondamentale
Tutte le azioni delle tabelle in Filament devono avere chiavi di tipo stringa nell'array restituito dai metodi getTable*Actions().

## Metodi Interessati
Questa convenzione si applica a tutti i seguenti metodi:
- `getTableHeaderActions()`
- `getTableActions()`
- `getBulkActions()`
- `getHeaderActions()`
- `getActions()`

## Esempi

### ✅ Corretto
```php
public function getTableHeaderActions(): array
{
    return [
        'add_new' => AddAction::make(),
        'export' => ExportAction::make(),
        'import' => ImportAction::make(),
    ];
}

public function getTableActions(): array
{
    return [
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
        'view' => ViewAction::make(),
    ];
}

public function getBulkActions(): array
{
    return [
        'delete_selected' => DeleteBulkAction::make(),
        'export_selected' => ExportBulkAction::make(),
    ];
}
```

### ❌ Errato
```php
public function getTableHeaderActions(): array
{
    return [
        AddAction::make(),      // NO! Chiave numerica implicita
        ExportAction::make(),   // NO! Chiave numerica implicita
    ];
}

public function getTableActions(): array
{
    return [
        0 => EditAction::make(),   // NO! Chiave numerica esplicita
        1 => DeleteAction::make(), // NO! Chiave numerica esplicita
    ];
}
```

## Motivazione
L'uso di chiavi stringa:
1. Migliora la leggibilità del codice
2. Facilita il riferimento alle azioni da altre parti del codice
3. Permette una migliore gestione delle autorizzazioni
4. Evita problemi di ordinamento non intenzionale
5. Facilita l'override delle azioni nelle classi figlie

## Convenzioni di Naming
Le chiavi devono:
- Essere in snake_case
- Essere descrittive dell'azione
- Essere in inglese
- Non contenere spazi o caratteri speciali
- Essere uniche all'interno dello stesso array

## Note Importanti
- Le chiavi devono essere significative e descrivere l'azione
- Non usare mai indici numerici, né impliciti né espliciti
- Mantenere coerenza nei nomi delle chiavi tra diverse classi
- Documentare eventuali chiavi personalizzate
- Le chiavi sono case-sensitive, mantenere la coerenza
