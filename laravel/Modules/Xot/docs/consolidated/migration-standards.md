# Standard per le Migrazioni in <nome progetto>

## Introduzione

Questo documento definisce gli standard e le best practices da seguire per tutte le migrazioni nei moduli di <nome progetto>. Questi standard sono fondamentali per garantire la coerenza e la correttezza delle migrazioni in tutto il progetto.

## Principi Fondamentali

1. **Estensione della classe base**: Tutte le migrazioni devono estendere `XotBaseMigration`
2. **Proprietà obbligatorie**: Ogni migrazione deve definire le proprietà `$table` e `$connection`
3. **Documentazione completa**: Ogni migrazione deve includere una documentazione che descriva lo scopo della tabella
4. **Verifica delle tabelle correlate**: Prima di creare foreign keys, verificare sempre l'esistenza della tabella correlata
5. **Gestione dei timestamp**: Utilizzare sempre `$this->updateTimestamps()` per gestire i timestamp

## Struttura Standard delle Migrazioni

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Migrazione per [scopo della migrazione].
 * 
 * @see docs/standards/migrations.md
 */
return new class extends XotBaseMigration
{
    /**
     * Nome della tabella.
     *
     * @var string
     */
    protected string $table = 'nome_tabella';
    
    /**
     * Connessione al database.
     *
     * @var string
     */
    protected ?string $connection = 'mysql'; // o altra connessione appropriata

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table) {
            $table->id(); // o altro tipo di chiave primaria
            
            // Definizione dei campi
            
            // Utilizziamo updateTimestamps per gestire created_at, updated_at e deleted_at
            $this->updateTimestamps($table, true); // true per includere soft delete
            
            // Verifica se le tabelle correlate esistono prima di creare foreign keys
            if (Schema::connection($this->getConnection())->hasTable('tabella_correlata')) {
                $table->foreign('campo_id')
                    ->references('id')
                    ->on('tabella_correlata')
                    ->onDelete('cascade');
            }
            
            // Indici
            $table->index('campo_id');
        });
    }
};
```

## Connessioni al Database

<nome progetto> utilizza diverse connessioni al database per diversi tipi di dati:

1. **mysql**: Connessione principale per la maggior parte delle tabelle
2. **user**: Connessione per i dati degli utenti
3. **tenant**: Connessione per i dati specifici dei tenant

È fondamentale specificare la connessione corretta in ogni migrazione in base al tipo di dati che la tabella conterrà.

## Metodi Utili di XotBaseMigration

### tableCreate

Crea una nuova tabella se non esiste già:

```php
$this->tableCreate(function (Blueprint $table) {
    // Definizione dei campi
});
```

### tableUpdate

Aggiorna una tabella esistente:

```php
$this->tableUpdate(function (Blueprint $table) {
    // Aggiornamento dei campi
});
```

### updateTimestamps

Aggiunge i campi `created_at`, `updated_at` e opzionalmente `deleted_at`:

```php
$this->updateTimestamps($table, true); // true per includere soft delete
```

### hasColumn

Verifica se una colonna esiste nella tabella:

```php
if (! $this->hasColumn('nome_colonna')) {
    $table->string('nome_colonna')->nullable();
}
```

### hasIndex

Verifica se un indice esiste nella tabella:

```php
if (! $this->hasIndex('nome_indice')) {
    $table->index('campo', 'nome_indice');
}
```

## Best Practices Specifiche per Modulo

Ogni modulo può avere best practices specifiche per le migrazioni. Consultare la documentazione del modulo per ulteriori dettagli:

- [Best Practices per le Migrazioni nel Modulo Patient](/laravel/Modules/Patient/project_docs/MIGRATION_BEST_PRACTICES.md)
- [Best Practices per le Migrazioni nel Modulo Tenant](/laravel/Modules/Tenant/project_docs/MIGRATION_BEST_PRACTICES.md)
- [Best Practices per le Migrazioni nel Modulo User](/laravel/Modules/User/project_docs/MIGRATION_BEST_PRACTICES.md)

## Errori Comuni e Come Evitarli

### 1. Mancanza delle Proprietà Obbligatorie

**Errore**:
```php
return new class extends XotBaseMigration
{
    public function up(): void
    {
        // Mancano le proprietà $table e $connection
    }
};
```

**Correzione**:
```php
return new class extends XotBaseMigration
{
    protected string $table = 'nome_tabella';
    protected ?string $connection = 'mysql';
    
    public function up(): void
    {
        // ...
    }
};
```

### 2. Foreign Key su Tabella Inesistente

**Errore**:
```php
$table->foreign('user_id')
    ->references('id')
    ->on('users')
    ->onDelete('cascade');
```

**Correzione**:
```php
if (Schema::connection($this->getConnection())->hasTable('users')) {
    $table->foreign('user_id')
        ->references('id')
        ->on('users')
        ->onDelete('cascade');
} else {
    $this->outputWarning("La tabella 'users' non esiste nella connessione '{$this->getConnection()}'. La foreign key non è stata creata.");
    // Creiamo solo l'indice senza la foreign key
    $table->index('user_id');
}
```

### 3. Connessione Errata

**Errore**:
```php
protected ?string $connection = 'mysql'; // Ma il modello usa 'user'
```

**Correzione**:
```php
protected ?string $connection = 'user'; // Stessa connessione del modello
```

## Conclusione

Seguire questi standard per le migrazioni è fondamentale per garantire la coerenza e la correttezza del database in <nome progetto>. Assicurarsi di consultare sempre la documentazione specifica del modulo prima di creare o modificare una migrazione.
