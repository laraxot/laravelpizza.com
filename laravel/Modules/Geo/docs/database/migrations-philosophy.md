# Migration Philosophy — 1 Migrazione per Modello

## La Legge Fondamentale

**Ogni modello ha ESATTAMENTE UN file di migrazione.** Non uno di piu'. Mai.

Questo non e' una convenzione opzionale. E' la filosofia, la politica, la religione, lo zen del progetto.

## Comandi PROIBITI — I Dati sono Sacri

```
# MAI E POI MAI eseguire questi comandi:
php artisan migrate:refresh     # distrugge TUTTO — dati persi per sempre
php artisan migrate:fresh       # droppa TUTTE le tabelle — dati persi per sempre
php artisan migrate --force     # bypassa il prompt di sicurezza — pericoloso
php artisan db:wipe             # droppa TUTTE le tabelle — dati persi per sempre
```

**I dati di produzione sono irreversibili. Non esiste undo.**

## L'Unico Comando Sicuro

```bash
php artisan migrate
```

Esegue SOLO le migrazioni non ancora eseguite. Non tocca mai i dati esistenti.

## Workflow per Modifiche allo Schema

### 1. Trova il modello proprietario della tabella

```php
// Nel modello:
protected $table = 'nome_tabella';
protected $connection = 'nome_connessione';
```

### 2. Trova la UNA migrazione del modello

```
Modules/{NomeModulo}/database/migrations/YYYY_MM_DD_HHMMSS_create_{tabella}_table.php
```

### 3. Studia la migrazione — Pattern XotBaseMigration

```php
return new class extends XotBaseMigration
{
    protected ?string $model_class = NomeModello::class;

    public function up(): void
    {
        // tableCreate: per installazioni fresche
        $this->tableCreate(function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('nuova_colonna')->nullable();
            // ...
        });

        // tableUpdate: per database esistenti (con guards hasColumn)
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('nuova_colonna')) {
                $table->string('nuova_colonna')->nullable()->after('colonna_precedente');
            }
            $this->updateTimestamps($table, true);
        });
    }
};
```

### 4. Rinomina il timestamp del file

Cambia il prefisso timestamp per forzare la riesecuzione:

```
# Prima:
2024_01_01_000002_create_activity_table.php

# Dopo (rinomina con data di oggi):
2026_03_24_000001_create_activity_table.php
```

### 5. Esegui SOLO migrate

```bash
php artisan migrate
```

## Perche' questa filosofia e' bellissima

- **Singola fonte di verita'**: guardi UN file e capisci TUTTA la struttura della tabella
- **Schema evolutivo**: `tableCreate` + `tableUpdate` gestisce sia installazioni fresche che aggiornamenti
- **Idempotente**: `hasColumn()` guards rendono ogni migrazione sicura da rieseguire
- **Zero ambiguita'**: non devi rincorrere 15 file `add_column_*` per ricostruire lo schema

## Anti-Pattern VIETATI

```
# MAI creare questi file:
2026_03_24_add_batch_uuid_to_activity_log.php  ← VIETATO
2026_03_24_add_missing_columns_to_users.php    ← VIETATO
2026_03_24_fix_nullable_on_causer_id.php       ← VIETATO
```

Se trovi questi file nel progetto, sono un errore storico da correggere consolidando nel file principale.
