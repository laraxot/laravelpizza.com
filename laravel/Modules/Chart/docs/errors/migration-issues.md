# Errori comuni nelle migrazioni

Questo documento descrive gli errori comuni riscontrati nelle migrazioni e come risolverli.

## Errori nella migrazione `2025_05_16_223200_create_doctor_validations_table.php`

### Problemi riscontrati:

1. **Metodi non definiti**
   - `$this->tableCreate()` non è un metodo di `XotBaseMigration`
   - `$this->addTimestamps()` non è un metodo di `XotBaseMigration`
   - `$this->tableDrop()` non è un metodo di `XotBaseMigration`
   - `$this->hasTable()` non è un metodo di `XotBaseMigration`

2. **Uso errato di Schema**
   - Le operazioni su Schema devono essere eseguite attraverso `Schema::connection($this->connection)`

3. **Gestione delle chiavi esterne**
   - Le chiavi esterne devono essere gestite con attenzione per evitare errori di integrità referenziale

## Soluzioni

### 1. Utilizzare i metodi corretti di Schema

Invece di utilizzare metodi non esistenti come `tableCreate` o `tableDrop`, utilizzare direttamente i metodi di `Schema` con la connessione corretta:

```php
Schema::connection($this->connection)->create($table, $callback);
Schema::connection($this->connection)->dropIfExists($table);
```

### 2. Verificare l'esistenza delle tabelle

Per verificare se una tabella esiste, utilizzare:

```php
Schema::connection($this->connection)->hasTable('table_name')
```

### 3. Aggiungere i timestamp

Invece di usare `$this->addTimestamps($table)`, usare direttamente:

```php
$table->timestamps();
```

## Best Practices per le migrazioni future

1. **Sempre estendere XotBaseMigration**
2. **Usare le proprietà della classe**
   - `protected string $table` per il nome della tabella
   - `protected $connection` per la connessione al database
3. **Documentare**
   - Aggiungere commenti PHPDoc
   - Documentare le relazioni e i vincoli
4. **Gestire gli errori**
   - Verificare l'esistenza delle tabelle prima di crearle o eliminarle
   - Usare transazioni per operazioni multiple

## Riferimenti

- [Documentazione ufficiale Laravel Migrations](https://laravel.com/docs/migrations)
- [Standard per le migrazioni](../standards/migrations.md)
