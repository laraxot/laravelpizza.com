# Linee Guida per i Database in Laraxot

Questo documento definisce le best practices per la gestione dei database nel framework Laraxot, inclusa la documentazione, la creazione di modelli e le migrazioni.

## Struttura del Database

### 1. Convenzioni di Nomenclatura

#### Tabelle
- Utilizzare il singolare per le tabelle principali (es. `socio`, `sezione`)
- Utilizzare il plurale per le tabelle pivot (es. `socio_convenzioni`)
- Preferire nomi descrittivi completi piuttosto che abbreviazioni
- Utilizzare underscore per separare le parole (es. `stato_socio`)

#### Colonne
- Chiavi primarie: `id_nome_tabella` (es. `id_socio`, `id_sezione`)
- Chiavi esterne: stesso nome della chiave primaria della tabella referenziata (es. `id_socio`, `id_sezione`)
- Timestamp standard: `created_at`, `updated_at`, `deleted_at`
- Booleani: prefisso `is_` o `has_` (es. `is_active`, `has_documents`)
- Date: suffisso `_at` per datetime, `_date` per date (es. `registration_at`, `birth_date`)

### 2. Tipi di Dati

Per garantire coerenza e compatibilità:

| Concetto | MySQL/MariaDB | In Laravel |
|---------|--------------|------------|
| ID | BIGINT UNSIGNED | bigIncrements() |
| Chiavi esterne | BIGINT UNSIGNED | unsignedBigInteger() |
| Booleani | TINYINT(1) | boolean() |
| Piccoli numeri interi | SMALLINT | smallInteger() |
| Numeri interi | INT | integer() |
| Grandi numeri interi | BIGINT | bigInteger() |
| Decimali | DECIMAL(8,2) | decimal('amount', 8, 2) |
| Stringhe brevi | VARCHAR(255) | string() |
| Stringhe medie | VARCHAR(1000) | string('description', 1000) |
| Testi lunghi | TEXT | text() |
| Testi molto lunghi | LONGTEXT | longText() |
| JSON | JSON | json() |
| Date | DATE | date() |
| Datetime | DATETIME | dateTime() |
| Timestamp | TIMESTAMP | timestamp() |
| Enumerazioni | ENUM | enum('field', ['option1', 'option2']) |

## Documentazione dello Schema

### 1. Schema JSON

Per ogni database, mantenere un file `schema.json` aggiornato che descrive la struttura completa:

```json
{
  "nome_tabella": {
    "columns": {
      "id_nome_tabella": {
        "type": "bigint(20) unsigned",
        "nullable": false,
        "primary": true,
        "auto_increment": true,
        "description": "Chiave primaria identificativa"
      },
      "nome_colonna": {
        "type": "varchar(255)",
        "nullable": true,
        "description": "Descrizione del significato di questa colonna"
      },
      ...
    },
    "indexes": {
      "primary": {
        "columns": ["id_nome_tabella"],
        "type": "PRIMARY"
      },
      "fk_tabella_relazione": {
        "columns": ["id_relazione"],
        "type": "INDEX"
      },
      ...
    },
    "foreign_keys": {
      "fk_nome_relazione": {
        "columns": ["id_relazione"],
        "references": {
          "table": "tabella_referenziata",
          "columns": ["id_tabella_referenziata"]
        },
        "on_update": "CASCADE",
        "on_delete": "RESTRICT"
      },
      ...
    },
    "description": "Questa tabella contiene dati relativi a..."
  },
  ...
}
```

### 2. Documentazione Markdown

Generare e mantenere aggiornata una documentazione dettagliata in formato Markdown per ogni tabella del database:

```markdown

## Tabella: nome_tabella

**Descrizione:** Questa tabella contiene dati relativi a...

### Colonne

| Nome | Tipo | Nullable | Default | Descrizione |
|------|------|----------|---------|-------------|
| id_nome_tabella | BIGINT UNSIGNED | No | AUTO_INCREMENT | Chiave primaria identificativa |
| nome_colonna | VARCHAR(255) | Sì | NULL | Descrizione del significato di questa colonna |
| ... | ... | ... | ... | ... |

### Indici

| Nome | Colonne | Tipo |
|------|---------|------|
| PRIMARY | id_nome_tabella | PRIMARY KEY |
| fk_tabella_relazione | id_relazione | INDEX |
| ... | ... | ... |

### Chiavi Esterne

| Nome | Colonne | Tabella referenziata | Colonne referenziate | On Update | On Delete |
|------|---------|----------------------|---------------------|-----------|-----------|
| fk_nome_relazione | id_relazione | tabella_referenziata | id_tabella_referenziata | CASCADE | RESTRICT |
| ... | ... | ... | ... | ... | ... |
```

