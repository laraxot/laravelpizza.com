# ExportXlsByLazyCollection

## Descrizione
Questa action esporta una `LazyCollection` in formato Excel utilizzando il pacchetto Maatwebsite/Laravel-Excel. È progettata per gestire grandi set di dati in modo efficiente grazie all'utilizzo delle lazy collections.

## Struttura
```php
class ExportXlsByLazyCollection
{
    use QueueableAction;

    public function execute(
        LazyCollection $collection,
        string $filename = 'test.xlsx',
        array $fields = [],
    ): BinaryFileResponse;
}
```

## Funzionalità
1. Esportazione di dati in formato Excel
2. Supporto per:
   - Lazy loading dei dati
   - Gestione efficiente della memoria
   - Personalizzazione dei campi da esportare
   - Nomi file personalizzati
3. Integrazione con:
   - Maatwebsite/Laravel-Excel
   - Spatie Queueable Actions
   - Laravel Collections

## Parametri
- `collection`: LazyCollection - La collezione di dati da esportare
- `filename`: string - Nome del file Excel (default: 'test.xlsx')
- `fields`: array<int, string> - Lista dei campi da includere nell'export

## Return Value
- `BinaryFileResponse` - Risposta HTTP contenente il file Excel

## Best Practices Implementate
1. Utilizzo di strict types
2. Gestione efficiente della memoria con lazy collections
3. Supporto per code tramite QueueableAction
4. Validazione e conversione dei campi
5. Supporto per PHPStan livello 9

## Esempio di Utilizzo
```php
$action = new ExportXlsByLazyCollection();

$collection = User::cursor(); // LazyCollection di utenti
$fields = ['id', 'name', 'email'];

$response = $action->execute(
    collection: $collection,
    filename: 'users.xlsx',
    fields: $fields
);

return $response; // Scarica il file Excel
```

## Note di Sviluppo
- Utilizzare sempre lazy collections per grandi set di dati
- Specificare i campi da esportare per ottimizzare le performance
- Considerare l'utilizzo di code per export di grandi dimensioni
- Gestire correttamente la memoria con chunk se necessario

## ExportXlsByView

> **Nota:** Anche la action `ExportXlsByView` segue le stesse regole di tipizzazione e best practice di questa action. In particolare, il mapping dei campi da esportare è stato corretto per rispettare le regole Laraxot/<nome progetto> e PHPStan livello 9, utilizzando controllo esplicito del tipo invece di cast diretto.

- Link bidirezionale: [Vai a PHPSTAN-FIXES-SUMMARY.md](../../../../project_docs/PHPSTAN-FIXES-SUMMARY.md)

## Collegamenti
- [Laravel Excel Documentation](https://docs.laravel-excel.com)
- [Spatie Queueable Action](../traits/QUEUEABLE-ACTION.md)
- [Performance Guidelines](../PERFORMANCE-GUIDELINES.md)
- [Actions Overview](./README.md) 
- [PHPStan Fixes Summary](../../../../project_docs/PHPSTAN-FIXES-SUMMARY.md)