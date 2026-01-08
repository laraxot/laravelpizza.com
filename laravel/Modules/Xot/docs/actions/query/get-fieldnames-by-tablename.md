# GetFieldnamesByTablenameAction

## Descrizione
Action che recupera i nomi delle colonne di una tabella specifica del database. Utilizza Spatie QueueableAction per la gestione asincrona delle operazioni.

## Caratteristiche Principali
- Recupero dei nomi delle colonne da una tabella specifica
- Supporto per connessioni database multiple
- Validazione robusta degli input
- Gestione degli errori dettagliata
- Implementazione asincrona tramite QueueableAction

## Metodi

### execute(string $table, ?string $connectionName = null): array
Il metodo principale che esegue il recupero dei nomi delle colonne.

#### Parametri
- `$table`: Nome della tabella da cui recuperare le colonne
- `$connectionName`: (opzionale) Nome della connessione database da utilizzare

#### Return
- `array`: Lista dei nomi delle colonne della tabella

#### Eccezioni
- `\InvalidArgumentException`: 
  - Se il nome della tabella è vuoto
  - Se la connessione database non è valida
  - Se la tabella non esiste nella connessione specificata
  - Se si verifica un errore durante il recupero delle colonne

### isValidConnection(string $connectionName): bool
Metodo privato per validare la connessione database.

## Dipendenze
- `Illuminate\Support\Facades\DB`
- `Illuminate\Support\Facades\Schema`
- `Spatie\QueueableAction\QueueableAction`
- `Webmozart\Assert\Assert`

## Esempio di Utilizzo
```php
$action = app(GetFieldnamesByTablenameAction::class);

// Utilizzo con connessione default
$columns = $action->execute('users');

// Utilizzo con connessione specifica
$columns = $action->execute('products', 'mysql_secondary');
```

## Best Practices
1. Utilizzare sempre try-catch per gestire le eccezioni
2. Validare sempre i parametri di input
3. Specificare la connessione database quando si lavora con database multipli
4. Utilizzare la coda per operazioni su tabelle grandi

## Note Tecniche
- L'action è marcata come `final` per prevenire l'estensione
- Utilizza strict typing per maggiore sicurezza
- Implementa QueueableAction per supporto asincrono
- Effettua validazioni approfondite prima di ogni operazione

## Test
Per testare l'action:
```php
php artisan test Modules/Xot/Tests/Actions/Query/GetFieldnamesByTablenameActionTest.php
``` 