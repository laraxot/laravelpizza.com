# Standard per le Migrazioni in LaravelPizza

## Convenzioni di Nomenclatura

### CREATE - Creazione tabelle
```
{YYYY_MM_DD}_{HHMMSS}_create_{table_name}_table.php
```
Esempi:
- `2026_01_01_000000_create_users_table.php`
- `2026_01_01_000001_create_profiles_table.php`

### ADD - Aggiunta colonne
```
{YYYY_MM_DD}_{HHMMSS}_add_{column}_to_{table_name}_table.php
```
Esempi:
- `2026_02_13_172135_add_lang_to_users_table.php`
- `2026_02_17_180908_add_slug_to_events_table.php`

### CHANGE - Modifica colonne
```
{YYYY_MM_DD}_{HHMMSS}_change_{column}_in_{table_name}_table.php
```
Esempi:
- `2026_02_13_163329_change_profiles_id_to_uuid_table.php`

### FIX - Correzione colonne
```
{YYYY_MM_DD}_{HHMMSS}_fix_{column}_in_{table_name}_table.php
```
Esempi:
- `2026_02_13_171410_fix_causer_id_to_uuid_table.php`

---

## Principi Fondamentali

1. **Estensione della classe base**: Tutte le migrazioni devono estendere `XotBaseMigration`
2. **Proprietà obbligatorie**: Ogni migrazione deve definire `$model_class`
3. **Documentazione completa**: Ogni migrazione deve includere un docblock che descriva lo scopo
4. **Verifica delle tabelle correlate**: Prima di creare foreign keys, verificare sempre l'esistenza della tabella correlata
5. **Gestione dei timestamp**: Utilizzare sempre `$this->updateTimestamps()` per gestire i timestamp
6. **Nome file**: Il file DEVE terminare con `_table.php`

## Struttura Standard delle Migrazioni

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\NomeModello\Models\NomeModello;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Migrazione per [scopo della migrazione].
 *
 * @see docs/database/migrations.md
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = NomeModello::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Per creare una nuova tabella
        $this->tableCreate(function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nome_campo');
            $this->updateTimestamps($table, true); // true per soft deletes
        });

        // Per modificare una tabella esistente
        $this->tableUpdate(function (Blueprint $table) {
            if (! $this->hasColumn('nome_colonna')) {
                $table->string('nome_colonna')->nullable();
            }
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

- [Best Practices per le Migrazioni nel Modulo Patient](/laravel/modules/patient/project_docs/migration_best_practices.md)
- [Best Practices per le Migrazioni nel Modulo Tenant](/laravel/modules/tenant/project_docs/migration_best_practices.md)
- [Best Practices per le Migrazioni nel Modulo User](/laravel/modules/user/project_docs/migration_best_practices.md)

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
