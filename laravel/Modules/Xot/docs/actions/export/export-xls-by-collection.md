# ExportXlsByCollection

Questa action è responsabile dell'esportazione di collezioni di dati in formato Excel (XLSX). Supporta sia l'utilizzo di Maatwebsite/Excel che PhpSpreadsheet direttamente.

## Caratteristiche Principali

- Esportazione di collezioni Laravel in file Excel
- Supporto per traduzioni delle intestazioni
- Selezione dei campi da esportare
- Gestione asincrona tramite QueueableAction
- Supporto diretto a PhpSpreadsheet per casi specifici

## Metodi

### `execute(Collection $collection, string $filename, ?string $transKey, array $fields): BinaryFileResponse`

Esporta una collezione in Excel utilizzando Maatwebsite/Excel.

#### Parametri
- `$collection`: La collezione da esportare
- `$filename`: Nome del file Excel (default: 'test.xlsx')
- `$transKey`: Chiave di traduzione per i campi (opzionale)
- `$fields`: Array dei campi da includere nell'export

#### Return
- `BinaryFileResponse`: Risposta contenente il file Excel

### `executeWithSpreadsheet(Collection $rows, array $fields, string $filename): string`

Esporta una collezione utilizzando PhpSpreadsheet direttamente.

#### Parametri
- `$rows`: La collezione da esportare
- `$fields`: Array dei campi da includere
- `$filename`: Nome del file Excel

#### Return
- `string`: Percorso del file generato

## Schema Dati

La collezione di input deve essere strutturata in modo che ogni elemento:
- Supporti il metodo `get()`, o
- Sia un array/ArrayAccess, o
- Sia un oggetto con proprietà accessibili

```php
$collection = collect([
    ['nome' => 'Mario', 'età' => 30],
    ['nome' => 'Luigi', 'età' => 25]
]);
```

## Best Practices

1. **Gestione Memoria**
   - Utilizzare `executeWithSpreadsheet()` per grandi dataset
   - Implementare la paginazione per collezioni molto grandi

2. **Campi**
   - Specificare sempre i campi da esportare
   - Utilizzare nomi di campo chiari e descrittivi
   - Implementare traduzioni per interfacce multilingua

3. **Performance**
   - Utilizzare code per export di grandi dimensioni
   - Ottimizzare le query del database prima dell'export

## Dipendenze

- Illuminate\Support\Collection
- Maatwebsite\Excel\Facades\Excel
- PhpOffice\PhpSpreadsheet
- Spatie\QueueableAction\QueueableAction

## Esempio di Utilizzo

```php
$action = app(ExportXlsByCollection::class);

// Utilizzo base
$response = $action->execute(
    collection: $users,
    filename: 'users.xlsx',
    fields: ['id', 'name', 'email']
);

// Con traduzioni
$response = $action->execute(
    collection: $users,
    filename: 'users.xlsx',
    transKey: 'users',
    fields: ['id', 'name', 'email']
);

// Utilizzo diretto di PhpSpreadsheet
$filePath = $action->executeWithSpreadsheet(
    rows: $largeCollection,
    fields: ['id', 'name', 'email'],
    filename: 'large_export.xlsx'
);
```

## Note Tecniche

- L'action è marcata come `final` per prevenire l'estensione
- Utilizza strict typing per maggiore sicurezza
- Implementa QueueableAction per supporto asincrono
- Gestisce automaticamente la conversione dei tipi di campo 