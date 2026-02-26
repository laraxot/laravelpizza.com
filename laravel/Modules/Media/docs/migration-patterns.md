# Migration Patterns - Media Module

## Conformità XotBaseMigration

Tutte le migrazioni del modulo Media DEVONO seguire i pattern Laraxot standard.

### ✅ Pattern Corretto

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        // CREATE - solo se tabella non esiste
        $this->tableCreate(function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('file_name');
            // ... altri campi
        });

        // UPDATE - aggiunge colonne mancanti
        $this->tableUpdate(function (Blueprint $table): void {
            if (!$this->hasColumn('user_id')) {
                $table->uuid('user_id')->nullable();
            }
            
            $this->updateTimestamps($table, hasSoftDeletes: true);
        });
    }
    
    // NO metodo down() - gestito automaticamente da XotBaseMigration
};
```

### ❌ Anti-Pattern da Evitare

```php
// ❌ ERRATO - Estende Migration invece di XotBaseMigration
use Illuminate\Database\Migrations\Migration;
return new class extends Migration { ... }

// ❌ ERRATO - Implementa metodo down()
public function down(): void { ... }

// ❌ ERRATO - Usa Schema::connection() manualmente
Schema::connection('media')->table(...);

// ❌ ERRATO - Non verifica esistenza colonna
Schema::table('temporary_uploads', function (Blueprint $table) {
    $table->string('file_name'); // Può fallire se già esiste
});
```

### Gestione Connessioni Database

XotBaseMigration gestisce automaticamente le connessioni:
- Namespace `Modules\Media\Models\*` → connessione `'media'`
- Metodo `getConnection()` legge da `$this->model->getConnectionName()`
- **NON serve** specificare manualmente la connessione

### Metodi Helper Disponibili

| Metodo | Scopo |
|--------|-------|
| `tableCreate(Closure $next)` | Crea tabella solo se non esiste |
| `tableUpdate(Closure $next)` | Aggiorna tabella esistente |
| `hasColumn(string $column)` | Verifica esistenza colonna |
| `getColumnType(string $column)` | Ottiene tipo colonna |
| `updateTimestamps(Blueprint $table, bool $hasSoftDeletes)` | Aggiunge timestamp standard |

### Esempio: Aggiunta Colonne a Tabella Esistente

Per `temporary_uploads`, la migrazione corretta è:

```php
return new class extends XotBaseMigration
{
    public function up(): void
    {
        // Crea tabella se non esiste (da migrazione originale)
        $this->tableCreate(function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('session_id');
            $table->uuid('user_id')->nullable();
            $table->string('file_name');
            $table->integer('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('status')->default('uploading');
        });

        // Aggiorna con nuove colonne se necessario
        $this->tableUpdate(function (Blueprint $table): void {
            // Colonne già presenti nella create, nessun aggiornamento necessario
            $this->updateTimestamps($table, hasSoftDeletes: true);
        });
    }
};
```

## Convenzione Naming Migrazioni Laraxot

### Pattern Obbligatorio

**TUTTE** le migrazioni DEVONO seguire il pattern:

```
YYYY_MM_DD_HHMMSS_create_{table_name}_table.php
```

### ✅ Esempi Corretti

```
2026_01_18_152545_create_temporary_uploads_table.php
2026_02_13_163329_create_profiles_table.php
2026_02_13_171410_create_activity_log_table.php
2026_02_13_172135_create_users_table.php
```

### ❌ Naming NON Conforme

```
❌ 2026_01_18_152545_add_columns_to_temporary_uploads_table.php
❌ 2026_02_13_163329_change_profiles_id_to_uuid.php
❌ 2026_02_13_171410_fix_causer_id_to_uuid.php
❌ 2026_02_13_172135_add_lang_column.php
```

### Motivazione

- **Coerenza**: Tutte le migrazioni seguono lo stesso pattern
- **Auto-discovery**: XotBaseMigration estrae il nome del modello dal nome file
- **Manutenibilità**: Facile identificare quale tabella viene gestita
- **DRY**: Una sola convenzione per tutti i tipi di modifica

### Nota Importante

Anche le migrazioni che **modificano** tabelle esistenti devono usare `create_`:
- La logica di creazione va in `tableCreate()`
- La logica di modifica va in `tableUpdate()`
- Il nome file rimane sempre `create_{table_name}_table.php`

## Collegamenti

- [Xot Migration Philosophy](../../Xot/docs/migration-philosophy.md)
- [Xot Migration Base Rules](../../Xot/docs/database/migration-base-rules.md)
- [Root Migration Rules](../../../.windsurf/rules/migration-complete-rules.md)

*Ultimo aggiornamento: 2026-02-26*
