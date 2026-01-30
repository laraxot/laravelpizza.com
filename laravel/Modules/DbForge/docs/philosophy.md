# DbForge Module - Filosofia Completa

**Data Creazione**: 2025-01-18  
**Status**: Documentazione Filosofica Completa  
**Versione**: 1.0.0  
**Autore**: Analisi Completa del Sistema

---

## 📋 Indice Completo

1. [Panoramica Generale](#panoramica-generale)
2. [Filosofia e Principi](#filosofia-e-principi)
3. [Architettura](#architettura)
4. [Modelli e Relazioni](#modelli-e-relazioni)
5. [Pattern Architetturali](#pattern-architetturali)
6. [Workflow e Flussi](#workflow-e-flussi)
7. [Integrazioni](#integrazioni)
8. [Sicurezza](#sicurezza)
9. [Best Practices](#best-practices)

---

## Panoramica Generale

### Il Modulo DbForge

Il modulo **DbForge** fornisce strumenti avanzati per la gestione e manipolazione del database, incluse funzionalità per schema inspection, table management, index management, constraint management, custom migrations, query builder avanzato, e backup/restore automatizzati.

### Stack Tecnologico

- **Laravel Schema Builder**: Costruzione schema database
- **Laravel Migrations**: Sistema migrazioni Laravel
- **MySQL/PostgreSQL**: Database supportati
- **Query Builder**: Query builder avanzato
- **Backup System**: Sistema backup automatizzato

### Scopo Principale

1. **Schema Management**: Gestione schema database avanzata
2. **Table Management**: Creazione, modifica, eliminazione tabelle
3. **Index Management**: Gestione indici per ottimizzazione
4. **Constraint Management**: Gestione vincoli e relazioni
5. **Migration Management**: Gestione migrazioni custom
6. **Query Builder**: Query builder avanzato
7. **Backup & Restore**: Backup e restore automatizzati

---

## Filosofia e Principi

### Principio Fondamentale

**Il modulo DbForge è uno strumento di gestione database, non un ORM.**

### Comandamenti Sacri

#### 1. Schema è la Verità

**Comandamento**: Lo schema database è la fonte di verità, non i modelli.

**Violazione**: Modificare schema senza migration è eresia.

**Manifestazione**:
```php
// ✅ CORRETTO - Migration-based schema changes
Schema::table('users', function (Blueprint $table) {
    $table->string('new_column');
});

// ❌ ERESIA - Direct schema modification
DB::statement('ALTER TABLE users ADD COLUMN new_column VARCHAR(255)');
```

#### 2. Migration è Immutabile

**Comandamento**: Una volta eseguita, una migration non deve essere modificata.

**Violazione**: Modificare migration già eseguite è eresia.

**Manifestazione**:
```php
// ✅ CORRETTO - New migration for changes
// 2024_01_01_000001_add_column_to_users.php (already executed)
// 2024_01_02_000001_modify_column_in_users.php (new migration)

// ❌ ERESIA - Modify executed migration
// 2024_01_01_000001_add_column_to_users.php (modify after execution)
```

#### 3. Backup Prima di Modifiche

**Comandamento**: Sempre backup prima di modifiche schema critiche.

**Violazione**: Modificare schema senza backup è eresia.

**Manifestazione**:
```php
// ✅ CORRETTO - Backup before changes
$backup = DbForgeBackup::create(['backup_name' => 'pre_migration_backup']);
// ... schema changes ...

// ❌ ERESIA - No backup
// ... schema changes directly ...
```

#### 4. Index è per Performance

**Comandamento**: Indici sono per performance, non per logica.

**Violazione**: Usare indici per logica business è eresia.

**Manifestazione**:
```php
// ✅ CORRETTO - Index for performance
Schema::table('users', function (Blueprint $table) {
    $table->index('email'); // Performance optimization
});

// ❌ ERESIA - Index for business logic
Schema::table('users', function (Blueprint $table) {
    $table->unique('email'); // Business logic, not performance
});
```

#### 5. Connection è Isolata

**Comandamento**: DbForge usa connection database dedicata.

**Violazione**: Usare connection default per operazioni DbForge è eresia.

**Manifestazione**:
```php
// ✅ CORRETTO - Dedicated connection
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'dbforge';
}

// ❌ ERESIA - Default connection
abstract class BaseModel extends XotBaseModel
{
    // No connection specified
}
```

---

## Architettura

### Struttura Modulo

```
Modules/DbForge/
├── app/
│   ├── Models/
│   │   ├── BaseModel.php
│   │   ├── DbForgeMigration.php
│   │   ├── DbForgeBackup.php
│   │   ├── DbForgeSchema.php (TODO)
│   │   ├── DbForgeOperation.php
│   │   └── DbForgeQueryLog.php
│   ├── Console/
│   ├── Providers/
│   └── View/
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
└── docs/
```

### Inheritance Chain

```
Illuminate\Database\Eloquent\Model
    ↓
Modules\Xot\Models\XotBaseModel
    ↓
Modules\DbForge\Models\BaseModel
    ↓
DbForgeMigration / DbForgeBackup / etc.
```

**Regola Sacra**: Tutti i modelli DbForge estendono `BaseModel`, mai `XotBaseModel` direttamente.

### Connection Database

Il modulo usa una connection database dedicata: `dbforge`.

**Manifestazione**:
```php
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'dbforge';
}
```

---

## Modelli e Relazioni

### 1. DbForgeMigration

**Scopo**: Rappresenta migrazione custom gestita da DbForge.

**Proprietà Chiave**:
- `migration_name`: Nome migration
- `migration_path`: Path file migration
- `migration_type`: Tipo migration (create, modify, delete)
- `status`: Stato migration (pending, executed, failed, rolled_back)
- `batch`: Batch migration
- `created_by`: Utente creatore
- `executed_at`: Data esecuzione
- `metadata`: Metadata migration
- `settings`: Impostazioni migration

**Relazioni**: Nessuna relazione diretta (migration standalone)

**Stati**:
- `pending`: Migration in attesa
- `executed`: Migration eseguita
- `failed`: Migration fallita
- `rolled_back`: Migration rollback

### 2. DbForgeBackup

**Scopo**: Rappresenta backup database.

**Proprietà Chiave**:
- `backup_name`: Nome backup
- `backup_path`: Path file backup
- `backup_size`: Dimensione backup
- `backup_type`: Tipo backup (full, incremental, differential)
- `status`: Stato backup (pending, completed, failed)
- `retention_days`: Giorni retention
- `created_by`: Utente creatore
- `completed_at`: Data completamento
- `metadata`: Metadata backup
- `settings`: Impostazioni backup

**Relazioni**: Nessuna relazione diretta (backup standalone)

**Stati**:
- `pending`: Backup in attesa
- `completed`: Backup completato
- `failed`: Backup fallito

### 3. DbForgeSchema (TODO)

**Scopo**: Rappresenta schema database (tabelle, colonne, indici, vincoli).

**Status**: Model non ancora implementato, factory presente.

**Proprietà Chiave** (previste):
- `table_name`: Nome tabella
- `table_comment`: Commento tabella
- `engine`: Engine database (InnoDB, MyISAM, etc.)
- `collation`: Collation tabella
- `row_format`: Formato riga
- `table_rows`: Numero righe
- `avg_row_length`: Lunghezza media riga
- `data_length`: Dimensione dati
- `index_length`: Dimensione indici
- `metadata`: Metadata schema

**Relazioni**: Nessuna relazione diretta (schema standalone)

### 4. DbForgeOperation

**Scopo**: Rappresenta operazione database (query, alter, etc.).

**Proprietà Chiave**:
- `operation_type`: Tipo operazione (query, alter, create, drop)
- `operation_sql`: SQL operazione
- `status`: Stato operazione (pending, executed, failed)
- `execution_time`: Tempo esecuzione
- `rows_affected`: Righe affette
- `created_by`: Utente creatore
- `executed_at`: Data esecuzione
- `error_message`: Messaggio errore
- `metadata`: Metadata operazione
- `settings`: Impostazioni operazione

**Relazioni**: Nessuna relazione diretta (operation standalone)

**Stati**:
- `pending`: Operazione in attesa
- `executed`: Operazione eseguita
- `failed`: Operazione fallita

### 5. DbForgeQueryLog

**Scopo**: Rappresenta log query eseguite.

**Proprietà Chiave**:
- `query_sql`: SQL query
- `query_bindings`: Bindings query
- `execution_time`: Tempo esecuzione
- `rows_affected`: Righe affette
- `connection_name`: Nome connection
- `user_id`: Utente esecutore
- `executed_at`: Data esecuzione
- `metadata`: Metadata query

**Relazioni**:
- `user()`: BelongsTo User

---

## Pattern Architetturali

### 1. Migration Pattern

**Logica**: Migrazioni gestite tramite `DbForgeMigration` model.

**Manifestazione**:
```php
$migration = DbForgeMigration::create([
    'migration_name' => 'add_column_to_users',
    'migration_path' => database_path('migrations/2024_01_01_000001_add_column_to_users.php'),
    'migration_type' => 'modify',
    'status' => 'pending',
]);

// Execute migration
Artisan::call('migrate', ['--path' => $migration->migration_path]);
$migration->status = 'executed';
$migration->executed_at = now();
$migration->save();
```

**Filosofia**: Migrazioni tracciate e gestite centralmente, non solo tramite Artisan.

### 2. Backup Pattern

**Logica**: Backup gestiti tramite `DbForgeBackup` model.

**Manifestazione**:
```php
$backup = DbForgeBackup::create([
    'backup_name' => 'pre_migration_backup',
    'backup_type' => 'full',
    'status' => 'pending',
]);

// Create backup
Artisan::call('backup:run');
$backup->status = 'completed';
$backup->completed_at = now();
$backup->save();
```

**Filosofia**: Backup tracciati e gestiti centralmente, con retention automatica.

### 3. Operation Pattern

**Logica**: Operazioni database tracciate tramite `DbForgeOperation` model.

**Manifestazione**:
```php
$operation = DbForgeOperation::create([
    'operation_type' => 'alter',
    'operation_sql' => 'ALTER TABLE users ADD COLUMN new_column VARCHAR(255)',
    'status' => 'pending',
]);

// Execute operation
DB::statement($operation->operation_sql);
$operation->status = 'executed';
$operation->executed_at = now();
$operation->execution_time = $executionTime;
$operation->save();
```

**Filosofia**: Operazioni tracciate per audit e rollback.

---

## Workflow e Flussi

### 1. Migration Workflow

**Flusso**:
1. Creazione `DbForgeMigration` (status: pending)
2. Esecuzione migration (Artisan::call('migrate'))
3. Aggiornamento status (status: executed, executed_at)
4. Gestione errori (status: failed, error_message)

**Manifestazione**:
```php
// 1. Creazione migration
$migration = DbForgeMigration::create([
    'migration_name' => 'add_column_to_users',
    'migration_path' => database_path('migrations/2024_01_01_000001_add_column_to_users.php'),
    'migration_type' => 'modify',
    'status' => 'pending',
]);

// 2. Esecuzione migration
try {
    Artisan::call('migrate', ['--path' => $migration->migration_path]);
    $migration->status = 'executed';
    $migration->executed_at = now();
    $migration->save();
} catch (\Exception $e) {
    $migration->status = 'failed';
    $migration->metadata = ['error' => $e->getMessage()];
    $migration->save();
}
```

### 2. Backup Workflow

**Flusso**:
1. Creazione `DbForgeBackup` (status: pending)
2. Esecuzione backup (Artisan::call('backup:run'))
3. Aggiornamento status (status: completed, completed_at)
4. Gestione retention (eliminazione backup vecchi)

**Manifestazione**:
```php
// 1. Creazione backup
$backup = DbForgeBackup::create([
    'backup_name' => 'pre_migration_backup',
    'backup_type' => 'full',
    'status' => 'pending',
    'retention_days' => 30,
]);

// 2. Esecuzione backup
try {
    Artisan::call('backup:run');
    $backup->status = 'completed';
    $backup->completed_at = now();
    $backup->backup_size = filesize($backup->backup_path);
    $backup->save();
} catch (\Exception $e) {
    $backup->status = 'failed';
    $backup->metadata = ['error' => $e->getMessage()];
    $backup->save();
}

// 3. Gestione retention
DbForgeBackup::where('completed_at', '<', now()->subDays($backup->retention_days))
    ->delete();
```

### 3. Operation Workflow

**Flusso**:
1. Creazione `DbForgeOperation` (status: pending)
2. Esecuzione operazione (DB::statement())
3. Tracciamento performance (execution_time, rows_affected)
4. Aggiornamento status (status: executed, executed_at)

**Manifestazione**:
```php
// 1. Creazione operazione
$operation = DbForgeOperation::create([
    'operation_type' => 'alter',
    'operation_sql' => 'ALTER TABLE users ADD COLUMN new_column VARCHAR(255)',
    'status' => 'pending',
]);

// 2. Esecuzione operazione
$startTime = microtime(true);
try {
    DB::statement($operation->operation_sql);
    $executionTime = microtime(true) - $startTime;
    $operation->status = 'executed';
    $operation->executed_at = now();
    $operation->execution_time = $executionTime;
    $operation->rows_affected = DB::getPdo()->lastInsertId();
    $operation->save();
} catch (\Exception $e) {
    $operation->status = 'failed';
    $operation->error_message = $e->getMessage();
    $operation->save();
}
```

---

## Integrazioni

### 1. Laravel Migrations Integration

**Manifestazione**:
```php
Artisan::call('migrate', ['--path' => $migration->migration_path]);
```

**Filosofia**: Usa sistema migrazioni Laravel, traccia tramite DbForge.

### 2. Laravel Backup Integration

**Manifestazione**:
```php
Artisan::call('backup:run');
```

**Filosofia**: Usa sistema backup Laravel, traccia tramite DbForge.

### 3. Laravel Schema Builder Integration

**Manifestazione**:
```php
Schema::table('users', function (Blueprint $table) {
    $table->string('new_column');
});
```

**Filosofia**: Usa Schema Builder Laravel, traccia operazioni tramite DbForge.

---

## Sicurezza

### 1. Operation Tracking

**Principio**: Tutte le operazioni database devono essere tracciate.

**Manifestazione**:
```php
$operation = DbForgeOperation::create([
    'operation_type' => 'alter',
    'operation_sql' => $sql,
    'created_by' => auth()->id(),
]);
```

**Best Practice**: Traccia chi, cosa, quando per audit.

### 2. Backup Before Changes

**Principio**: Sempre backup prima di modifiche schema critiche.

**Manifestazione**:
```php
$backup = DbForgeBackup::create([
    'backup_name' => 'pre_migration_backup',
    'backup_type' => 'full',
]);
// ... schema changes ...
```

**Best Practice**: Backup automatico prima di modifiche critiche.

### 3. Permission Control

**Principio**: Solo utenti autorizzati possono eseguire operazioni database.

**Manifestazione**:
```php
if (Gate::allows('execute-db-operation')) {
    // Execute operation
}
```

**Best Practice**: Usa Laravel Policies per controllo accessi.

---

## Best Practices

### 1. Migration Immutability

**Pratica**: Mai modificare migration già eseguite.

**Esempio**:
```php
// ✅ CORRETTO - New migration for changes
// 2024_01_01_000001_add_column_to_users.php (already executed)
// 2024_01_02_000001_modify_column_in_users.php (new migration)

// ❌ SBAGLIATO - Modify executed migration
// 2024_01_01_000001_add_column_to_users.php (modify after execution)
```

### 2. Backup Before Changes

**Pratica**: Sempre backup prima di modifiche schema critiche.

**Esempio**:
```php
// ✅ CORRETTO
$backup = DbForgeBackup::create(['backup_name' => 'pre_migration_backup']);
// ... schema changes ...

// ❌ SBAGLIATO
// ... schema changes directly ...
```

### 3. Operation Tracking

**Pratica**: Traccia tutte le operazioni database.

**Esempio**:
```php
// ✅ CORRETTO
$operation = DbForgeOperation::create([
    'operation_type' => 'alter',
    'operation_sql' => $sql,
    'created_by' => auth()->id(),
]);

// ❌ SBAGLIATO
DB::statement($sql); // No tracking
```

### 4. Connection Isolation

**Pratica**: Usa connection dedicata per operazioni DbForge.

**Esempio**:
```php
// ✅ CORRETTO
protected $connection = 'dbforge';

// ❌ SBAGLIATO
// No connection specified
```

### 5. Error Handling

**Pratica**: Gestisci errori e traccia fallimenti.

**Esempio**:
```php
// ✅ CORRETTO
try {
    DB::statement($sql);
    $operation->status = 'executed';
} catch (\Exception $e) {
    $operation->status = 'failed';
    $operation->error_message = $e->getMessage();
}

// ❌ SBAGLIATO
DB::statement($sql); // No error handling
```

---

## Conclusioni

### Filosofia Completa

Il modulo DbForge è uno strumento avanzato per la gestione database che fornisce schema management, migration management, backup/restore, e operation tracking. Il modulo segue principi di immutabilità, tracciabilità, e sicurezza.

### Principi Fondamentali

1. **Schema è la Verità**: Schema database è fonte di verità
2. **Migration è Immutabile**: Mai modificare migration eseguite
3. **Backup Prima di Modifiche**: Sempre backup prima di modifiche critiche
4. **Index è per Performance**: Indici per performance, non logica
5. **Connection è Isolata**: Connection dedicata per DbForge

### Prossimi Passi

1. Implementare `DbForgeSchema` model
2. Aggiungere supporto per altri database (PostgreSQL, SQLite)
3. Implementare query builder avanzato
4. Aggiungere test coverage completo
5. Documentare API endpoints

---

**Ultimo Aggiornamento**: 2025-01-18  
**Versione**: 1.0.0