### 3. Diagrammi ER

Mantenere diagrammi ER aggiornati per visualizzare le relazioni tra le tabelle:

- Utilizzare strumenti come MySQL Workbench, dbdiagram.io o Lucidchart
- Salvare i diagrammi in formato immagine nella cartella `docs/assets`
- Includere i diagrammi nella documentazione con riferimenti espliciti

## Creazione e Gestione dei Modelli

### 1. Struttura Base dei Modelli

Ogni modello dovrebbe seguire questa struttura base:

```php
<?php

namespace Modules\NomeModulo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NomeModello extends Model
{
    /**
     * Nome della tabella associata al modello.
     *
     * @var string
     */
    protected $table = 'nome_tabella';

    /**
     * Nome della chiave primaria associata alla tabella.
     *
     * @var string
     */
    protected $primaryKey = 'id_nome_tabella';

    /**
     * Indica se il modello debba essere timestampato.
     *
     * @var bool
     */
    public $timestamps = true; // o false se la tabella non ha i campi created_at e updated_at

    /**
     * Connessione del database da utilizzare.
     *
     * @var string
     */
    protected $connection = 'nome_connessione'; // se diversa dalla default

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'campo1',
        'campo2',
        // ...
    ];

    /**
     * Gli attributi che dovrebbero essere nascosti per gli array.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'campo_sensibile',
        // ...
    ];

    /**
     * Gli attributi che dovrebbero essere convertiti.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'dati_json' => 'array',
        'data_nascita' => 'date',
        'created_at' => 'datetime',
        // ...
    ];

    /**
     * Gli attributi che dovrebbero essere considerati date.
     *
     * @var array<int, string>
     */
    protected $dates = [
        'data_inizio',
        'data_fine',
        // ...
    ];

    // Relazioni e metodi...
}

## Linee guida sulle Migrazioni

Le migrazioni dei moduli Xot devono seguire le seguenti regole per garantire compatibilità, modularità e compliance con PHPStan livello 10.

## Regola sulle classi anonime
Tutte le migrazioni devono essere dichiarate come **classi anonime** restituite da:

```php
return new class extends XotBaseMigration {
    // ...
};
```

**Mai usare classi nominali:**
```php
// Sbagliato
class CreatePerformanceOptionsTable extends XotBaseMigration {}
```

### Motivazione
- Evita collisioni di nomi
- Favorisce modularità, override, fallback
- Compatibilità con Laravel 8+ e WindSurf
- Compliance PHPStan livello 10

### Warning
- Le classi nominali possono causare errori in ambienti multi-tenant/modulari

### Esempio pratico
```php
return new class extends XotBaseMigration {
    public function up(): void { /* ... */ }
    public function down(): void { /* ... */ }
};
```

**Collegamenti:**
- [Regola Performance](../../Performance/project_docs/database_migrations.md)
- [Regole globali root](../../../project_docs/database_migrations.md)

    /**
     * Ottiene la sezione associata al socio.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sezione(): BelongsTo
    {
        return $this->belongsTo(Sezione::class, 'id_sezione', 'id_sezione');
    }

    /**
     * Ottiene le convenzioni associate al socio.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function convenzioni(): HasMany
    {
        return $this->hasMany(SocioRichiestaConvenzione::class, 'id_socio', 'id_socio');
    }
```

### 2. Documentazione delle Relazioni

Le relazioni tra modelli dovrebbero essere chiaramente documentate nel codice:

```php
/**
 * Ottiene la sezione associata al socio.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function sezione(): BelongsTo
{
    return $this->belongsTo(Sezione::class, 'id_sezione', 'id_sezione');
}

/**
 * Ottiene le convenzioni associate al socio.
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function convenzioni(): HasMany
{
    return $this->hasMany(SocioRichiestaConvenzione::class, 'id_socio', 'id_socio');
}
```

### 3. Scopes e Metodi Accessori

