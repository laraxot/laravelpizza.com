# Migration Spatie Activity Log Integration

## Gestione Tabella activity_log

Il modulo Activity utilizza Spatie Laravel Activity Log. La tabella `activity_log` è gestita dal pacchetto ma richiede adattamenti per UUID.

### ✅ Pattern Corretto per activity_log

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        // La tabella è creata dal pacchetto Spatie
        // Questa migrazione aggiorna solo i tipi colonna per UUID
        
        $this->tableUpdate(function (Blueprint $table): void {
            // Conversione causer_id da bigint a string(36) per UUID
            if ($this->hasColumn('causer_id') && $this->getColumnType('causer_id') === 'bigint') {
                $table->string('causer_id', 36)->nullable()->change();
            }
            
            // Conversione subject_id da bigint a string(36) per UUID
            if ($this->hasColumn('subject_id') && $this->getColumnType('subject_id') === 'bigint') {
                $table->string('subject_id', 36)->nullable()->change();
            }
        });
    }
};
```

### Verifica Tipo Colonna Prima della Conversione

Sempre verificare il tipo corrente prima di modificare:

```php
// ✅ CORRETTO - Verifica tipo prima di cambiare
if ($this->hasColumn('causer_id') && $this->getColumnType('causer_id') === 'bigint') {
    $table->string('causer_id', 36)->nullable()->change();
}

// ❌ ERRATO - Cambia senza verificare
$table->string('causer_id', 36)->nullable()->change(); // Può fallire se già string
```

### ❌ Anti-Pattern da Evitare

```php
// ❌ ERRATO - Usa Schema::connection() manualmente
Schema::connection('activity')->table('activity_log', function (Blueprint $table): void {
    $table->string('causer_id', 36)->nullable()->change();
});

// ❌ ERRATO - Implementa down()
public function down(): void {
    Schema::connection('activity')->table('activity_log', function (Blueprint $table): void {
        $table->unsignedBigInteger('causer_id')->nullable()->change();
    });
}

// ❌ ERRATO - Non verifica esistenza colonna
$table->string('causer_id', 36)->nullable()->change(); // Può fallire se colonna non esiste
```

### Gestione Connessioni

XotBaseMigration gestisce automaticamente:
- `Modules\Activity\Models\*` → connessione `'activity'`
- Metodo `getConn()` restituisce `Schema::connection('activity')`
- **NON serve** specificare manualmente la connessione

### Metodi Helper Utilizzati

| Metodo | Scopo | Esempio |
|--------|-------|---------|
| `hasColumn(string $column)` | Verifica esistenza colonna | `if ($this->hasColumn('causer_id'))` |
| `getColumnType(string $column)` | Ottiene tipo colonna | `$this->getColumnType('causer_id') === 'bigint'` |
| `tableUpdate(Closure $next)` | Aggiorna tabella esistente | `$this->tableUpdate(function ...)` |

### Integrazione con Spatie Activity Log

Il pacchetto Spatie crea la tabella con questa struttura:

```sql
CREATE TABLE activity_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    log_name VARCHAR(255),
    description TEXT,
    subject_type VARCHAR(255),
    subject_id BIGINT UNSIGNED,  -- Da convertire a string(36)
    causer_type VARCHAR(255),
    causer_id BIGINT UNSIGNED,   -- Da convertire a string(36)
    properties JSON,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

La nostra migrazione converte solo `causer_id` e `subject_id` per supportare UUID.

## Convenzione Naming Migrazioni

**IMPORTANTE**: Tutte le migrazioni DEVONO seguire il pattern:

```
YYYY_MM_DD_HHMMSS_create_{table_name}_table.php
```

Per activity_log, il nome corretto è `create_activity_log_table.php`, non `fix_causer_id_to_uuid.php`.

### Motivazione
- XotBaseMigration estrae il nome del modello dal nome file
- Pattern: `create_activity_log_table.php` → modello `ActivityLog`
- Coerenza con tutte le altre migrazioni del progetto

## Collegamenti

- [Spatie Laravel Activity Log](https://github.com/spatie/laravel-activitylog)
- [Xot Migration Philosophy](../../Xot/docs/migration-philosophy.md)
- [Root Migration Rules](../../../.windsurf/rules/migration-complete-rules.md)

*Ultimo aggiornamento: 2026-02-26*
