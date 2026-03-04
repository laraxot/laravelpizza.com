# Migration UUID Conversion - Meetup Module

## Conversione Chiavi da bigint a UUID

Il modulo Meetup utilizza UUID per le chiavi primarie. Le migrazioni devono gestire correttamente la conversione.

### ✅ Pattern Corretto per Conversione UUID

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id(); // Inizialmente bigint
            $table->string('user_id', 36)->index()->nullable();
            // ... altri campi
        });

        $this->tableUpdate(function (Blueprint $table): void {
            // Conversione automatica id da bigint a string(36) per UUID
            if (in_array($this->getColumnType('id'), ['varchar'], strict: true)) {
                $table->id('id')->change();
            }
            
            // Conversione user_id se necessario
            if (in_array($this->getColumnType('user_id'), ['integer'], strict: true)) {
                $table->string('user_id', 36)->index()->nullable()->change();
            }
            
            $this->updateTimestamps($table, hasSoftDeletes: true);
        });
    }
};
```

### Metodo Helper: getColumnType()

XotBaseMigration fornisce `getColumnType()` per verificare il tipo corrente:

```php
// Verifica tipo colonna
$currentType = $this->getColumnType('id');

// Tipi comuni restituiti:
// - 'bigint' → chiave auto-increment
// - 'varchar' → stringa
// - 'integer' → intero
// - 'string' → stringa (alias)
// - 'not-exists' → colonna non esiste
```

### ❌ Anti-Pattern da Evitare

```php
// ❌ ERRATO - Usa Schema::connection() manualmente
Schema::connection('meetup')->table('profiles', function (Blueprint $table) {
    $table->string('id', 36)->change();
});

// ❌ ERRATO - Non verifica tipo corrente
$table->string('id', 36)->change(); // Può fallire se già string

// ❌ ERRATO - Implementa down()
public function down(): void {
    Schema::connection('meetup')->table('profiles', function (Blueprint $table) {
        $table->bigIncrements('id')->change();
    });
}
```

### Gestione Connessioni

XotBaseMigration gestisce automaticamente la connessione:
- `Modules\Meetup\Models\Profile` → connessione `'meetup'`
- Metodo `getConn()` restituisce `Schema::connection('meetup')`
- **NON serve** specificare manualmente `Schema::connection()`

### Esempio Completo: Profiles Table

```php
return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('user_id', 36)->index()->nullable();
            $table->string('first_name')->nullable()->index();
            $table->string('last_name')->nullable()->index();
            $table->string('fiscal_code')->nullable()->index();
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->index();
            $table->text('notes')->nullable();
        });

        $this->tableUpdate(function (Blueprint $table): void {
            // Conversione id se necessario
            if (in_array($this->getColumnType('id'), ['varchar'], strict: true)) {
                $table->id('id')->change();
            }

            // Conversione user_id se necessario
            if (in_array($this->getColumnType('user_id'), ['integer'], strict: true)) {
                $table->string('user_id', 36)->index()->nullable()->change();
            }

            $this->updateTimestamps($table, hasSoftDeletes: true);
        });
    }
};
```

## Convenzione Naming Migrazioni

**IMPORTANTE**: Tutte le migrazioni DEVONO seguire il pattern:

```
YYYY_MM_DD_HHMMSS_create_{table_name}_table.php
```

Anche per modifiche UUID, il nome file deve essere `create_profiles_table.php`, non `change_profiles_id_to_uuid.php`.

### Motivazione
- XotBaseMigration estrae il nome del modello dal nome file
- Pattern: `create_profiles_table.php` → modello `Profile`
- Coerenza con tutte le altre migrazioni del progetto

## Collegamenti

- [Xot Migration Philosophy](../../Xot/docs/migration-philosophy.md)
- [Media Migration Patterns](../../Media/docs/migration-patterns.md)
- [Root Migration Rules](../../../.windsurf/rules/migration-complete-rules.md)

*
