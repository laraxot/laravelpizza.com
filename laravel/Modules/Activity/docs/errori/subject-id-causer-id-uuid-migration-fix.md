# Fix: subject_id e causer_id devono supportare UUID

## Problema

I test Activity falliscono con:

```
SQLSTATE[01000]: Warning: 1265 Data truncated for column 'subject_id' at row 1
SQLSTATE[HY000]: General error: 1366 Incorrect integer value: 'ea5a5c92-...' for column 'subject_id'
```

**Causa**: La tabella `activity_log` è stata creata con `nullableMorphs()` che genera colonne `subject_id` e `causer_id` come `unsignedBigInteger`. Il modello `User` usa UUID come primary key. Inserire un UUID in una colonna bigint causa l'errore.

## Soluzione

La migrazione `2024_01_01_000002_create_activity_table.php` deve convertire **sia** `subject_id` **che** `causer_id` in `string(36)` nel blocco `tableUpdate`:

```php
$this->tableUpdate(function (Blueprint $table): void {
    if ($this->hasColumn('subject_id')) {
        $table->string('subject_id', 36)->nullable()->change()->index();
    }
    if ($this->hasColumn('subject_type')) {
        $table->string('subject_type')->nullable()->change();
    }
    if ($this->hasColumn('causer_id')) {
        $table->string('causer_id', 36)->nullable()->change()->index();
    }
    if ($this->hasColumn('causer_type')) {
        $table->string('causer_type')->nullable()->change();
    }
    $this->updateTimestamps($table, true);
});
```

## Migrate sul DB di test

Prima di eseguire i test, migrare il DB di test:

```bash
APP_ENV=testing DB_DATABASE=<nome progetto>_data_test DB_DATABASE_USER=<nome progetto>_user_test php artisan migrate:fresh --force (.) 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)APP_ENV=testing DB_DATABASE=<nome progetto>_data_test DB_DATABASE_USER=<nome progetto>_user_test php artisan migrate:fresh --force
APP_ENV=testing DB_DATABASE=<nome progetto>_data_test DB_DATABASE_USER=<nome progetto>_user_test php artisan migrate:fresh --force
APP_ENV=testing DB_DATABASE=<nome progetto>_data_test DB_DATABASE_USER=<nome progetto>_user_test php artisan migrate:fresh --force
APP_ENV=testing DB_DATABASE=laravelpizza_data_test DB_DATABASE_USER=laravelpizza_user_test php artisan migrate:fresh --force
APP_ENV=testing DB_DATABASE=<nome progetto>_data_test DB_DATABASE_USER=<nome progetto>_user_test php artisan migrate:fresh --force
APP_ENV=testing DB_DATABASE=laravelpizza_data_test DB_DATABASE_USER=laravelpizza_user_test php artisan migrate:fresh --force
APP_ENV=testing DB_DATABASE=<nome progetto>_data_test DB_DATABASE_USER=<nome progetto>_user_test php artisan migrate:fresh --force
```

## Riferimenti

- [migration-spatie-integration.md](./migration-spatie-integration.md)
- [errori-migrazione-activity-table-lezioni-1.md](./archive/errori-migrazione-activity-table-lezioni-1.md)
