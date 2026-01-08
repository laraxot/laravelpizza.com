# GetFieldnamesByTablenameAction

Questa action è responsabile del recupero dei nomi dei campi di una tabella del database.

## Caratteristiche Principali

- Recupero dinamico dei campi
- Supporto per diversi tipi di database
- Cache dei risultati per ottimizzare le performance
- Validazione del nome tabella

## Metodi

### `execute(string $tablename): array`

Metodo principale che recupera i nomi dei campi per la tabella specificata.

#### Parametri
- `$tablename`: Nome della tabella di cui recuperare i campi

#### Return
- `array`: Array contenente i nomi dei campi della tabella

## Schema Database

```php
// Esempio di struttura tabella supportata
Schema::create('example_table', function (Blueprint $table) {
    $table->id();
    $table->string('field1');
    $table->integer('field2');
    $table->timestamps();
});
```

## Best Practices

1. **Cache**
   - Utilizzare la cache per tabelle frequentemente accedute
   - Invalidare la cache quando la struttura della tabella cambia

2. **Validazione**
   - Verificare l'esistenza della tabella
   - Validare il nome della tabella per prevenire SQL injection
   - Gestire correttamente le eccezioni

3. **Performance**
   - Minimizzare le query al database
   - Utilizzare indici appropriati
   - Ottimizzare il recupero dei metadati

## Dipendenze

- Illuminate\Support\Facades\Schema
- Illuminate\Support\Facades\Cache
- Webmozart\Assert\Assert

## Esempio di Utilizzo

```php
$action = app(GetFieldnamesByTablenameAction::class);
$fields = $action->execute('users');

// Risultato esempio
[
    'id',
    'name',
    'email',
    'created_at',
    'updated_at'
]
```

## Note di Sviluppo

- Implementare la gestione degli errori
- Supportare diversi driver di database
- Mantenere la compatibilità con le versioni future di Laravel
- Documentare eventuali limitazioni o casi speciali 