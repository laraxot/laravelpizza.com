# Best Practices per le Migrazioni - Modulo Lang

## Panoramica

Questo documento descrive le best practices specifiche per le migrazioni del modulo Lang, che gestisce il sistema di traduzioni multilanguage del progetto.

## Struttura Standard delle Migrazioni

### Template Base

Tutte le migrazioni del modulo Lang devono seguire questo template:

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Lang\Models\Translation;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Migrazione per [scopo della migrazione].
 * 
 * Questa migrazione gestisce [descrizione specifica].
 * 
 * @see docs/migration_standards.md
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
    protected ?string $connection = 'mysql';

    /**
     * Classe del modello associato.
     *
     * @var string|null
     */
    protected ?string $model_class = Translation::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                // Definizione dei campi
                
                // Utilizziamo updateTimestamps per gestire created_at, updated_at e deleted_at
                $this->updateTimestamps($table, true);
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Verifiche e aggiornamenti
                
                $this->updateTimestamps($table, true);
            }
        );
    }
};
```

## Proprietà Obbligatorie

### 1. `$table`

**Definizione**: Nome della tabella nel database
**Esempio**: `protected string $table = 'language_lines';`

### 2. `$connection`

**Definizione**: Connessione al database da utilizzare
**Valori possibili**:
- `'mysql'` - Connessione principale (default)
- `'user'` - Connessione per dati utente
- `'tenant'` - Connessione per dati tenant

### 3. `$model_class`

**Definizione**: Classe del modello Eloquent associato
**Esempio**: `protected ?string $model_class = Translation::class;`

## Tabelle Specifiche del Modulo Lang

### 1. `language_lines`

Tabella principale per le traduzioni:

```php
protected string $table = 'language_lines';
protected ?string $connection = 'mysql';
protected ?string $model_class = Translation::class;
```

**Campi**:
- `id` - Chiave primaria
- `group` - Gruppo di traduzione (es. validation, auth)
- `key` - Chiave di traduzione
- `text` - Testo tradotto in formato JSON
- `locale` - Locale della lingua (es. en, it, de)
- `created_at`, `updated_at`, `deleted_at` - Timestamps

**Indici**:
- `group` - Indice per ottimizzare le query per gruppo
- `locale` - Indice per ottimizzare le query per lingua
- `language_lines_unique` - Indice unique su (group, key, locale)

### 2. `translation_groups`

Tabella per i gruppi di traduzione:

```php
protected string $table = 'translation_groups';
protected ?string $connection = 'mysql';
protected ?string $model_class = TranslationGroup::class;
```

### 3. `translation_keys`

Tabella per le chiavi di traduzione:

```php
protected string $table = 'translation_keys';
protected ?string $connection = 'mysql';
protected ?string $model_class = TranslationKey::class;
```

## Best Practices Specifiche

### 1. Gestione delle Traduzioni JSON

```php
// ✅ Corretto - Campo JSON per le traduzioni
$table->json('text')->comment('Translation text in JSON format');

// ❌ Sbagliato - Campo text semplice
$table->text('text');
```

### 2. Indici per Performance

```php
// Indici per ottimizzare le query più frequenti
$table->string('group')->index();
$table->string('locale')->index();
$table->unique(['group', 'key', 'locale'], 'language_lines_unique');
```

### 3. Commenti Descriptivi

```php
$table->string('group')->index()->comment('Translation group (e.g., validation, auth)');
$table->string('key')->comment('Translation key');
$table->json('text')->comment('Translation text in JSON format');
$table->string('locale')->index()->comment('Language locale (e.g., en, it, de)');
```

### 4. Verifica Esistenza Colonne

```php
$this->tableUpdate(
    function (Blueprint $table): void {
        if (! $this->hasColumn('group')) {
            $table->string('group')->index()->comment('Translation group');
        }
        
        if (! $this->hasColumn('key')) {
            $table->string('key')->comment('Translation key');
        }
        
        // Verifica indice unique
        if (! $this->hasIndex('language_lines_unique')) {
            $table->unique(['group', 'key', 'locale'], 'language_lines_unique');
        }
        
        $this->updateTimestamps($table, true);
    }
);
```

## Errori Comuni e Correzioni

### 1. Mancanza delle Proprietà Obbligatorie

**❌ Errore**:
```php
return new class extends XotBaseMigration
{
    public function up(): void
    {
        // Mancano le proprietà $table e $connection
    }
};
```

**✅ Correzione**:
```php
return new class extends XotBaseMigration
{
    protected string $table = 'language_lines';
    protected ?string $connection = 'mysql';
    protected ?string $model_class = Translation::class;
    
    public function up(): void
    {
        // ...
    }
};
```

### 2. Campo JSON Non Definito Correttamente

**❌ Errore**:
```php
$table->text('text'); // Campo text semplice
```

**✅ Correzione**:
```php
$table->json('text')->comment('Translation text in JSON format');
```

### 3. Mancanza di Indici

**❌ Errore**:
```php
$table->string('group'); // Senza indice
$table->string('locale'); // Senza indice
```

**✅ Correzione**:
```php
$table->string('group')->index();
$table->string('locale')->index();
$table->unique(['group', 'key', 'locale'], 'language_lines_unique');
```

### 4. Timestamps Non Gestiti

**❌ Errore**:
```php
// Mancano i timestamp
```

**✅ Correzione**:
```php
$this->updateTimestamps($table, true); // Include soft delete
```

## Esempio Completo Corretto

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Lang\Models\Translation;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Migrazione per la creazione della tabella language_lines.
 * 
 * Questa tabella gestisce le traduzioni del sistema multilanguage,
 * memorizzando le chiavi di traduzione e i testi in formato JSON
 * per supportare multiple lingue.
 * 
 * @see docs/migration_standards.md
 */
return new class extends XotBaseMigration
{
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

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->string('group')->index()->comment('Translation group (e.g., validation, auth)');
                $table->string('key')->comment('Translation key');
                $table->json('text')->comment('Translation text in JSON format');
                $table->string('locale')->index()->comment('Language locale (e.g., en, it, de)');
                $table->unique(['group', 'key', 'locale'], 'language_lines_unique');
                
                // Utilizziamo updateTimestamps per gestire created_at, updated_at e deleted_at
                $this->updateTimestamps($table, true);
            }
        );

        // -- UPDATE --
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
    }
};
```

## Conclusione

Seguire queste best practices per le migrazioni del modulo Lang garantisce:

- ✅ **Coerenza** con gli standard del progetto
- ✅ **Performance** ottimizzate con indici appropriati
- ✅ **Manutenibilità** con codice ben documentato
- ✅ **Robustezza** con verifiche di esistenza
- ✅ **Scalabilità** per supportare multiple lingue

Consultare sempre la documentazione generale delle migrazioni in `Modules/Xot/docs/migration_standards.md` per ulteriori dettagli. 
