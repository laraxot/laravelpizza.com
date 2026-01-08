# Deprecazione Comandi MCP e Migrazione Azioni Database

## Panoramica

Questo documento descrive le modifiche apportate al modulo Xot riguardo alla deprecazione dei comandi MCP e alla migrazione delle azioni database al modulo DbForge.

## Modifiche Apportate

### 1. Deprecazione Comandi MCP

I seguenti comandi MCP sono stati rinominati con estensione `.old` e sono considerati deprecati:

- `McpValidateCommand.php` → `McpValidateCommand.php.old`
- `McpServerCommand.php` → `McpServerCommand.php.old`
- `McpCheckCommand.php` → `McpCheckCommand.php.old`

**Motivazione**: I comandi MCP sono stati temporaneamente disabilitati per revisione e ottimizzazione. Potrebbero essere riattivati in futuro con una nuova implementazione.

**Data di deprecazione**: Giugno 2025

### 2. Migrazione Azioni Database

Le seguenti azioni relative al database sono state migrate dal modulo Xot al modulo DbForge:

#### Comandi Migrati:
- `DatabaseBackUpCommand.php` - Backup del database MySQL
- `ExecuteSqlFileCommand.php` - Esecuzione di file SQL
- `DatabaseSchemaExportCommand.php` - Esportazione schema database in JSON
- `DatabaseSchemaExporterCommand.php` - Esportazione completa schema database
- `GenerateDbDocumentationCommand.php` - Generazione documentazione database
- `GenerateModelsFromSchemaCommand.php` - Generazione modelli da schema
- `ImportMdbToMySQL.php` - Import da MDB a MySQL
- `ImportMdbToSQLite.php` - Import da MDB a SQLite
- `ViewDatabaseConfigCommand.php` - Visualizzazione configurazione database

#### Namespace Aggiornati:
Tutti i comandi migrati hanno avuto il namespace aggiornato da:
```php
namespace Modules\Xot\Console\Commands;
```
a:
```php
namespace Modules\DbForge\Console\Commands;
```

## Motivazione della Migrazione

### Separazione delle Responsabilità
- **Modulo Xot**: Funzionalità core e infrastrutturali
- **Modulo DbForge**: Operazioni specifiche sul database

### Benefici
1. **Organizzazione più chiara**: Ogni modulo ha responsabilità ben definite
2. **Manutenibilità migliorata**: Le operazioni database sono centralizzate
3. **Riusabilità**: Il modulo DbForge può essere utilizzato da altri progetti
4. **Testing isolato**: I test per le operazioni database sono separati

## Impatto sui Progetti

### Comandi Non Più Disponibili
I seguenti comandi non sono più disponibili dal modulo Xot:
```bash
# Comandi MCP deprecati
php artisan mcp:validate
php artisan xot:mcp-server
php artisan mcp:check

# Comandi database migrati (ora disponibili da DbForge)
php artisan database:backup
php artisan xot:execute-sql
php artisan db:schema:export
php artisan xot:export-db-schema
php artisan db:docs:generate
php artisan db:models:generate
```

### Nuovi Comandi Disponibili
I comandi database sono ora disponibili dal modulo DbForge:
```bash
# Backup database
php artisan database:backup

# Esecuzione SQL
php artisan xot:execute-sql

# Esportazione schema
php artisan db:schema:export

# Generazione documentazione
php artisan db:docs:generate

# Generazione modelli
php artisan db:models:generate
```

## Aggiornamento dei Progetti

### 1. Aggiornare i Service Provider
Se il progetto utilizza i comandi migrati, assicurarsi che il modulo DbForge sia registrato nel Service Provider principale.

### 2. Aggiornare i Test
I test che utilizzavano i comandi MCP o database devono essere aggiornati per utilizzare i nuovi namespace.

### 3. Aggiornare la Documentazione
Aggiornare la documentazione del progetto per riflettere i nuovi percorsi dei comandi.

## Roadmap Futura

### Comandi MCP
- [ ] Revisione dell'implementazione MCP
- [ ] Nuova implementazione con best practices aggiornate
- [ ] Reintroduzione graduale dei comandi MCP

### Modulo DbForge
- [ ] Espansione delle funzionalità database
- [ ] Aggiunta di nuovi comandi per gestione database
- [ ] Miglioramento della documentazione

## Collegamenti Correlati

- [Modulo DbForge](../DbForge/docs/)
- [Best Practices Database](../../docs/database-best-practices.md)
- [Architettura Moduli](../../docs/module-architecture.md)

## Note per gli Sviluppatori

1. **Non utilizzare i comandi MCP deprecati** in nuovi sviluppi
2. **Utilizzare il modulo DbForge** per tutte le operazioni database
3. **Aggiornare i test** per utilizzare i nuovi namespace
4. **Documentare le modifiche** quando si aggiungono nuove funzionalità

## Changelog

### Giugno 2025
- ✅ Deprecazione comandi MCP con estensione `.old`
- ✅ Migrazione azioni database al modulo DbForge
- ✅ Aggiornamento namespace per tutti i comandi migrati
- ✅ Creazione documentazione per le modifiche

---

*Ultimo aggiornamento: Giugno 2025* 