Documentare chiaramente gli scopes e i metodi accessori:

```php
/**
 * Scope per filtrare i soci attivi.
 *
 * @param \Illuminate\Database\Eloquent\Builder $query
 * @return \Illuminate\Database\Eloquent\Builder
 */
public function scopeAttivi($query)
{
    return $query->where('is_active', true);
}

/**
 * Get il nome completo del socio.
 *
 * @return string
 */
public function getNomeCompletoAttribute(): string
{
    return "{$this->nome} {$this->cognome}";
}
```

## Migrazioni e Gestione delle Versioni

### 1. Struttura delle Migrazioni

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Nome della tabella.
     *
     * @var string
     */
    protected $table = 'nome_tabella';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id('id_nome_tabella');
            $table->string('nome', 255)->nullable()->comment('Nome del record');
            // Altri campi...
            
            // Indici
            $table->index('campo_indicizzato');
            
            // Chiavi esterne
            $table->foreignId('id_relazione')
                ->constrained('tabella_relazione', 'id_tabella_relazione')
                ->onUpdate('cascade')
                ->onDelete('restrict');
                
            $table->timestamps(); // created_at e updated_at
        });
        
        // Commento sulla tabella
        DB::statement("ALTER TABLE `{$this->table}` COMMENT = 'Descrizione della tabella'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
```

### 2. Versionamento e Deployment

- Nominare le migrazioni con un prefisso timestamp: `2023_01_15_create_nome_tabella_table.php`
- Non modificare mai una migrazione pubblicata in produzione; creare invece una nuova migrazione
- Documentare le modifiche significative nei commenti della migrazione

```php
/**
 * Migrate name_field da VARCHAR(100) a VARCHAR(255) per supportare nomi più lunghi.
 * Aggiunge anche l'indice su questo campo per migliorare le performance delle query.
 *
 * Issue correlata: #123
 */
public function up(): void
{
    Schema::table($this->table, function (Blueprint $table) {
        $table->string('name_field', 255)->change();
        $table->index('name_field');
    });
}
```

## Strumenti e Comandi Utili

### 1. Generazione Documentazione

```bash

# Genera documentazione dello schema da un file JSON
php artisan xot:generate-db-documentation /path/to/schema.json /path/to/output

# Genera diagramma ER
php artisan schema:generate-diagram --tables=tabella1,tabella2 --path=/path/to/output
```

### 2. Analisi del Database

```bash

# Esporta lo schema del database in JSON
php artisan db:export-schema --connection=nome_connessione --output=/path/to/output.json

# Compara schemi di database
php artisan db:compare-schema /path/to/schema1.json /path/to/schema2.json

# Analizza tabelle e colonne non utilizzate
php artisan db:analyze-usage --connection=nome_connessione
```

## Ottimizzazione e Best Practices

### 1. Performance

- Indici per colonne frequentemente utilizzate nelle clausole WHERE e JOIN
- Evitare indici eccessivi che rallentano le INSERT e UPDATE
- Utilizzare correttamente i tipi di dati (es. BIGINT solo quando necessario)
- Preferire INT o BIGINT rispetto a VARCHAR per le chiavi esterne

### 2. Integrità dei Dati

- Definire vincoli di integrità referenziale a livello di database
- Utilizzare vincoli CHECK quando possibile per validazioni a livello di database
- Definire valori DEFAULT appropriati
- Utilizzare l'attributo UNSIGNED per i campi numerici che non possono essere negativi

### 3. Migrazioni

- Creare migrazioni atomiche che si concentrano su un singolo aspetto
- Testare le migrazioni in ambiente di sviluppo prima del deploy
- Includere sempre il metodo `down()` che ripristina esattamente lo stato precedente
- Utilizzare transaction per le migrazioni complesse

## Troubleshooting Comune

### 1. Problemi di Relazioni

- Verificare che i tipi di dati delle colonne in relazione corrispondano esattamente
- Controllare che le chiavi esterne siano definite correttamente
- Assicurarsi che i nomi delle tabelle e delle colonne siano scritti correttamente nei metodi di relazione

### 2. Problemi di Performance

- Analizzare le query lente con EXPLAIN
- Verificare che ci siano indici appropriati
- Controllare che i tipi di dati siano ottimali per l'uso previsto
- Utilizzare query builder o raw queries per query complesse
