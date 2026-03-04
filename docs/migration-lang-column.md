# Migration Lang Column - User Module

## Aggiunta Colonna lang alla Tabella users

La colonna `lang` memorizza la preferenza linguistica dell'utente.

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
        // La tabella users esiste già, aggiorniamo solo
        $this->tableUpdate(function (Blueprint $table): void {
            // Aggiunge lang solo se non esiste
            if (!$this->hasColumn('lang')) {
                $table->string('lang', 5)->default('it')->after('state');
            }
        });
    }
};
```

### Metodo hasColumn() di XotBaseMigration

XotBaseMigration fornisce `hasColumn()` che:
- Verifica automaticamente sulla connessione corretta
- Usa `Schema::connection($this->model->getConnectionName())->hasColumn()`
- **NON serve** implementare metodo custom

### ❌ Anti-Pattern da Evitare

```php
// ❌ ERRATO - Metodo hasColumn() custom
private function hasColumn(string $column): bool
{
    $connection = Schema::connection('user')->getConnection();
    $result = $connection->select('SHOW COLUMNS FROM users WHERE Field = ?', [$column]);
    return !empty($result);
}

// ❌ ERRATO - Usa Schema::connection() manualmente
Schema::connection('user')->table('users', function (Blueprint $table): void {
    if (!Schema::hasColumn('users', 'lang')) {
        $table->string('lang', 5)->default('it');
    }
});

// ❌ ERRATO - Implementa down()
public function down(): void {
    Schema::connection('user')->table('users', function (Blueprint $table): void {
        $table->dropColumn('lang');
    });
}
```

### Perché NON Usare Metodi Custom

XotBaseMigration già fornisce tutti i metodi necessari:

```php
// ✅ Metodi disponibili in XotBaseMigration
$this->hasColumn('lang')           // Verifica esistenza colonna
$this->getColumnType('lang')       // Ottiene tipo colonna
$this->hasTable('users')           // Verifica esistenza tabella
$this->getConn()                   // Ottiene Schema Builder con connessione corretta
```

### Gestione Connessioni

XotBaseMigration gestisce automaticamente:
- `Modules\User\Models\User` → connessione `'user'`
- Metodo `getConn()` restituisce `Schema::connection('user')`
- **NON serve** specificare manualmente la connessione

### Esempio Completo: Aggiunta Colonna lang

La migrazione originale `create_users_table.php` già include la logica:

```php
return new class extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(static function (Blueprint $table): void {
            $table->string('id', 36)->primary();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            // ... altri campi
        });

        $this->tableUpdate(function (Blueprint $table): void {
            // Aggiunge lang se non esiste
            if (!$this->hasColumn('lang')) {
                $table->string('lang', 3)->nullable();
            }
            
            // Aggiunge state se non esiste
            if (!$this->hasColumn('state')) {
                $table->string('state')->default('active')->after('type');
            }
            
            $this->updateTimestamps($table, true);
        });
    }
};
```

**NOTA**: La colonna `lang` è già gestita nella migrazione originale. Non serve una migrazione separata.

### Strategia Corretta per Nuove Colonne

1. **Verificare migrazione originale**: Controllare se la colonna è già gestita
2. **Se già presente**: Non creare nuova migrazione
3. **Se mancante**: Aggiornare la migrazione originale con nuovo timestamp
4. **Sempre usare**: `if (!$this->hasColumn(...))` per sicurezza

## Convenzione Naming Migrazioni

**IMPORTANTE**: Tutte le migrazioni DEVONO seguire il pattern:

```
YYYY_MM_DD_HHMMSS_create_{table_name}_table.php
```

Per la tabella users, il nome corretto è `create_users_table.php`, non `add_lang_column.php` o `add_lang_to_users_table.php`.

### Motivazione
- XotBaseMigration estrae il nome del modello dal nome file
- Pattern: `create_users_table.php` → modello `User`
- Coerenza con tutte le altre migrazioni del progetto
- Anche le modifiche usano `create_` nel nome file

## Collegamenti

- [Xot Migration Philosophy](../../Xot/docs/migration-philosophy.md)
- [User Migration Best Practices](./migration-best-practices.md)
- [Root Migration Rules](../../../.windsurf/rules/migration-complete-rules.md)

*
