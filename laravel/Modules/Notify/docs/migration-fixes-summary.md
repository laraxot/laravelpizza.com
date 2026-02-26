# Riepilogo Correzioni Migrazioni e Server - Modulo Notify

## Data
2025-01-06

## Problemi Risolti

### 1. Tabella Cache Mancante
**Problema**: Errore `SQLSTATE[HY000]: General error: 1 no such table: cache` durante l'avvio del server Laravel.

**Causa**: Il database SQLite era vuoto e la tabella cache non era stata creata.

**Soluzione**: 
- Creata manualmente la tabella `cache` nel database SQLite
- Creata manualmente la tabella `cache_locks` nel database SQLite
- Eseguite le migrazioni per completare la struttura del database

**Comandi utilizzati**:
```bash
sqlite3 database/database.sqlite "CREATE TABLE IF NOT EXISTS cache (key TEXT PRIMARY KEY, value TEXT, expiration INTEGER);"
sqlite3 database/database.sqlite "CREATE TABLE IF NOT EXISTS cache_locks (key TEXT PRIMARY KEY, owner TEXT, expiration INTEGER);"
php artisan migrate --force
```

### 2. File Traduzione Mancante
**Problema**: Errore `File does not exist at path config/local/techplanner/lang/it/metatag.php`

**Causa**: Il sistema cerca file di traduzione in percorsi specifici per tenant che non esistevano.

**Soluzione**: 
- Creata la directory `config/local/techplanner/lang/it/`
- Copiato il file `metatag.php` da `config/localhost/lang/it/metatag.php`

**Comando utilizzato**:
```bash
mkdir -p config/local/techplanner/lang/it
cp config/localhost/lang/it/metatag.php config/local/techplanner/lang/it/metatag.php
```

### 3. Migrazione Workers Table - Duplicazione Colonne
**Problema**: Errore `SQLSTATE[HY000]: General error: 1 duplicate column name: created_at` nella migrazione `create_workers_table`.

**Causa**: La migrazione chiamava sia `$table->timestamps()` che `$this->updateTimestamps()`, causando duplicazione delle colonne timestamp.

**Soluzione**: 
- Rimossa la chiamata ridondante a `$table->timestamps()` nella sezione UPDATE
- Mantenuta solo la chiamata a `$this->updateTimestamps($table, true)` che gestisce correttamente i controlli di esistenza
- Riorganizzati i campi `created_by` e `updated_by` dopo la chiamata a `updateTimestamps()`

**File modificato**: `Modules/TechPlanner/database/migrations/2019_12_12_000004_create_workers_table.php`

**Modifiche applicate**:
```php
// Prima (ERRATO)
if (!$this->hasColumn('updated_at')) {
    $table->timestamps();
}
// ... altri campi ...
$this->updateTimestamps($table, true); // Duplica created_at e updated_at

// Dopo (CORRETTO)
// ... altri campi ...
$this->updateTimestamps($table, true); // Gestisce correttamente i timestamp
if (!$this->hasColumn('updated_by')) {
    $table->string('updated_by')->nullable()->after('updated_at');
}
if (!$this->hasColumn('created_by')) {
    $table->string('created_by')->nullable()->after('created_at');
}
```

## Verifica Finale

### Server Laravel
- ✅ Server avviato correttamente su `http://localhost:8000`
- ✅ Route caricate correttamente
- ✅ Configurazione cache funzionante
- ✅ Migrazioni eseguite con successo

### Database
- ✅ Tabella `cache` creata e funzionante
- ✅ Tabella `cache_locks` creata e funzionante
- ✅ Tutte le migrazioni eseguite senza errori

### File System
- ✅ File di traduzione creati nei percorsi corretti
- ✅ Struttura directory config corretta

## Pattern Identificati

### Pattern 1: Creazione Tabelle Cache Manuale
Quando il database è vuoto e Laravel usa cache database, può essere necessario creare manualmente le tabelle cache prima di eseguire le migrazioni.

### Pattern 2: File Traduzione Tenant-Specifici
Il sistema cerca file di traduzione in percorsi tenant-specifici (`config/local/{tenant}/lang/{locale}/`). Questi file devono essere creati o copiati dai template base.

### Pattern 3: Migrazioni con updateTimestamps()
Quando si usa `updateTimestamps()` di XotBaseMigration, non chiamare anche `$table->timestamps()` manualmente, poiché `updateTimestamps()` gestisce già i controlli di esistenza.

## Collegamenti

- [Troubleshooting](./troubleshooting.md)
- [PHPStan Level 10 Analysis](./phpstan-level10-analysis.md)
- [Index](./index.md)

*Ultimo aggiornamento: 2025-01-06*

