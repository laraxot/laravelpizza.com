# Correzioni Migrazione - Modulo Lang

## Problema Identificato

La migrazione `2025_03_20_000001_create_language_lines_table.php` non seguiva gli standard del progetto.

## Errori Originali

### ❌ Mancanza delle Proprietà Obbligatorie

```php
return new class extends XotBaseMigration {
    protected ?string $model_class = Translation::class;
    // Mancavano: $table e $connection
```

### ❌ Struttura Non Standard

- Mancava la documentazione completa
- Mancavano le verifiche di esistenza colonne
- Mancava la gestione corretta dei timestamp

## Correzioni Implementate

### ✅ Proprietà Obbligatorie Aggiunte

```php
/**
 * Nome della tabella.
 *
 * @var string
 */
protected string $table = 'language_lines';

/**
 * Connessione al database.
 *
 * @var string
 */
protected ?string $connection = 'mysql';

/**
 * Classe del modello associato.
 *
 * @var string|null
 */
protected ?string $model_class = Translation::class;
```

### ✅ Documentazione Completa

```php
/**
 * Migrazione per la creazione della tabella language_lines.
 * 
 * Questa tabella gestisce le traduzioni del sistema multilanguage,
 * memorizzando le chiavi di traduzione e i testi in formato JSON
 * per supportare multiple lingue.
 * 
 * @see docs/migration_standards.md
 */
```

### ✅ Verifiche di Esistenza

```php
$this->tableUpdate(
    function (Blueprint $table): void {
        // Verifica se le colonne esistono prima di aggiungerle
        if (! $this->hasColumn('group')) {
            $table->string('group')->index()->comment('Translation group (e.g., validation, auth)');
        }
        
        if (! $this->hasColumn('key')) {
            $table->string('key')->comment('Translation key');
        }
        
        if (! $this->hasColumn('text')) {
            $table->json('text')->comment('Translation text in JSON format');
        }
        
        if (! $this->hasColumn('locale')) {
            $table->string('locale')->index()->comment('Language locale (e.g., en, it, de)');
        }
        
        // Verifica se l'indice unique esiste
        if (! $this->hasIndex('language_lines_unique')) {
            $table->unique(['group', 'key', 'locale'], 'language_lines_unique');
        }
        
        $this->updateTimestamps($table, true);
    }
);
```

### ✅ Gestione Timestamps

```php
// Utilizziamo updateTimestamps per gestire created_at, updated_at e deleted_at
$this->updateTimestamps($table, true);
```

## Standard Seguiti

### 1. Estensione XotBaseMigration

✅ Tutte le migrazioni devono estendere `XotBaseMigration`

### 2. Proprietà Obbligatorie

✅ `$table` - Nome della tabella
✅ `$connection` - Connessione database
✅ `$model_class` - Classe del modello

### 3. Documentazione

✅ Commenti descriptivi per ogni campo
✅ Documentazione dello scopo della migrazione
✅ Riferimenti alla documentazione

### 4. Verifiche di Sicurezza

✅ `hasColumn()` per verificare esistenza colonne
✅ `hasIndex()` per verificare esistenza indici
✅ `tableCreate()` e `tableUpdate()` per gestione sicura

### 5. Performance

✅ Indici appropriati per query frequenti
✅ Indice unique per integrità dati
✅ Commenti per manutenzione

## Risultato Finale

La migrazione ora segue completamente gli standard del progetto:

- ✅ **Coerenza** con le altre migrazioni
- ✅ **Robustezza** con verifiche di esistenza
- ✅ **Performance** con indici ottimizzati
- ✅ **Manutenibilità** con documentazione completa
- ✅ **Scalabilità** per supportare multiple lingue

## Riferimenti

- [Standard Migrazioni](../../Xot/docs/migration_standards.md)
- [Best Practices Migrazioni Lang](migration_best_practices.md)
- [Documentazione Generale](../../Xot/docs/migration_guidelines.md)

## Lezioni Apprese

1. **Sempre verificare le proprietà obbligatorie** (`$table`, `$connection`)
2. **Utilizzare sempre `updateTimestamps()`** per gestire i timestamp
3. **Implementare verifiche di esistenza** per evitare errori
4. **Documentare completamente** lo scopo e la struttura
5. **Seguire gli standard del progetto** per coerenza

La migrazione è ora corretta e pronta per l'uso! 🚀 